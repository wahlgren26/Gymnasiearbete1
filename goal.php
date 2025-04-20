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
    <div class="wrapper">
        <!--start of sidebar-->
<?php include 'sidebar.php'; ?>
<!--end of sidebar-->
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
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Bench Press</span>
                                            <span class="strength-value" style="cursor: pointer">80/100 kg</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Squat</span>
                                            <span>120/150 kg</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Deadlift</span>
                                            <span>140/180 kg</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-primary btn-sm">
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
                                        <button class="btn btn-outline-success btn-sm weight-update flex-grow-1">
                                            <i class="lni lni-pencil me-1"></i>Update Weight
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
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Chest</span>
                                            <span class="measurement-value" style="cursor: pointer">100/105 cm</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Arms</span>
                                            <span>35/40 cm</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Waist</span>
                                            <span>85/80 cm</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-info btn-sm">
                                        <i class="lni lni-pencil me-1"></i>Update Measurements
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Progress -->
                    <h2 class="h3 mb-4">Weekly Progress</h2>
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body">
                            <canvas id="progressChart" height="100"></canvas>
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
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control" rows="3" placeholder="Write your progress note here..."></textarea>
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
                                    <div class="timeline">
                                        <div class="timeline-item mb-3 pb-3 border-bottom">
                                            <div class="d-flex justify-content-between mb-1">
                                                <strong>March 15, 2024</strong>
                                                <span class="badge bg-success">Achievement</span>
                                            </div>
                                            <p class="text-muted mb-0">Hit new PR on bench press: 80kg!</p>
                                        </div>
                                        <div class="timeline-item mb-3 pb-3 border-bottom">
                                            <div class="d-flex justify-content-between mb-1">
                                                <strong>March 10, 2024</strong>
                                                <span class="badge bg-primary">Note</span>
                                            </div>
                                            <p class="text-muted mb-0">Consistency in diet is improving. Keeping up with meal prep.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Initialize progress chart
        const ctx = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Workout Completion',
                    data: [100, 80, 90, 85, 95, 75, 88],
                    borderColor: '#0d6efd',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Handle strength goals updates
        document.querySelectorAll('.strength-value').forEach(value => {
            value.addEventListener('click', function() {
                const currentValue = this.textContent.split('/')[0];
                const targetValue = this.textContent.split('/')[1];
                const newValue = prompt('Enter new current value (kg):', currentValue);
                
                if (newValue && !isNaN(newValue)) {
                    this.textContent = `${newValue}/${targetValue}`;
                    updateProgressBar(this.closest('.card').querySelector('.progress-bar'), 
                        (newValue / parseInt(targetValue)) * 100);
                }
            });
        });

        // Handle measurements updates
        document.querySelectorAll('.measurement-value').forEach(value => {
            value.addEventListener('click', function() {
                const currentValue = this.textContent.split('/')[0];
                const targetValue = this.textContent.split('/')[1];
                const newValue = prompt('Enter new measurement (cm):', currentValue);
                
                if (newValue && !isNaN(newValue)) {
                    this.textContent = `${newValue}/${targetValue}`;
                    updateProgressBar(this.closest('.card').querySelector('.progress-bar'), 
                        (newValue / parseInt(targetValue)) * 100);
                }
            });
        });

        // Handle notes submission
        document.getElementById('noteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const date = this.querySelector('input[type="date"]').value;
            const note = this.querySelector('textarea').value;
            
            if (date && note) {
                const noteHTML = `
                    <div class="timeline-item mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between mb-1">
                            <strong>${new Date(date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</strong>
                            <span class="badge bg-primary">Note</span>
                        </div>
                        <p class="text-muted mb-0">${note}</p>
                    </div>
                `;
                
                document.querySelector('.timeline').insertAdjacentHTML('afterbegin', noteHTML);
                this.reset();
            }
        });

        // Helper function to update progress bars
        function updateProgressBar(progressBar, percentage) {
            progressBar.style.width = `${Math.min(100, Math.max(0, percentage))}%`;
        }

        // Function to update weight display
        function updateWeightDisplay() {
            // Get the latest weight from localStorage
            const weightData = JSON.parse(localStorage.getItem('weightData') || '[]');
            const targetWeight = localStorage.getItem('targetWeight') || 70; // Default target weight
            
            if (weightData.length > 0) {
                const currentWeight = weightData[weightData.length - 1].weight;
                const remaining = Math.abs(currentWeight - targetWeight);
                
                // Update the display
                document.getElementById('currentWeight').textContent = `${currentWeight} kg`;
                document.getElementById('targetWeight').textContent = `Target: ${targetWeight} kg`;
                document.getElementById('weightRemaining').textContent = `${remaining} kg to go!`;
                
                // Update progress bar
                const progressBar = document.querySelector('.progress-bar');
                const progress = (1 - (remaining / 10)) * 100; // Assuming 10kg is max difference
                updateProgressBar(progressBar, progress);
            }
        }

        // Handle weight updates
        document.querySelector('.weight-update').addEventListener('click', function() {
            const currentWeight = parseFloat(document.getElementById('currentWeight').textContent);
            const newWeight = prompt('Enter your current weight (kg):', currentWeight);
            
            if (newWeight && !isNaN(newWeight)) {
                // Save to localStorage
                const weightData = JSON.parse(localStorage.getItem('weightData') || '[]');
                weightData.push({
                    date: new Date().toISOString(),
                    weight: parseFloat(newWeight)
                });
                localStorage.setItem('weightData', JSON.stringify(weightData));
                
                // Update display
                updateWeightDisplay();
            }
        });

        // Initial load
        document.addEventListener('DOMContentLoaded', function() {
            updateWeightDisplay();
            
            // Listen for weight updates from other pages
            window.addEventListener('storage', function(e) {
                if (e.key === 'weightData') {
                    updateWeightDisplay();
                }
            });
        });
    </script>
</body>
</html>
