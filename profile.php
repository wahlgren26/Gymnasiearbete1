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
            <div class="profile-header">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="profile-top d-flex align-items-center">
                        <img src="MSNexample.png" alt="Profile Picture" class="profile-image me-4">
                        <div class="profile-info">
                            <h2>Anders Andersson</h2>
                            <div class="member-since text-muted">Member since: January 2024</div>
                        </div>
                    </div>
                    <a href="editprofile.php" class="btn btn-primary"><i class="lni lni-pencil"></i> Edit Profile</a>
                </div>
                <div class="profile-description">
                    Been actively training for 3 years with a focus on strength training. I like to push myself to new levels 
                    and help others reach their training goals. Specialized in powerlifting and 
                    functional training.
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="stats-card">
                        <h4>Personal Information</h4>
                        <hr>
                        <p><strong>Age:</strong> 28 years</p>
                        <p><strong>Height:</strong> 180 cm</p>
                        <p><strong>Weight:</strong> 75 kg</p>
                        <p><strong>Goal:</strong> Strength increase and muscle growth</p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="stats-card">
                        <h4>Personal Bests</h4>
                        <hr>
                        <p><strong>Bench Press:</strong> 100 kg</p>
                        <p><strong>Deadlift:</strong> 160 kg</p>
                        <p><strong>Squat:</strong> 120 kg</p>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <h4>Training Statistics</h4>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-sm-12 text-center mb-3 mb-md-0">
                        <h5>Sessions This Month</h5>
                        <p class="stats-number">12</p>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center mb-3 mb-md-0">
                        <h5>Training Hours</h5>
                        <p class="stats-number">18</p>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center">
                        <h5>Active Programs</h5>
                        <p class="stats-number">2</p>
                    </div>
                </div>
            </div>
            
            <!-- Added new section: Progress Tracker -->
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Progress Tracker</h4>
                    <a href="#" class="btn btn-sm btn-outline-primary">View Details</a>
                </div>
                <hr>
                <div class="progress mb-3" style="height: 25px;">
                    <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">Bench Press: 65%</div>
                </div>
                <div class="progress mb-3" style="height: 25px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">Deadlift: 80%</div>
                </div>
                <div class="progress mb-3" style="height: 25px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">Squat: 70%</div>
                </div>
                <div class="progress" style="height: 25px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Weight Goal: 50%</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html> 