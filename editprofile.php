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

// Get user data from database
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get personal records
    $stmt = $conn->prepare("
        SELECT pb.*, e.name as exercise_name, e.exercise_id
        FROM personal_bests pb 
        JOIN exercises e ON pb.exercise_id = e.exercise_id 
        WHERE pb.user_id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $personal_bests = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get all available exercises for dropdown list
    $stmt = $conn->prepare("SELECT * FROM exercises ORDER BY name");
    $stmt->execute();
    $all_exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get progress tracking data
    $stmt = $conn->prepare("
        SELECT * FROM progress_tracking 
        WHERE user_id = ? 
        ORDER BY display_order ASC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $progress_tracking = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // If something goes wrong, set an error message
    $_SESSION['profile_error'] = "Could not fetch profile information: " . $e->getMessage();
}

// Check if there is a saved setting for showing/hiding progress tracker
try {
    // Check if column exists
    $stmt = $conn->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'users' AND COLUMN_NAME = 'show_progress_tracker'");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        // Column exists, get value from db
        $stmt = $conn->prepare("SELECT show_progress_tracker FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $show_progress_tracker = $result ? (bool)$result['show_progress_tracker'] : true;
    } else {
        // Column doesn't exist, use default and create column
        $show_progress_tracker = true;
        $conn->exec("ALTER TABLE users ADD COLUMN show_progress_tracker BOOLEAN DEFAULT 1");
        
        // Set initial value
        $stmt = $conn->prepare("UPDATE users SET show_progress_tracker = 1 WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
    }
} catch (PDOException $e) {
    // Fallback to session value if database error
    $show_progress_tracker = isset($_SESSION['show_progress_tracker']) ? $_SESSION['show_progress_tracker'] : true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymLog - Edit Profile</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/editprofile.css">
    <style>
        .profile-pic-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }
        
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .upload-btn-wrapper {
            position: absolute;
            bottom: 0;
            right: 0;
        }
        
        .edit-section {
            margin-bottom: 30px;
        }
        
        .edit-section h4 {
            color: #0d6efd;
            margin-bottom: 15px;
        }
        
        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border-radius: 10px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Toggle switch for progress tracker */
        .form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
        }
        
        .form-switch .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        /* Drag-and-drop for progress items */
        .progress-item {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            border-radius: 6px;
            cursor: grab;
            transition: all 0.2s;
        }
        
        .progress-item:hover {
            background-color: #e9ecef;
        }
        
        .progress-item-dragging {
            opacity: 0.5;
        }
        
        .progress-preview {
            height: 15px;
            margin-top: 5px;
        }
        
        .color-selector {
            display: flex;
            flex-wrap: wrap;
            margin-top: 8px;
        }
        
        .color-option {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-right: 6px;
            cursor: pointer;
            border: 2px solid transparent;
        }
        
        .color-option.selected {
            border-color: #000;
        }
    </style>
</head>

<body>
<div class="wrapper">

    <?php include 'sidebar.php'; ?>
    
    <div class="main p-3">
        <div class="profile-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Edit Profile</h1>
                <a href="profile.php" class="btn btn-outline-secondary"><i class="lni lni-arrow-left"></i> Back to Profile</a>
            </div>
            
            <?php if(isset($_SESSION['profile_error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['profile_error']; 
                        unset($_SESSION['profile_error']);
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['profile_success'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['profile_success']; 
                        unset($_SESSION['profile_success']);
                    ?>
                </div>
            <?php endif; ?>
            
            <form action="profile_update_handler.php" method="post" enctype="multipart/form-data">
                <!-- Profile picture and basic info -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Profile Picture & Basic Information</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <div class="profile-pic-wrapper">
                                        <img src="<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'assets/img/default-profile.png'; ?>" 
                                             alt="Profile Picture" class="profile-pic mb-3">
                                        <div class="upload-btn-wrapper">
                                            <button type="button" class="btn btn-primary btn-sm" id="uploadBtn"><i class="lni lni-camera"></i></button>
                                            <input type="file" name="profile_image" id="profileImageUpload" accept="image/*" hidden>
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-2">Click the button to change your picture</small>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="member_since" class="form-label">Member Since</label>
                                        <input type="text" class="form-control" id="member_since" value="<?php echo date('F Y', strtotime($user['join_date'])); ?>" readonly>
                                        <small class="text-muted">Membership date cannot be changed</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">About Me</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="bio" class="form-label">Description</label>
                                <textarea class="form-control" id="bio" name="bio" rows="4"><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                                <small class="text-muted">Write a short text about yourself and your fitness journey</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Personal information -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Personal Information</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="age" class="form-label">Age</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="age" name="age" value="<?php echo !empty($user['age']) ? htmlspecialchars($user['age']) : ''; ?>" placeholder="N/A">
                                        <span class="input-group-text">years</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="height" class="form-label">Height</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="height" name="height" value="<?php echo !empty($user['height']) ? htmlspecialchars($user['height']) : ''; ?>" placeholder="N/A">
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="weight" class="form-label">Weight</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="weight" name="weight" step="0.1" value="<?php echo !empty($user['weight']) ? htmlspecialchars($user['weight']) : ''; ?>" placeholder="N/A">
                                        <span class="input-group-text">kg</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Settings -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Display Settings</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_progress_tracker" name="show_progress_tracker" <?php echo $show_progress_tracker ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="show_progress_tracker">Show progress chart on profile page</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Tracking -->
                <div class="edit-section mb-4" id="progress-section">
                    <h4 class="mb-3">Progress Chart</h4>
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-3">Here you can add and edit measurements shown in your progress chart on the profile page. Drag to change order.</p>
                            
                            <div id="progress-items">
                                <?php if (!empty($progress_tracking)): ?>
                                    <?php foreach ($progress_tracking as $index => $progress): ?>
                                        <div class="progress-item" data-id="<?php echo htmlspecialchars($progress['progress_id']); ?>">
                                            <div class="row">
                                                <div class="col-md-4 mb-2 mb-md-0">
                                                    <input type="hidden" name="progress_ids[]" value="<?php echo htmlspecialchars($progress['progress_id']); ?>">
                                                    <input type="text" class="form-control" name="progress_names[]" placeholder="Name" value="<?php echo htmlspecialchars($progress['exercise_name']); ?>">
                                                </div>
                                                <div class="col-md-4 mb-2 mb-md-0">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control progress-value" name="progress_values[]" min="0" max="100" placeholder="Value %" value="<?php echo htmlspecialchars($progress['progress_value']); ?>">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2 mb-md-0">
                                                    <input type="hidden" class="color-class-input" name="progress_colors[]" value="<?php echo htmlspecialchars($progress['color_class']); ?>">
                                                    <div class="color-selector">
                                                        <div class="color-option <?php echo $progress['color_class'] === '' ? 'selected' : ''; ?>" data-color="" style="background-color: #0d6efd;"></div>
                                                        <div class="color-option <?php echo $progress['color_class'] === 'bg-success' ? 'selected' : ''; ?>" data-color="bg-success" style="background-color: #198754;"></div>
                                                        <div class="color-option <?php echo $progress['color_class'] === 'bg-info' ? 'selected' : ''; ?>" data-color="bg-info" style="background-color: #0dcaf0;"></div>
                                                        <div class="color-option <?php echo $progress['color_class'] === 'bg-warning' ? 'selected' : ''; ?>" data-color="bg-warning" style="background-color: #ffc107;"></div>
                                                        <div class="color-option <?php echo $progress['color_class'] === 'bg-danger' ? 'selected' : ''; ?>" data-color="bg-danger" style="background-color: #dc3545;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 text-end">
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-progress" title="Remove"><i class="lni lni-close"></i></button>
                                                </div>
                                            </div>
                                            <div class="progress progress-preview">
                                                <div class="progress-bar <?php echo htmlspecialchars($progress['color_class']); ?>" style="width: <?php echo htmlspecialchars($progress['progress_value']); ?>%"></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-3">
                                        <p>No progress has been recorded yet. Add a new one below.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mt-3">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addProgressItem">
                                    <i class="lni lni-plus"></i> Add Progress Measure
                                </button>
                            </div>
                            
                            <!-- Template for new progress measure (hidden) -->
                            <div id="progress-template" class="d-none">
                                <div class="progress-item" data-id="new">
                            <div class="row">
                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <input type="hidden" name="new_progress_ids[]" value="new">
                                            <input type="text" class="form-control" name="new_progress_names[]" placeholder="Name">
                                        </div>
                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <div class="input-group">
                                                <input type="number" class="form-control progress-value" name="new_progress_values[]" min="0" max="100" placeholder="Value %" value="0">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2 mb-md-0">
                                            <input type="hidden" class="color-class-input" name="new_progress_colors[]" value="">
                                            <div class="color-selector">
                                                <div class="color-option selected" data-color="" style="background-color: #0d6efd;"></div>
                                                <div class="color-option" data-color="bg-success" style="background-color: #198754;"></div>
                                                <div class="color-option" data-color="bg-info" style="background-color: #0dcaf0;"></div>
                                                <div class="color-option" data-color="bg-warning" style="background-color: #ffc107;"></div>
                                                <div class="color-option" data-color="bg-danger" style="background-color: #dc3545;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-progress" title="Remove"><i class="lni lni-close"></i></button>
                                        </div>
                                </div>
                                    <div class="progress progress-preview">
                                        <div class="progress-bar" style="width: 0%"></div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Personal Records -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Personal Records</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row" id="personal-bests">
                                <?php if (!empty($personal_bests)): ?>
                                    <?php foreach ($personal_bests as $index => $pb): ?>
                                        <div class="col-md-4 mb-3">
                                            <div class="exercise-item">
                                                <input type="hidden" name="pb_ids[]" value="<?php echo htmlspecialchars($pb['pb_id']); ?>">
                                                <input type="hidden" name="exercise_ids[]" value="<?php echo htmlspecialchars($pb['exercise_id']); ?>">
                                                <label class="form-label"><?php echo htmlspecialchars($pb['exercise_name']); ?></label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="pb_values[]" value="<?php echo htmlspecialchars($pb['value']); ?>" step="0.01">
                                                    <span class="input-group-text">kg</span>
                                                    <button type="button" class="btn btn-outline-danger remove-exercise" title="Remove"><i class="lni lni-close"></i></button>
                                                </div>
                                    </div>
                                </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12">
                                        <p>No personal records have been registered yet.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mt-3">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addExercise">
                                    <i class="lni lni-plus"></i> Add Exercise
                                </button>
                            </div>
                            
                            <!-- Template for new exercise (hidden) -->
                            <div id="exercise-template" class="d-none">
                                <div class="col-md-4 mb-3">
                                    <div class="exercise-item">
                                        <div class="mb-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input exercise-type-radio" type="radio" name="exercise_type_new" id="existingExercise_new" value="existing" checked>
                                                <label class="form-check-label" for="existingExercise_new">Select exercise</label>
                                </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input exercise-type-radio" type="radio" name="exercise_type_new" id="customExercise_new" value="custom">
                                                <label class="form-check-label" for="customExercise_new">Custom exercise</label>
                                    </div>
                                </div>
                                        
                                        <div class="exercise-select-container">
                                            <select name="new_exercise_ids[]" class="form-select mb-2 exercise-select">
                                                <option value="">Select exercise</option>
                                                <?php foreach ($all_exercises as $exercise): ?>
                                                    <option value="<?php echo htmlspecialchars($exercise['exercise_id']); ?>"><?php echo htmlspecialchars($exercise['name']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="custom-exercise-container d-none">
                                            <input type="text" class="form-control mb-2 custom-exercise-name" name="new_custom_exercise_names[]" placeholder="Enter exercise name" disabled>
                                        </div>
                                        
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="new_pb_values[]" step="0.01" placeholder="Weight">
                                            <span class="input-group-text">kg</span>
                                            <button type="button" class="btn btn-outline-danger remove-exercise" title="Remove"><i class="lni lni-close"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary"><i class="lni lni-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="js/script.js"></script>
<script>
    // Script for profile image upload
    document.addEventListener('DOMContentLoaded', function() {
        // Profile image upload buttons
        const uploadBtn = document.getElementById('uploadBtn');
        const profileImageUpload = document.getElementById('profileImageUpload');
        const profilePic = document.querySelector('.profile-pic');
        
        uploadBtn.addEventListener('click', function() {
            profileImageUpload.click();
        });
        
        profileImageUpload.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePic.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Sortable list for progress chart
        const progressItems = document.getElementById('progress-items');
        if (progressItems) {
            new Sortable(progressItems, {
                animation: 150,
                ghostClass: 'progress-item-dragging',
                handle: '.progress-item',
                onEnd: function(evt) {
                    // Update order if needed
                }
            });
        }
        
        // Handling for adding/removing progress measures
        const addProgressItemBtn = document.getElementById('addProgressItem');
        const progressTemplate = document.getElementById('progress-template').innerHTML;
        
        if (addProgressItemBtn) {
            addProgressItemBtn.addEventListener('click', function() {
                const newItemDiv = document.createElement('div');
                newItemDiv.innerHTML = progressTemplate;
                const firstChild = newItemDiv.firstElementChild;
                progressItems.appendChild(firstChild);
                attachProgressEventListeners();
            });
        }
        
        function attachProgressEventListeners() {
            // Remove button
            const removeButtons = document.querySelectorAll('.remove-progress');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.progress-item').remove();
                });
            });
            
            // Color selectors
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const parent = this.closest('.progress-item');
                    const colorInput = parent.querySelector('.color-class-input');
                    const previewBar = parent.querySelector('.progress-bar');
                    
                    // Remove selected class from all options in this group
                    const siblings = this.parentNode.querySelectorAll('.color-option');
                    siblings.forEach(sib => sib.classList.remove('selected'));
                    
                    // Add selected class to this option
                    this.classList.add('selected');
                    
                    // Update hidden input value
                    const colorClass = this.getAttribute('data-color');
                    colorInput.value = colorClass;
                    
                    // Update preview bar
                    previewBar.className = 'progress-bar ' + colorClass;
                });
            });
            
            // Progress value change
            const progressValues = document.querySelectorAll('.progress-value');
            progressValues.forEach(input => {
                input.addEventListener('input', function() {
                    const parent = this.closest('.progress-item');
                    const previewBar = parent.querySelector('.progress-bar');
                    const value = this.value > 100 ? 100 : (this.value < 0 ? 0 : this.value);
                    previewBar.style.width = value + '%';
                });
            });
        }
        
        // Handling for adding/removing exercises
        const addExerciseBtn = document.getElementById('addExercise');
        const personalBests = document.getElementById('personal-bests');
        const exerciseTemplate = document.getElementById('exercise-template').innerHTML;
        
        // Create an array to keep track of removed personal records
        let deletedPbIds = [];
        
        // Add hidden field for deleted records in the form
        const form = document.querySelector('form');
        const deletedPbIdsInput = document.createElement('input');
        deletedPbIdsInput.type = 'hidden';
        deletedPbIdsInput.name = 'deleted_pb_ids';
        deletedPbIdsInput.value = '';
        form.appendChild(deletedPbIdsInput);
        
        addExerciseBtn.addEventListener('click', function() {
            const newExerciseCol = document.createElement('div');
            newExerciseCol.innerHTML = exerciseTemplate;
            const firstChild = newExerciseCol.firstElementChild;
            personalBests.appendChild(firstChild);
            attachRemoveEventListeners();
        });
        
        function attachRemoveEventListeners() {
            const removeButtons = document.querySelectorAll('.remove-exercise');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const exerciseItem = this.closest('.exercise-item');
                    const pbIdInput = exerciseItem && exerciseItem.querySelector('input[name="pb_ids[]"]');
                    if (pbIdInput && pbIdInput.value) {
                        // Add ID to the list of deleted items
                        deletedPbIds.push(pbIdInput.value);
                        deletedPbIdsInput.value = deletedPbIds.join(',');
                    }
                    this.closest('.col-md-4').remove();
                });
            });
            
            // Handle toggling between existing/custom exercise for new exercises
            const exerciseTypeRadios = document.querySelectorAll('.exercise-type-radio');
            exerciseTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const exerciseItem = this.closest('.exercise-item');
                    const selectContainer = exerciseItem.querySelector('.exercise-select-container');
                    const customContainer = exerciseItem.querySelector('.custom-exercise-container');
                    const selectInput = exerciseItem.querySelector('.exercise-select');
                    const customInput = exerciseItem.querySelector('.custom-exercise-name');
                    
                    if (this.value === 'existing') {
                        selectContainer.classList.remove('d-none');
                        customContainer.classList.add('d-none');
                        selectInput.disabled = false;
                        customInput.disabled = true;
                    } else { // custom
                        selectContainer.classList.add('d-none');
                        customContainer.classList.remove('d-none');
                        selectInput.disabled = true;
                        customInput.disabled = false;
                    }
                });
            });
        }
        
        // Initialize event listeners
        attachRemoveEventListeners();
        attachProgressEventListeners();
        
        // Toggle settings
        const showProgressTracker = document.getElementById('show_progress_tracker');
        showProgressTracker.addEventListener('change', function() {
            fetch('toggle_progress_tracker.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'show=' + (this.checked ? '1' : '0')
            });
        });
    });
</script>
</body>
</html> 