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
    <title>Workout Log - GymLog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <link rel="stylesheet" href="css/day.css">
    <style>
        .workout-timer {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
        }
        
        .timer-controls {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        
        .exercise-log {
            margin-bottom: 1rem;
            border-left: 3px solid #0d6efd;
            padding-left: 1rem;
        }
        
        .workout-card {
            transition: all 0.3s ease;
        }
        
        .workout-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        
        .workout-in-progress {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
            }
        }
        
        .template-item {
            cursor: pointer;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .template-item:hover {
            border-left-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <?php include 'sidebar.php'; ?>

        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <!-- Dolt fält för användar-ID -->
                    <input type="hidden" id="current_user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">

                    <h1 class="display-4 text-center mb-3">Workout Log</h1>
                    <p class="lead text-center mb-5">Track your workouts and monitor your progress over time</p>
                    
                    <div class="row g-4">
                        <!-- Active workout -->
                        <div class="col-12 col-lg-6">
                            <div class="card shadow-lg border-0 rounded-4 h-100 workout-card" id="active-workout-card">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h3 class="card-title h4 fw-bold mb-0">Current Workout</h3>
                                        <span class="badge bg-primary rounded-pill" id="status-badge">Ready to Start</span>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="workout-name" class="form-label text-muted small text-uppercase fw-bold">Name Your Workout</label>
                                        <input type="text" class="form-control bg-light border-0 rounded-3" id="workout-name" placeholder="E.g. Chest Day or Leg Day">
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label for="workout-date" class="form-label text-muted small text-uppercase fw-bold">Date</label>
                                            <input type="date" class="form-control bg-light border-0 rounded-3" id="workout-date">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="workout-location" class="form-label text-muted small text-uppercase fw-bold">Location</label>
                                            <input type="text" class="form-control bg-light border-0 rounded-3" id="workout-location" placeholder="E.g. Home Gym or Fitness Club">
                                        </div>
                                    </div>
                                    
                                    <div class="workout-timer mb-4" id="workout-timer">00:00:00</div>
                                    
                                    <div class="timer-controls">
                                        <button class="btn btn-primary btn-lg rounded-3" id="start-btn">
                                            <i class="lni lni-play"></i> Start
                                        </button>
                                        <button class="btn btn-warning btn-lg rounded-3" id="pause-btn" disabled>
                                            <i class="lni lni-pause"></i> Pause
                                        </button>
                                        <button class="btn btn-success btn-lg rounded-3" id="stop-btn" disabled>
                                            <i class="lni lni-checkmark-circle"></i> Finish
                                        </button>
                                    </div>
                                    
                                    <div id="workout-exercises">
                                        <div class="mb-3">
                                            <label class="form-label text-muted small text-uppercase fw-bold">Exercises</label>
                                            <div id="exercise-container"></div>
                                            <button class="btn btn-outline-primary btn-sm mt-3" id="add-exercise-btn">
                                                <i class="lni lni-plus me-2"></i>Add Exercise
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="workout-notes" class="form-label text-muted small text-uppercase fw-bold">Notes</label>
                                        <textarea class="form-control bg-light border-0 rounded-3" id="workout-notes" rows="3" 
                                            placeholder="How did your workout feel? Anything special you want to remember?"></textarea>
                                    </div>
                                    
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="share-to-social" checked>
                                        <label class="form-check-label" for="share-to-social">
                                            Share this workout on social feed
                                        </label>
                                    </div>
                                    
                                    <button class="btn btn-primary btn-lg w-100 rounded-3" id="save-workout-btn" disabled>
                                        <i class="lni lni-save me-2"></i>Save Workout
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Workout templates -->
                        <div class="col-12 col-lg-6">
                            <div class="card shadow-lg border-0 rounded-4 h-100 workout-card">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h3 class="card-title h4 fw-bold mb-0">Workout Templates</h3>
                                        <button class="btn btn-sm btn-primary rounded-pill" id="load-from-schedule">
                                            <i class="lni lni-calendar me-1"></i> Load from Schedule
                                        </button>
                                    </div>
                                    
                                    <div id="templates-container" class="mb-4">
                                        <div class="alert alert-info">
                                            <i class="lni lni-information-circle me-2"></i>
                                            Your saved workouts will appear here as templates to quickly start a new workout.
                                        </div>
                                        
                                        <!-- Saved templates will be displayed here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- History -->
                    <div class="mt-5">
                        <h2 class="display-5 text-center mb-4">Workout History</h2>
                        
                        <div class="row" id="workout-history-container">
                            <!-- No previous workouts yet -->
                            <div class="col-12 text-center py-5" id="no-history">
                                <div class="py-5">
                                    <i class="lni lni-reload fs-1 text-muted mb-3"></i>
                                    <h4 class="text-muted">No workouts logged yet</h4>
                                    <p class="text-muted">Start a workout to begin building your history</p>
                                </div>
                            </div>
                            
                            <!-- Workout history will be displayed here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding exercise -->
    <div class="modal fade" id="addExerciseModal" tabindex="-1" aria-labelledby="addExerciseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addExerciseModalLabel">Add Exercise</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold mb-3">Choose Exercise Type</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="exercise-type" id="exercise-type-preset" value="preset" checked>
                            <label class="form-check-label" for="exercise-type-preset">
                                Select from predefined exercises
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exercise-type" id="exercise-type-custom" value="custom">
                            <label class="form-check-label" for="exercise-type-custom">
                                Create custom exercise
                            </label>
                        </div>
                    </div>
                    
                    <div id="preset-exercise-section" class="mb-3">
                        <label for="exercise-name" class="form-label">Exercise</label>
                        <select class="form-select" id="exercise-name">
                            <option value="">Select exercise...</option>
                            <!-- Exercises will be populated by JavaScript -->
                        </select>
                    </div>
                    
                    <div id="custom-exercise-section" class="mb-3" style="display: none;">
                        <label for="custom-exercise-name" class="form-label">Exercise Name</label>
                        <input type="text" class="form-control" id="custom-exercise-name" placeholder="Enter exercise name">
                        
                        <label for="custom-exercise-category" class="form-label mt-3">Category</label>
                        <select class="form-select" id="custom-exercise-category">
                            <option value="">Select category...</option>
                            <option value="Chest">Chest</option>
                            <option value="Back">Back</option>
                            <option value="Legs">Legs</option>
                            <option value="Shoulders">Shoulders</option>
                            <option value="Arms">Arms</option>
                            <option value="Core">Core</option>
                            <option value="Cardio">Cardio</option>
                            <option value="Full Body">Full Body</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="exercise-sets" class="form-label">Sets</label>
                                <input type="number" class="form-control" id="exercise-sets" min="1" value="3">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="exercise-reps" class="form-label">Reps</label>
                                <input type="number" class="form-control" id="exercise-reps" min="1" value="10">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="exercise-weight" class="form-label">Weight (kg)</label>
                        <input type="number" class="form-control" id="exercise-weight" step="0.5" min="0">
                    </div>
                    
                    <div class="mb-3">
                        <label for="exercise-notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="exercise-notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-exercise-btn">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for viewing workout details -->
    <div class="modal fade" id="workoutDetailsModal" tabindex="-1" aria-labelledby="workoutDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="workoutDetailsModalLabel">Workout Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="workout-details-content">
                    <!-- Details will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for selecting workout templates from the schedule -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="scheduleModalLabel">Choose from Training Schedule</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group" id="schedule-days-list">
                        <!-- Training schedule will be populated by JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="js/workout.js"></script>
    <script src="js/workout_log.js"></script>
</body>
</html> 