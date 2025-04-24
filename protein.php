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
    <title>GymLog - Protein Calculator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <link rel="stylesheet" href="css/protein.css">
</head>

<body>
    <div class="wrapper">

        <?php include 'sidebar.php'; ?>


        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <h1 class="display-4 text-center mb-5">Protein Calculator</h1>

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <form id="proteinCalculator" class="mb-4">
                                        <div class="mb-3">
                                            <label for="weight" class="form-label">Your Weight (kg)</label>
                                            <input type="number" class="form-control" id="weight" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Activity Level</label>
                                            <select class="form-select" id="activityLevel" required>
                                                <option value="1.2">Sedentary (little or no exercise)</option>
                                                <option value="1.4">Light Exercise (1-3 days/week)</option>
                                                <option value="1.6" selected>Moderate Exercise (3-5 days/week)</option>
                                                <option value="1.8">Heavy Exercise (6-7 days/week)</option>
                                                <option value="2.0">Professional Athlete</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Goal</label>
                                            <select class="form-select" id="goal" required>
                                                <option value="1.6">Muscle Gain</option>
                                                <option value="1.2">Maintenance</option>
                                                <option value="1.8">Weight Loss (preserve muscle)</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">Calculate Protein Needs</button>
                                    </form>

                                    <div id="results" style="display: none;">
                                        <hr>
                                        <h3 class="text-center mb-4">Your Daily Protein Needs</h3>
                                        
                                        <div class="row text-center">
                                            <div class="col-md-4">
                                                <div class="card border-0 bg-light mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Minimum</h5>
                                                        <p class="card-text" id="minProtein">-</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card border-0 bg-primary text-white mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Optimal</h5>
                                                        <p class="card-text" id="optimalProtein">-</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card border-0 bg-light mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Maximum</h5>
                                                        <p class="card-text" id="maxProtein">-</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h4>Protein Sources Guide</h4>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Food (100g)</th>
                                                            <th>Protein</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Chicken Breast</td>
                                                            <td>31g</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Eggs (2 large)</td>
                                                            <td>13g</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Greek Yogurt</td>
                                                            <td>10g</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Salmon</td>
                                                            <td>25g</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Whey Protein (1 scoop)</td>
                                                            <td>24g</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script>
        document.getElementById('proteinCalculator').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const weight = parseFloat(document.getElementById('weight').value);
            const activityLevel = parseFloat(document.getElementById('activityLevel').value);
            const goal = parseFloat(document.getElementById('goal').value);
            
            // Updated calculations based on scientific recommendations
            let minProtein, optimalProtein, maxProtein;
            
            switch(document.getElementById('goal').value) {
                case "1.6": // Muscle Gain
                    minProtein = Math.round(weight * 1.6);     // Minimum for muscle gain
                    optimalProtein = Math.round(weight * 2.2); // Optimal for muscle gain
                    maxProtein = Math.round(weight * 2.8);     // Upper limit for intense training
                    break;
                
                case "1.2": // Maintenance
                    minProtein = Math.round(weight * 1.2);     // Minimum for maintenance
                    optimalProtein = Math.round(weight * 1.6); // Optimal for maintenance
                    maxProtein = Math.round(weight * 2.0);     // Upper limit for maintenance
                    break;
                
                case "1.8": // Weight Loss
                    minProtein = Math.round(weight * 1.8);     // Higher protein for muscle preservation
                    optimalProtein = Math.round(weight * 2.4); // Optimal for preventing muscle loss
                    maxProtein = Math.round(weight * 2.6);     // Upper limit during cut
                    break;
            }
            
            // Apply activity level modifier
            const activityModifier = parseFloat(document.getElementById('activityLevel').value);
            minProtein = Math.round(minProtein * activityModifier);
            optimalProtein = Math.round(optimalProtein * activityModifier);
            maxProtein = Math.round(maxProtein * activityModifier);
            
            // Display results
            document.getElementById('minProtein').textContent = `${minProtein}g`;
            document.getElementById('optimalProtein').textContent = `${optimalProtein}g`;
            document.getElementById('maxProtein').textContent = `${maxProtein}g`;
            
            // Show results section
            document.getElementById('results').style.display = 'block';
        });
    </script>
</body>
</html>
