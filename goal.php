<?php
// Include session handler at the very beginning
include 'session_handler.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gymnasiearbete</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
</head>

<body>
    <!-- Hidden input to store the current user ID for JavaScript -->
    <input type="hidden" id="current_user_id" value="<?php echo $_SESSION['user_id']; ?>">
    
    <div class="wrapper">

        <?php include 'sidebar.php'; ?>

        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <h1 class="display-4 text-center mb-5">Your Fitness Goals</h1>
                    
                    <!-- Goal Categories -->
                    <div class="row g-4 mb-5">
                        <!-- Strength Goals -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="lni lni-dumbbell fs-2 text-primary me-3"></i>
                                        <h3 class="h5 mb-0">Strength Goals</h3>
                                    </div>
                                    <div class="progress mb-3" style="height: 8px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 65%"></div>
                                    </div>
                                    <div class="mb-4" id="strengthGoalsContainer">
                                        <!-- Will be populated by JavaScript -->
                                    </div>
                                    <button class="btn btn-outline-primary btn-sm" id="addStrengthGoal">
                                        <i class="lni lni-plus me-1"></i>Add Goal
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Weight Goals -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="lni lni-weight fs-2 text-success me-3"></i>
                                        <h3 class="h5 mb-0">Weight Goals</h3>
                                    </div>
                                    <div class="progress mb-3" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                                    </div>
                                    <div class="text-center mb-4">
                                        <div class="display-6 mb-2 current-weight" id="currentWeight">Loading...</div>
                                        <div class="text-muted target-weight" id="targetWeight">Target: Loading...</div>
                                        <small class="text-success weight-remaining" id="weightRemaining">Calculating...</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-success btn-sm weight-update flex-grow-1" id="updateWeightGoal">
                                            <i class="lni lni-pencil me-1"></i>Update Goal
                                        </button>
                                        <a href="vikt.php" class="btn btn-outline-primary btn-sm flex-grow-1">
                                            <i class="lni lni-graph me-1"></i>View History
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Measurement Goals -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="lni lni-ruler fs-2 text-info me-3"></i>
                                        <h3 class="h5 mb-0">Measurements</h3>
                                    </div>
                                    <div class="progress mb-3" style="height: 8px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 45%"></div>
                                    </div>
                                    <div class="mb-4" id="measurementGoalsContainer">
                                        <!-- Will be populated by JavaScript -->
                                    </div>
                                    <button class="btn btn-outline-info btn-sm" id="addMeasurementGoal">
                                        <i class="lni lni-plus me-1"></i>Add Measurement
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Goals Summary Section -->
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="lni lni-stats-up fs-2 text-primary me-3"></i>
                                <h2 class="h3 mb-0">Your Progress Overview</h2>
                            </div>
                            <div class="row g-4" id="goalsSummary">
                                <div class="col-md-3 text-center">
                                    <div class="p-3 rounded bg-light">
                                        <i class="lni lni-checkmark-circle fs-1 text-success mb-2"></i>
                                        <h3 class="h5 mb-1" id="totalGoalsCount">0</h3>
                                        <p class="text-muted small mb-0">Active Goals</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="p-3 rounded bg-light">
                                        <i class="lni lni-medal fs-1 text-warning mb-2"></i>
                                        <h3 class="h5 mb-1" id="completedGoalsCount">0</h3>
                                        <p class="text-muted small mb-0">Goals Completed</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="p-3 rounded bg-light">
                                        <i class="lni lni-calendar fs-1 text-info mb-2"></i>
                                        <h3 class="h5 mb-1" id="goalStreakDays">0</h3>
                                        <p class="text-muted small mb-0">Day Streak</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="p-3 rounded bg-light">
                                        <i class="lni lni-star fs-1 text-danger mb-2"></i>
                                        <h3 class="h5 mb-1" id="motivationalMessage">Keep Going!</h3>
                                        <p class="text-muted small mb-0">Daily Motivation</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Goal Notes -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h3 class="h5 mb-3">Add Goal Note</h3>
                                    <form id="noteForm">
                                        <div class="mb-3">
                                            <input type="date" class="form-control" id="noteDate">
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control" rows="3" placeholder="Write your progress note here..." id="noteText"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <select class="form-select" id="noteType">
                                                <option value="note">Note</option>
                                                <option value="achievement">Achievement</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Note</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h3 class="h5 mb-3">Recent Notes</h3>
                                    <div class="timeline" id="notesTimeline">
                                        <!-- Will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Add Strength Goal Modal -->
    <div class="modal fade" id="strengthGoalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Strength Goal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="strengthGoalForm">
                        <div class="mb-3">
                            <label for="strengthExercise" class="form-label">Exercise</label>
                            <input type="text" class="form-control" id="strengthExercise" placeholder="e.g., Bench Press" required>
                        </div>
                        <div class="mb-3">
                            <label for="strengthCurrent" class="form-label">Current Weight</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="strengthCurrent" required>
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="strengthTarget" class="form-label">Target Weight</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="strengthTarget" required>
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveStrengthGoal">Save Goal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Strength Goal Modal -->
    <div class="modal fade" id="editStrengthGoalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Strength Progress</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editStrengthGoalForm">
                        <input type="hidden" id="editStrengthGoalId">
                        <div class="mb-3">
                            <label for="editStrengthCurrent" class="form-label">Current Weight</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="editStrengthCurrent" required>
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editStrengthTarget" class="form-label">Target Weight</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="editStrengthTarget" required>
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-auto" id="deleteStrengthGoal">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateStrengthGoal">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Measurement Goal Modal -->
    <div class="modal fade" id="measurementGoalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Measurement Goal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="measurementGoalForm">
                        <div class="mb-3">
                            <label for="measurementName" class="form-label">Measurement</label>
                            <input type="text" class="form-control" id="measurementName" placeholder="e.g., Chest, Arms, Waist" required>
                        </div>
                        <div class="mb-3">
                            <label for="measurementCurrent" class="form-label">Current</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="measurementCurrent" required>
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="measurementTarget" class="form-label">Target</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="measurementTarget" required>
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveMeasurementGoal">Save Goal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Measurement Goal Modal -->
    <div class="modal fade" id="editMeasurementGoalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Measurement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editMeasurementGoalForm">
                        <input type="hidden" id="editMeasurementGoalId">
                        <div class="mb-3">
                            <label for="editMeasurementCurrent" class="form-label">Current</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="editMeasurementCurrent" required>
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editMeasurementTarget" class="form-label">Target</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="editMeasurementTarget" required>
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-auto" id="deleteMeasurementGoal">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateMeasurementGoal">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Weight Goal Modal -->
    <div class="modal fade" id="weightGoalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Weight Goal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="weightGoalForm">
                        <div class="mb-3">
                            <label for="targetWeightInput" class="form-label">Target Weight</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="targetWeightInput" required>
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveWeightGoal">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="lni lni-checkmark me-2"></i>
                    <span id="toastMessage">Operation successful!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/goals.js"></script>
</body>
</html>
