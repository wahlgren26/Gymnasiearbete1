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
    <title>Gymnasiearbete</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <link rel="stylesheet" href="css/day.css">
</head>

<body>
    <div class="wrapper">

        <?php include 'sidebar.php'; ?>


        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <h1 class="display-4 text-center mb-5">Weekly Exercise Schedule</h1>
                    
                    <div class="row g-4">
                        <?php
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        $bodyParts = [
                            'Chest', 'Back', 'Legs', 'Shoulders', 'Arms', 'Core', 
                            'Cardio', 'Rest Day', 'Full Body'
                        ];

                        foreach ($days as $day) {
                            $dayLower = strtolower($day);
                            echo '<div class="col-md-6 col-lg-4 mb-4">';
                            echo '<div class="card shadow-lg border-0 rounded-4 h-100" style="transition: transform 0.2s; cursor: pointer;" 
                                  onmouseover="this.style.transform=\'translateY(-5px)\'" 
                                  onmouseout="this.style.transform=\'translateY(0)\'">';
                            
                            echo '<div class="card-body p-4">';
                            echo '<div class="d-flex justify-content-between align-items-center mb-4">';
                            echo '<h3 class="card-title h4 fw-bold mb-0">' . htmlspecialchars($day) . '</h3>';
                            echo '<span class="badge bg-primary rounded-pill">Workout Day</span>';
                            echo '</div>';
                            
                            // Multi-select dropdown with checkboxes
                            echo '<div class="dropdown mb-4">';
                            echo '<button class="form-select form-select-lg border-0 bg-light rounded-3" type="button" 
                                  id="dropdown-' . $dayLower . '" data-bs-toggle="dropdown" aria-expanded="false">';
                            echo 'Choose workout focus';
                            echo '</button>';
                            echo '<ul class="dropdown-menu w-100 p-3 border-0 shadow-lg" aria-labelledby="dropdown-' . $dayLower . '">';
                            foreach ($bodyParts as $part) {
                                echo '<li class="mb-2">';
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="checkbox" value="' . htmlspecialchars($part) . '" 
                                      id="' . $dayLower . '-' . strtolower(str_replace(' ', '-', $part)) . '">';
                                echo '<label class="form-check-label w-100" for="' . $dayLower . '-' . strtolower(str_replace(' ', '-', $part)) . '">';
                                echo htmlspecialchars($part);
                                echo '</label>';
                                echo '</div>';
                                echo '</li>';
                            }
                            echo '<li class="mt-3">';
                            echo '<button class="btn btn-sm btn-primary w-100" onclick="updateWorkoutFocus(\'' . $dayLower . '\')">Apply Selection</button>';
                            echo '</li>';
                            echo '</ul>';
                            echo '</div>';

                            // Selected body parts display
                            echo '<div id="selected-parts-' . $dayLower . '" class="mb-4">';
                            echo '<div class="d-flex flex-wrap gap-2"></div>';
                            echo '</div>';

                            // Selected exercises display
                            echo '<div id="selected-exercises-' . $dayLower . '" class="mb-4">';
                            echo '<div class="selected-exercises-container"></div>';
                            echo '<button class="btn btn-outline-primary btn-sm mt-3 add-exercise-btn" onclick="showExerciseSelection(\'' . $dayLower . '\')" style="display: none;">';
                            echo '<i class="lni lni-plus me-2"></i>Add Exercise';
                            echo '</button>';
                            echo '</div>';

                            // Exercise selection dropdown (initially hidden)
                            echo '<div id="exercise-dropdowns-' . $dayLower . '" class="mb-4" style="display: none;">';
                            // This will be populated by JavaScript
                            echo '</div>';

                            // Exercise notes textarea
                            echo '<div class="mb-4">';
                            echo '<label for="notes-' . $dayLower . '" class="form-label text-muted small text-uppercase fw-bold">Additional Notes</label>';
                            echo '<textarea class="form-control bg-light border-0 rounded-3" id="notes-' . $dayLower . '" rows="4" 
                                placeholder="Enter additional notes, sets, reps, or weights here..." 
                                style="resize: none;"></textarea>';
                            echo '</div>';

                            // Save button with hover effect
                            echo '<button class="btn btn-primary btn-lg w-100 rounded-3" 
                                  style="transition: all 0.2s;"
                                  onmouseover="this.style.transform=\'scale(1.02)\'" 
                                  onmouseout="this.style.transform=\'scale(1)\'">
                                  <i class="lni lni-save me-2"></i>Save Workout</button>';
                            
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                    
                    <!-- Saved workout days section -->
                    <div class="mt-5 mb-5">
                        <h2 class="display-5 text-center mb-4">Your Saved Workout Days</h2>
                        
                        <div class="row" id="saved-workouts-container">
                            <!-- No saved workout days yet -->
                            <div class="col-12 text-center py-5" id="no-saved-workouts">
                                <div class="py-5">
                                    <i class="lni lni-calendar fs-1 text-muted mb-3"></i>
                                    <h4 class="text-muted">No saved workout days yet</h4>
                                    <p class="text-muted">Plan and save your workout days to see them here</p>
                                </div>
                            </div>
                            
                            <!-- Saved workout days will be displayed here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exercise Info Modal -->
    <div class="modal fade" id="exerciseInfoModal" tabindex="-1" aria-labelledby="exerciseInfoTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exerciseInfoTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="exerciseInfoBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for custom exercise -->
    <div class="modal fade" id="customExerciseModal" tabindex="-1" aria-labelledby="customExerciseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="customExerciseModalLabel">Add Custom Exercise</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="customExerciseForm">
                        <!-- Hidden inputs for day and body part -->
                        <input type="hidden" id="customExerciseDay" value="">
                        <input type="hidden" id="customExerciseBodyPart" value="">
                        
                        <div class="mb-3">
                            <label for="customExerciseName" class="form-label">Exercise Name</label>
                            <input type="text" class="form-control" id="customExerciseName" required>
                            <div class="invalid-feedback">
                                Please enter a name for the exercise
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="customExerciseDescription" class="form-label">Description (optional)</label>
                            <textarea class="form-control" id="customExerciseDescription" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="customExerciseLink" class="form-label">Link (optional)</label>
                            <input type="url" class="form-control" id="customExerciseLink" placeholder="https://example.com/exercise">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCustomExercise">Save Exercise</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exerciseModal" tabindex="-1" aria-labelledby="exerciseModalLabel" aria-hidden="true">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="js/workout.js"></script>
    <script src="js/workout_log.js"></script>
</body>
</html>
