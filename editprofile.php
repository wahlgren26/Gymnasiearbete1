<?php
// Include session handler at the very beginning
include 'session_handler.php';
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
    </style>
</head>

<body>
<div class="wrapper">
    <?php include 'sidebar.php'; ?>
    
    <div class="main p-3">
        <div class="profile-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Edit Profile</h1>
                <a href="profile.php" class="btn btn-outline-secondary"><i class="lni lni-arrow-left"></i> Return to Profile</a>
            </div>
            
            <form action="update_profile.php" method="post" enctype="multipart/form-data">
                <!-- Profile picture and basic info -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Profile Picture & Basic Information</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <div class="profile-pic-wrapper">
                                        <img src="MSNexample.png" alt="Profile Picture" class="profile-pic mb-3">
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
                                        <input type="text" class="form-control" id="firstname" name="firstname" value="Anders">
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" value="Andersson">
                                    </div>
                                    <div class="mb-3">
                                        <label for="member_since" class="form-label">Member Since</label>
                                        <input type="month" class="form-control" id="member_since" name="member_since" value="2024-01" readonly>
                                        <small class="text-muted">Member date cannot be changed</small>
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
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4">Been actively training for 3 years with a focus on strength training. I like to push myself to new levels and help others reach their training goals. Specialized in powerlifting and functional training.</textarea>
                                <small class="text-muted">Write a short bio about yourself and your fitness journey</small>
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
                                        <input type="number" class="form-control" id="age" name="age" value="28">
                                        <span class="input-group-text">years</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="height" class="form-label">Height</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="height" name="height" value="180">
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="weight" class="form-label">Weight</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="weight" name="weight" step="0.1" value="75">
                                        <span class="input-group-text">kg</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="goal" class="form-label">Training Goals</label>
                                    <input type="text" class="form-control" id="goal" name="goal" value="Strength increase and muscle growth">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Personal bests -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Personal Bests</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row" id="personal-bests">
                                <div class="col-md-4 mb-3">
                                    <div class="exercise-item">
                                        <label for="bench_press" class="form-label">Bench Press</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="bench_press" name="bench_press" value="100">
                                            <span class="input-group-text">kg</span>
                                            <button type="button" class="btn btn-outline-danger remove-exercise" title="Remove"><i class="lni lni-close"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="exercise-item">
                                        <label for="deadlift" class="form-label">Deadlift</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="deadlift" name="deadlift" value="160">
                                            <span class="input-group-text">kg</span>
                                            <button type="button" class="btn btn-outline-danger remove-exercise" title="Remove"><i class="lni lni-close"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="exercise-item">
                                        <label for="squat" class="form-label">Squat</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="squat" name="squat" value="120">
                                            <span class="input-group-text">kg</span>
                                            <button type="button" class="btn btn-outline-danger remove-exercise" title="Remove"><i class="lni lni-close"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary btn-sm mt-3" id="addExercise">
                                <i class="lni lni-plus"></i> Add Exercise
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Training statistics -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Training Statistics</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="monthly_sessions" class="form-label">Sessions This Month</label>
                                    <input type="number" class="form-control" id="monthly_sessions" name="monthly_sessions" value="12">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="training_hours" class="form-label">Training Hours</label>
                                    <input type="number" class="form-control" id="training_hours" name="training_hours" value="18">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="active_programs" class="form-label">Active Programs</label>
                                    <input type="number" class="form-control" id="active_programs" name="active_programs" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Tracker -->
                <div class="edit-section mb-4">
                    <h4 class="mb-3">Progress Tracker</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="bench_progress" class="form-label">Bench Press Progress (%)</label>
                                    <input type="range" class="form-range" id="bench_progress" name="bench_progress" min="0" max="100" value="65">
                                    <div class="d-flex justify-content-between">
                                        <small>0%</small>
                                        <small id="bench_value">65%</small>
                                        <small>100%</small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="deadlift_progress" class="form-label">Deadlift Progress (%)</label>
                                    <input type="range" class="form-range" id="deadlift_progress" name="deadlift_progress" min="0" max="100" value="80">
                                    <div class="d-flex justify-content-between">
                                        <small>0%</small>
                                        <small id="deadlift_value">80%</small>
                                        <small>100%</small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="squat_progress" class="form-label">Squat Progress (%)</label>
                                    <input type="range" class="form-range" id="squat_progress" name="squat_progress" min="0" max="100" value="70">
                                    <div class="d-flex justify-content-between">
                                        <small>0%</small>
                                        <small id="squat_value">70%</small>
                                        <small>100%</small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="weight_progress" class="form-label">Weight Goal Progress (%)</label>
                                    <input type="range" class="form-range" id="weight_progress" name="weight_progress" min="0" max="100" value="50">
                                    <div class="d-flex justify-content-between">
                                        <small>0%</small>
                                        <small id="weight_value">50%</small>
                                        <small>100%</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="d-flex justify-content-between mb-4">
                    <a href="profile.php" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
<script>
    // Profile image upload preview
    document.getElementById('uploadBtn').addEventListener('click', function() {
        document.getElementById('profileImageUpload').click();
    });
    
    document.getElementById('profileImageUpload').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const src = URL.createObjectURL(e.target.files[0]);
            document.querySelector('.profile-pic').src = src;
        }
    });
    
    // Add new exercise functionality
    document.getElementById('addExercise').addEventListener('click', function() {
        const container = document.getElementById('personal-bests');
        
        const col = document.createElement('div');
        col.className = 'col-md-4 mb-3';
        
        const exerciseItem = document.createElement('div');
        exerciseItem.className = 'exercise-item';
        
        const label = document.createElement('label');
        label.className = 'form-label';
        label.textContent = 'New Exercise';
        
        const inputGroup = document.createElement('div');
        inputGroup.className = 'input-group';
        
        const input = document.createElement('input');
        input.type = 'number';
        input.className = 'form-control';
        input.name = 'custom_exercise[]';
        input.placeholder = 'Weight';
        
        const inputGroupText = document.createElement('span');
        inputGroupText.className = 'input-group-text';
        inputGroupText.textContent = 'kg';
        
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-outline-danger remove-exercise';
        removeButton.title = 'Remove';
        removeButton.innerHTML = '<i class="lni lni-close"></i>';
        
        const nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.className = 'form-control mt-2';
        nameInput.name = 'custom_exercise_name[]';
        nameInput.placeholder = 'Exercise name';
        
        inputGroup.appendChild(input);
        inputGroup.appendChild(inputGroupText);
        inputGroup.appendChild(removeButton);
        
        exerciseItem.appendChild(label);
        exerciseItem.appendChild(inputGroup);
        exerciseItem.appendChild(nameInput);
        
        col.appendChild(exerciseItem);
        container.appendChild(col);
    });
    
    // Remove exercise functionality
    document.addEventListener('click', function(event) {
        if (event.target.closest('.remove-exercise')) {
            const button = event.target.closest('.remove-exercise');
            const exerciseItem = button.closest('.col-md-4');
            
            if (confirm('Are you sure you want to remove this exercise?')) {
                exerciseItem.remove();
            }
        }
    });
    
    // Update progress display values
    const rangeInputs = document.querySelectorAll('input[type="range"]');
    rangeInputs.forEach(input => {
        input.addEventListener('input', function() {
            document.getElementById(input.id + '_value').textContent = input.value + '%';
        });
    });
</script>
</body>
</html> 