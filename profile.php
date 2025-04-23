<?php
// Include session handler at the very beginning
include 'session_handler.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/signin.php");
    exit();
}

// Include database connection
require_once 'config/db_connect.php';

// Determine which user's profile to show
$profile_user_id = isset($_GET['user_id']) ? filter_var($_GET['user_id'], FILTER_VALIDATE_INT) : $_SESSION['user_id'];
$is_own_profile = ($profile_user_id == $_SESSION['user_id']);

// Get user data from database
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$profile_user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If user doesn't exist, redirect to own profile
    if (!$user) {
        header("Location: profile.php");
        exit();
    }
    
    // Get personal records
    $stmt = $conn->prepare("
        SELECT pb.*, e.name as exercise_name 
        FROM personal_bests pb 
        JOIN exercises e ON pb.exercise_id = e.exercise_id 
        WHERE pb.user_id = ?
    ");
    $stmt->execute([$profile_user_id]);
    $personal_bests = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get workout statistics
    $stmt = $conn->prepare("
        SELECT COUNT(*) as session_count, SUM(duration) as total_hours
        FROM workout_sessions
        WHERE user_id = ? AND session_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");
    $stmt->execute([$profile_user_id]);
    $statistics = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get progress tracking data
    $stmt = $conn->prepare("
        SELECT * FROM progress_tracking 
        WHERE user_id = ? 
        ORDER BY display_order ASC
    ");
    $stmt->execute([$profile_user_id]);
    $progress_tracking = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // If no progress data exists and this is own profile, create default values
    if (empty($progress_tracking) && $is_own_profile) {
        try {
            // Default progress trackers
            $default_progress = [
                ['Bench Press', 65, ''],
                ['Deadlift', 80, 'bg-success'],
                ['Squat', 70, 'bg-info'],
                ['Weight Goal', 50, 'bg-warning']
            ];
            
            // Add default values to database
            $stmt = $conn->prepare("
                INSERT INTO progress_tracking (user_id, exercise_name, progress_value, color_class, display_order) 
                VALUES (?, ?, ?, ?, ?)
            ");
            
            foreach ($default_progress as $index => $progress) {
                $stmt->execute([
                    $profile_user_id,
                    $progress[0],
                    $progress[1],
                    $progress[2],
                    $index
                ]);
            }
            
            // Get the newly added progress data
            $stmt = $conn->prepare("
                SELECT * FROM progress_tracking 
                WHERE user_id = ? 
                ORDER BY display_order ASC
            ");
            $stmt->execute([$profile_user_id]);
            $progress_tracking = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Ignore any errors here, we'll use default values instead
            $progress_tracking = [];
        }
    }
    
    // Get user's recent workouts for the profile
    $stmt = $conn->prepare("
        SELECT * FROM workout_sessions
        WHERE user_id = ?
        ORDER BY session_date DESC
        LIMIT 5
    ");
    $stmt->execute([$profile_user_id]);
    $recent_workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // If something goes wrong, set an error message
    $_SESSION['error'] = "Could not retrieve profile information: " . $e->getMessage();
}

// Check if there's a saved setting to show/hide progress tracker
// Try to get setting from database first, fall back to session if needed
$show_progress_tracker = true; // Default value
try {
    $stmt = $conn->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'users' AND COLUMN_NAME = 'show_progress_tracker'");
    $stmt->execute();
    
    // Check if column exists
    if ($stmt->rowCount() > 0) {
        // Column exists, get value
        $stmt = $conn->prepare("SELECT show_progress_tracker FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $show_progress_tracker = (bool)$result['show_progress_tracker'];
        }
    } else {
        // Column doesn't exist, create it
        $conn->exec("ALTER TABLE users ADD COLUMN show_progress_tracker BOOLEAN DEFAULT 1");
    }
} catch (PDOException $e) {
    // If database error, fallback to session value
    $show_progress_tracker = isset($_SESSION['show_progress_tracker']) ? $_SESSION['show_progress_tracker'] : true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymLog - Profile</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <link rel="stylesheet" href="css/profile.css">
    <style>
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .profile-header {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        
        .profile-description {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #0d6efd;
            margin-top: 15px;
        }
        
        .stats-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        
        .stats-card h4 {
            color: #0d6efd;
            margin-bottom: 15px;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>

<body>
<div class="wrapper">

    <?php include 'sidebar.php'; ?>
    
    <div class="main p-3">
        <div class="profile-container">
            <?php if(isset($_SESSION['profile_success'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['profile_success']; 
                        unset($_SESSION['profile_success']);
                    ?>
                </div>
            <?php endif; ?>
            
            <div class="profile-header">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="profile-top d-flex align-items-center">
                        <img src="<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'images/default_profile.png'; ?>" 
                             alt="Profile Picture" class="profile-image me-4">
                        <div class="profile-info">
                            <h2><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></h2>
                            <div class="member-since text-muted">Member since: <?php echo date('F Y', strtotime($user['join_date'])); ?></div>
                        </div>
                    </div>
                    <?php if ($is_own_profile): ?>
                    <a href="editprofile.php" class="btn btn-primary"><i class="lni lni-pencil"></i> Edit Profile</a>
                    <?php endif; ?>
                </div>
                <div class="profile-description">
                    <?php echo !empty($user['bio']) ? htmlspecialchars($user['bio']) : 'No description added yet.'; ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="stats-card">
                        <h4>Personal Information</h4>
                        <hr>
                        <p><strong>Age:</strong> <?php echo !empty($user['age']) ? htmlspecialchars($user['age']) . ' years' : 'N/A'; ?></p>
                        <p><strong>Height:</strong> <?php echo !empty($user['height']) ? htmlspecialchars($user['height']) . ' cm' : 'N/A'; ?></p>
                        <p><strong>Weight:</strong> <?php echo !empty($user['weight']) ? htmlspecialchars($user['weight']) . ' kg' : 'N/A'; ?></p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="stats-card">
                        <h4>Personal Records</h4>
                        <hr>
                        <?php if (!empty($personal_bests)): ?>
                            <?php foreach ($personal_bests as $pb): ?>
                                <p><strong><?php echo htmlspecialchars($pb['exercise_name']); ?>:</strong> 
                                   <?php echo htmlspecialchars($pb['value']); ?> kg</p>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No personal records registered yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <h4>Training Statistics</h4>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-sm-12 text-center mb-3 mb-md-0">
                        <h5>Sessions this month</h5>
                        <p class="stats-number"><?php echo !empty($statistics['session_count']) ? htmlspecialchars($statistics['session_count']) : '0'; ?></p>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center mb-3 mb-md-0">
                        <h5>Training hours</h5>
                        <p class="stats-number"><?php echo !empty($statistics['total_hours']) ? htmlspecialchars(round($statistics['total_hours']/60, 1)) : '0'; ?></p>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center">
                        <h5>Active programs</h5>
                        <p class="stats-number">0</p>
                    </div>
                </div>
            </div>
            
            <?php if ($show_progress_tracker): ?>
            <!-- Progress chart - only shown if user has selected it -->
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Progress Tracking</h4>
                    <a href="editprofile.php#progress-section" class="btn btn-sm btn-outline-primary">Edit Progress</a>
                </div>
                <hr>
                <?php if (!empty($progress_tracking)): ?>
                    <?php foreach ($progress_tracking as $progress): ?>
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar <?php echo htmlspecialchars($progress['color_class']); ?>" 
                                 role="progressbar" 
                                 style="width: <?php echo htmlspecialchars($progress['progress_value']); ?>%;" 
                                 aria-valuenow="<?php echo htmlspecialchars($progress['progress_value']); ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                <?php echo htmlspecialchars($progress['exercise_name'] . ': ' . $progress['progress_value']); ?>%
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No progress has been recorded yet. Go to "Edit Profile" to add progress goals.</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html> 