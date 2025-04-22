<?php
// Include session handler
include '../session_handler.php';

// Include database connection
require_once '../config/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Return error for AJAX requests
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Get the action from the request
$action = isset($_POST['action']) ? $_POST['action'] : '';

try {
    switch ($action) {
        case 'save_workout':
            saveWorkout();
            break;
        case 'get_workouts':
            getWorkouts();
            break;
        case 'get_workout_details':
            getWorkoutDetails();
            break;
        case 'delete_workout':
            deleteWorkout();
            break;
        default:
            // Invalid action
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} catch (PDOException $e) {
    // Return error for AJAX requests
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}

// Save a workout
function saveWorkout() {
    global $conn;
    
    // Get workout data
    $workoutData = isset($_POST['workout']) ? json_decode($_POST['workout'], true) : null;
    $shareOnFeed = isset($_POST['share_on_feed']) ? (bool)$_POST['share_on_feed'] : false;
    
    if (!$workoutData) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'No workout data provided']);
        return;
    }
    
    // Begin transaction
    $conn->beginTransaction();
    
    try {
        // Insert workout session
        $stmt = $conn->prepare("
            INSERT INTO workout_sessions (user_id, session_date, session_name, duration, notes)
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $_SESSION['user_id'],
            $workoutData['date'],
            $workoutData['name'],
            $workoutData['duration'],
            $workoutData['notes']
        ]);
        
        $sessionId = $conn->lastInsertId();
        
        // Insert exercises
        if (isset($workoutData['exercises']) && is_array($workoutData['exercises'])) {
            $stmt = $conn->prepare("
                INSERT INTO workout_exercises (session_id, exercise_id, sets, reps, weight, notes)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            foreach ($workoutData['exercises'] as $exercise) {
                // Get or create exercise
                $exerciseId = getOrCreateExercise($exercise['name'], $exercise['category'] ?? 'Other');
                
                $stmt->execute([
                    $sessionId,
                    $exerciseId,
                    $exercise['sets'],
                    $exercise['reps'],
                    $exercise['weight'] ?? null,
                    $exercise['notes'] ?? null
                ]);
            }
        }
        
        // Commit transaction
        $conn->commit();
        
        // Share on social feed if requested
        if ($shareOnFeed) {
            shareWorkoutOnFeed($sessionId, $workoutData);
        }
        
        // Success
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true, 
            'message' => 'Workout saved successfully',
            'session_id' => $sessionId
        ]);
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollBack();
        throw $e;
    }
}

// Get all workouts for the current user
function getWorkouts() {
    global $conn;
    
    $stmt = $conn->prepare("
        SELECT * FROM workout_sessions
        WHERE user_id = ?
        ORDER BY session_date DESC
    ");
    
    $stmt->execute([$_SESSION['user_id']]);
    $workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'workouts' => $workouts]);
}

// Get details of a specific workout
function getWorkoutDetails() {
    global $conn;
    
    $workoutId = filter_input(INPUT_POST, 'workout_id', FILTER_VALIDATE_INT);
    
    if (!$workoutId) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid workout ID']);
        return;
    }
    
    // Get workout session
    $stmt = $conn->prepare("
        SELECT ws.*, u.firstname, u.lastname, u.profile_image
        FROM workout_sessions ws
        JOIN users u ON ws.user_id = u.user_id
        WHERE ws.session_id = ?
    ");
    
    $stmt->execute([$workoutId]);
    $workout = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$workout) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Workout not found']);
        return;
    }
    
    // Get exercises
    $stmt = $conn->prepare("
        SELECT we.*, e.name, e.muscle_group, e.difficulty_level
        FROM workout_exercises we
        JOIN exercises e ON we.exercise_id = e.exercise_id
        WHERE we.session_id = ?
    ");
    
    $stmt->execute([$workoutId]);
    $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $workout['exercises'] = $exercises;
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'workout' => $workout]);
}

// Delete a workout
function deleteWorkout() {
    global $conn;
    
    $workoutId = filter_input(INPUT_POST, 'workout_id', FILTER_VALIDATE_INT);
    
    if (!$workoutId) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid workout ID']);
        return;
    }
    
    // Check if the workout belongs to the current user
    $stmt = $conn->prepare("SELECT user_id FROM workout_sessions WHERE session_id = ?");
    $stmt->execute([$workoutId]);
    $workout = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$workout || $workout['user_id'] != $_SESSION['user_id']) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'You are not authorized to delete this workout']);
        return;
    }
    
    // Begin transaction
    $conn->beginTransaction();
    
    try {
        // Delete related social posts
        $stmt = $conn->prepare("DELETE FROM social_posts WHERE workout_id = ?");
        $stmt->execute([$workoutId]);
        
        // Delete workout exercises
        $stmt = $conn->prepare("DELETE FROM workout_exercises WHERE session_id = ?");
        $stmt->execute([$workoutId]);
        
        // Delete workout session
        $stmt = $conn->prepare("DELETE FROM workout_sessions WHERE session_id = ?");
        $stmt->execute([$workoutId]);
        
        // Commit transaction
        $conn->commit();
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Workout deleted successfully']);
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollBack();
        throw $e;
    }
}

// Helper functions

// Get exercise ID by name or create if it doesn't exist
function getOrCreateExercise($name, $category) {
    global $conn;
    
    // Look for existing exercise
    $stmt = $conn->prepare("SELECT exercise_id FROM exercises WHERE name = ?");
    $stmt->execute([$name]);
    $exercise = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($exercise) {
        return $exercise['exercise_id'];
    }
    
    // Create new exercise
    $stmt = $conn->prepare("
        INSERT INTO exercises (name, muscle_group, difficulty_level)
        VALUES (?, ?, 'intermediate')
    ");
    
    $stmt->execute([$name, $category]);
    
    return $conn->lastInsertId();
}

// Share workout on social feed
function shareWorkoutOnFeed($workoutId, $workoutData) {
    global $conn;
    
    // Generate post content
    $exerciseCount = count($workoutData['exercises'] ?? []);
    $duration = formatDuration($workoutData['duration']);
    
    $content = "Just completed a workout: " . htmlspecialchars($workoutData['name']) . ".\n";
    $content .= "Duration: " . $duration . ".\n";
    $content .= "Exercises: " . $exerciseCount . ".\n";
    
    if (!empty($workoutData['notes'])) {
        $content .= "Notes: " . htmlspecialchars($workoutData['notes']);
    }
    
    // Create post
    $stmt = $conn->prepare("
        INSERT INTO social_posts (user_id, content, created_at)
        VALUES (?, ?, NOW())
    ");
    
    $stmt->execute([
        $_SESSION['user_id'],
        $content
    ]);
    
    return $conn->lastInsertId();
}

// Format duration from seconds to readable time
function formatDuration($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    
    $parts = [];
    
    if ($hours > 0) {
        $parts[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
    }
    
    if ($minutes > 0) {
        $parts[] = $minutes . ' minute' . ($minutes > 1 ? 's' : '');
    }
    
    if ($seconds > 0 && count($parts) < 2) {
        $parts[] = $seconds . ' second' . ($seconds > 1 ? 's' : '');
    }
    
    return implode(' and ', $parts);
} 