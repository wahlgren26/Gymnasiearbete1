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
    <title>GymLog - Weight Log</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/vikt.css">
</head>

<body>
    <!-- Hidden input to store the current user ID for JavaScript -->
    <input type="hidden" id="current_user_id" value="<?php echo $_SESSION['user_id']; ?>">
    
    <div class="wrapper">

        <?php include 'sidebar.php'; ?>

        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <h1 class="display-4 text-center mb-5">Weight Tracker</h1>

                    <!-- Weight Input Form -->
                    <div class="row justify-content-center mb-5">
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="card-title mb-4">Log Your Weight</h5>
                                    <form id="weightForm">
                                        <div class="mb-3">
                                            <label for="weight" class="form-label">Weight</label>
                                            <div class="input-group">
                                                <input type="number" step="0.1" class="form-control" id="weight" required>
                                                <span class="input-group-text">kg</span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="date" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Notes (optional)</label>
                                            <textarea class="form-control" id="notes" rows="2" placeholder="How was your workout?"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Log Weight</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Target Weight Section -->
                    <div class="row justify-content-center mb-5">
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="card-title mb-4">Set Target Weight</h5>
                                    <form id="targetForm">
                                        <div class="mb-3">
                                            <label for="targetWeight" class="form-label">Target Weight</label>
                                            <div class="input-group">
                                                <input type="number" step="0.1" class="form-control" id="targetWeight" required>
                                                <span class="input-group-text">kg</span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100">Set Target</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Weight History -->
                    <div class="row mb-5">
                        <div class="col-md-8">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Weight Progress Chart</h5>
                                    <canvas id="weightChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Statistics</h5>
                                    <div class="stats-item mb-3">
                                        <label class="text-muted">Starting Weight</label>
                                        <h4 id="startWeight">-- kg</h4>
                                    </div>
                                    <div class="stats-item mb-3">
                                        <label class="text-muted">Current Weight</label>
                                        <h4 id="currentWeight">-- kg</h4>
                                    </div>
                                    <div class="stats-item mb-3">
                                        <label class="text-muted">Target Weight</label>
                                        <h4 id="targetWeightDisplay">-- kg</h4>
                                    </div>
                                    <div class="stats-item">
                                        <label class="text-muted">Total Change</label>
                                        <h4 id="weightChange">-- kg</h4>
                                    </div>
                                    <div class="stats-item mt-3">
                                        <label class="text-muted">Progress to Goal</label>
                                        <div class="progress mt-2">
                                            <div id="goalProgress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <small id="goalProgressText" class="text-muted mt-1 d-block">--</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Entries Table -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Recent Entries</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Weight</th>
                                            <th>Change</th>
                                            <th>Notes</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="weightHistory">
                                        <!-- Data will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast container for notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <!-- Toast notifications will be added here -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="js/weight-tracker.js"></script>
</body>

</html>