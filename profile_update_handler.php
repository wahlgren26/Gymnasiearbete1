<?php
// Include session and database connection
include 'session_handler.php';
require_once 'config/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/signin.php");
    exit();
}

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get and validate input data
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_SPECIAL_CHARS);
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
    $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_INT);
    $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
    
    // Validate required fields
    if (empty($firstname) || empty($lastname) || empty($email)) {
        $_SESSION['profile_error'] = "First name, last name and email are required fields.";
        header("Location: editprofile.php");
        exit();
    }
    
    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['profile_error'] = "Invalid email address.";
        header("Location: editprofile.php");
        exit();
    }
    
    try {
        // Check if email is already used by another user
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
        $stmt->execute([$email, $_SESSION['user_id']]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['profile_error'] = "The email address is already used by another account.";
            header("Location: editprofile.php");
            exit();
        }
        
        // Update user information
        $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ?, bio = ?, age = ?, height = ?, weight = ? WHERE user_id = ?");
        $stmt->execute([$firstname, $lastname, $email, $bio, $age, $height, $weight, $_SESSION['user_id']]);
        
        // Update session information
        $_SESSION['firstname'] = $firstname;
        
        // Save progress tracker setting if it exists in form data
        if (isset($_POST['show_progress_tracker'])) {
            $show_progress_tracker = isset($_POST['show_progress_tracker']) ? 1 : 0;
            $stmt = $conn->prepare("
                UPDATE users 
                SET show_progress_tracker = ? 
                WHERE user_id = ?
            ");
            $stmt->execute([$show_progress_tracker, $_SESSION['user_id']]);
            $_SESSION['show_progress_tracker'] = (bool)$show_progress_tracker;
        }
        
        // If the user has uploaded a new profile image
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            
            // Validate file type
            if (!in_array($_FILES['profile_image']['type'], $allowedTypes)) {
                $_SESSION['profile_error'] = "Only JPG, PNG and GIF images are allowed.";
                header("Location: editprofile.php");
                exit();
            }
            
            // Validate file size
            if ($_FILES['profile_image']['size'] > $maxSize) {
                $_SESSION['profile_error'] = "The image cannot be larger than 5MB.";
                header("Location: editprofile.php");
                exit();
            }
            
            // Create a directory for user images if it doesn't exist
            $uploadDir = 'uploads/profile_images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Generate a unique filename
            $fileExtension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $newFilename = 'profile_' . $_SESSION['user_id'] . '_' . time() . '.' . $fileExtension;
            $targetFile = $uploadDir . $newFilename;
            
            // Move the uploaded file
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                // Update the database with the new file path
                $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE user_id = ?");
                $stmt->execute([$targetFile, $_SESSION['user_id']]);
            } else {
                $_SESSION['profile_error'] = "An error occurred while uploading the image.";
                header("Location: editprofile.php");
                exit();
            }
        }
        
        // Handle progress data
        // Handle existing and new progress metrics
        try {
            // Remove previous progress data for the user
            $deleteStmt = $conn->prepare("DELETE FROM progress_tracking WHERE user_id = ?");
            $deleteStmt->execute([$_SESSION['user_id']]);
            
            // Function to add progress metrics
            $insertStmt = $conn->prepare("
                INSERT INTO progress_tracking 
                (user_id, exercise_name, progress_value, color_class, display_order) 
                VALUES (?, ?, ?, ?, ?)
            ");
            
            $displayOrder = 0;
            
            // Handle existing progress metrics
            if (isset($_POST['progress_ids']) && is_array($_POST['progress_ids'])) {
                for ($i = 0; $i < count($_POST['progress_ids']); $i++) {
                    $exerciseName = filter_var($_POST['progress_names'][$i] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                    $progressValue = filter_var($_POST['progress_values'][$i] ?? 0, FILTER_VALIDATE_FLOAT);
                    $colorClass = filter_var($_POST['progress_colors'][$i] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                    
                    // Ensure the value is between 0 and 100
                    $progressValue = max(0, min(100, $progressValue));
                    
                    if (!empty($exerciseName)) {
                        $insertStmt->execute([
                            $_SESSION['user_id'],
                            $exerciseName,
                            $progressValue,
                            $colorClass,
                            $displayOrder++
                        ]);
                    }
                }
            }
            
            // Handle new progress metrics
            if (isset($_POST['new_progress_ids']) && is_array($_POST['new_progress_ids'])) {
                for ($i = 0; $i < count($_POST['new_progress_ids']); $i++) {
                    $exerciseName = filter_var($_POST['new_progress_names'][$i] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                    $progressValue = filter_var($_POST['new_progress_values'][$i] ?? 0, FILTER_VALIDATE_FLOAT);
                    $colorClass = filter_var($_POST['new_progress_colors'][$i] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                    
                    // Ensure the value is between 0 and 100
                    $progressValue = max(0, min(100, $progressValue));
                    
                    if (!empty($exerciseName)) {
                        $insertStmt->execute([
                            $_SESSION['user_id'],
                            $exerciseName,
                            $progressValue,
                            $colorClass,
                            $displayOrder++
                        ]);
                    }
                }
            }
        } catch (PDOException $e) {
            $_SESSION['profile_error'] = "An error occurred when saving progress data: " . $e->getMessage();
            header("Location: editprofile.php");
            exit();
        }
        
        // Handle personal records
        try {
            // Remove specifically marked personal records first
            if (isset($_POST['deleted_pb_ids']) && !empty($_POST['deleted_pb_ids'])) {
                $deletedIds = explode(',', $_POST['deleted_pb_ids']);
                $placeholders = implode(',', array_fill(0, count($deletedIds), '?'));
                
                // Add user_id for security
                $deleteParams = $deletedIds;
                $deleteParams[] = $_SESSION['user_id'];
                
                $bulkDeleteStmt = $conn->prepare("DELETE FROM personal_bests WHERE pb_id IN ($placeholders) AND user_id = ?");
                $bulkDeleteStmt->execute($deleteParams);
            }
            
            // Process existing personal records
            if (isset($_POST['pb_ids']) && is_array($_POST['pb_ids'])) {
                $updateStmt = $conn->prepare("UPDATE personal_bests SET value = ? WHERE pb_id = ? AND user_id = ?");
                $deleteStmt = $conn->prepare("DELETE FROM personal_bests WHERE pb_id = ? AND user_id = ?");
                
                for ($i = 0; $i < count($_POST['pb_ids']); $i++) {
                    $pbId = filter_var($_POST['pb_ids'][$i], FILTER_VALIDATE_INT);
                    $value = filter_var($_POST['pb_values'][$i], FILTER_VALIDATE_FLOAT);
                    
                    if ($pbId && $value > 0) {
                        // Update the record
                        $updateStmt->execute([$value, $pbId, $_SESSION['user_id']]);
                    } else if ($pbId) {
                        // Delete the record if value is empty or zero
                        $deleteStmt->execute([$pbId, $_SESSION['user_id']]);
                    }
                }
            }
            
            // Process new personal records
            if (isset($_POST['new_exercise_ids']) && is_array($_POST['new_exercise_ids'])) {
                $insertStmt = $conn->prepare("INSERT INTO personal_bests (user_id, exercise_id, value) VALUES (?, ?, ?)");
                $insertExerciseStmt = $conn->prepare("INSERT INTO exercises (name, muscle_group, difficulty_level) VALUES (?, 'Custom', 'intermediate')");
                
                for ($i = 0; $i < count($_POST['new_exercise_ids']); $i++) {
                    $exerciseId = filter_var($_POST['new_exercise_ids'][$i], FILTER_VALIDATE_INT);
                    $value = filter_var($_POST['new_pb_values'][$i] ?? 0, FILTER_VALIDATE_FLOAT);
                    $customExerciseName = isset($_POST['new_custom_exercise_names'][$i]) ? 
                                        filter_var($_POST['new_custom_exercise_names'][$i], FILTER_SANITIZE_SPECIAL_CHARS) : '';
                    
                    // If the value is greater than 0
                    if ($value > 0) {
                        // If we have a custom exercise name but no exercise_id, first create the exercise
                        if (!empty($customExerciseName) && empty($exerciseId)) {
                            try {
                                $insertExerciseStmt->execute([$customExerciseName]);
                                $exerciseId = $conn->lastInsertId();
                            } catch (PDOException $e) {
                                // Log error but continue
                                error_log("Could not create new exercise: " . $e->getMessage());
                                continue;
                            }
                        }
                        
                        // If we now have an exercise_id (either existing or newly created), save personal record
                        if ($exerciseId) {
                            $insertStmt->execute([$_SESSION['user_id'], $exerciseId, $value]);
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            $_SESSION['profile_error'] = "An error occurred when saving personal records: " . $e->getMessage();
            header("Location: editprofile.php");
            exit();
        }
        
        // Set a success message and redirect
        $_SESSION['profile_success'] = "Your profile has been updated.";
        header("Location: profile.php");
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['profile_error'] = "An error occurred: " . $e->getMessage();
        header("Location: editprofile.php");
        exit();
    }
} else {
    // If the user tries to open this file directly without submitting a form
    header("Location: editprofile.php");
    exit();
}
?> 