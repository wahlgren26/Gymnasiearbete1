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
    <title>Calorie Calculator - GymLog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <style>
        .results-card {
            display: none;
            transition: all 0.3s ease;
        }
        .nutrition-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .nutrition-card:hover {
            transform: translateY(-5px);
        }
        .nutrition-card .card-header {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .goal-description {
            font-size: 14px;
            color: #6c757d;
        }
        .formula-info {
            font-size: 14px;
            color: #6c757d;
            margin-top: 20px;
        }
        .food-table {
            font-size: 14px;
        }
        .food-table th {
            font-weight: 600;
        }
        .form-label {
            font-weight: 500;
        }
        #mealPlan {
            display: none;
        }
        .calorie-value {
            font-size: 24px;
            font-weight: bold;
            color: #0d6efd;
        }
        .unit-tabs {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <?php include 'sidebar.php'; ?>

        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <h1 class="display-4 text-center mb-3">Calorie Calculator</h1>
                    <p class="text-center mb-5">Calculate your daily calorie needs based on your age, gender, height, weight, and activity level</p>

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <form id="calorieCalculator">
                                        <!-- Units Selection -->
                                        <div class="unit-tabs">
                                            <ul class="nav nav-pills mb-3" id="unit-tabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="metric-tab" data-bs-toggle="pill" data-bs-target="#metric" type="button" role="tab">Metric (kg/cm)</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="imperial-tab" data-bs-toggle="pill" data-bs-target="#imperial" type="button" role="tab">Imperial (lb/in)</button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <!-- Metric Form -->
                                            <div class="tab-pane fade show active" id="metric" role="tabpanel">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="age" class="form-label">Age</label>
                                                        <input type="number" class="form-control" id="age" min="15" max="80" required>
                                                        <small class="text-muted">Ages 15-80</small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Gender</label>
                                                        <div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                                                                <label class="form-check-label" for="male">Male</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                                                <label class="form-check-label" for="female">Female</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="height-cm" class="form-label">Height (cm)</label>
                                                        <input type="number" class="form-control" id="height-cm" min="130" max="230" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="weight-kg" class="form-label">Weight (kg)</label>
                                                        <input type="number" class="form-control" id="weight-kg" min="40" max="160" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Imperial Form -->
                                            <div class="tab-pane fade" id="imperial" role="tabpanel">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="age-imperial" class="form-label">Age</label>
                                                        <input type="number" class="form-control" id="age-imperial" min="15" max="80" required>
                                                        <small class="text-muted">Ages 15-80</small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Gender</label>
                                                        <div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender-imperial" id="male-imperial" value="male" checked>
                                                                <label class="form-check-label" for="male-imperial">Male</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender-imperial" id="female-imperial" value="female">
                                                                <label class="form-check-label" for="female-imperial">Female</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Height</label>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="number" class="form-control" id="height-ft" min="4" max="7" placeholder="ft" required>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="number" class="form-control" id="height-in" min="0" max="11" placeholder="in" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="weight-lb" class="form-label">Weight (lb)</label>
                                                        <input type="number" class="form-control" id="weight-lb" min="88" max="353" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="activity" class="form-label">Activity Level</label>
                                            <select class="form-select" id="activity" required>
                                                <option value="1.2">Sedentary (little or no exercise)</option>
                                                <option value="1.375">Light (exercise 1-3 times/week)</option>
                                                <option value="1.55" selected>Moderate (exercise 4-5 times/week)</option>
                                                <option value="1.725">Active (daily exercise or intense exercise 3-4 times/week)</option>
                                                <option value="1.9">Very Active (intense exercise 6-7 times/week)</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="formula" class="form-label">BMR Estimation Formula</label>
                                            <select class="form-select" id="formula">
                                                <option value="mifflin" selected>Mifflin-St Jeor (recommended)</option>
                                                <option value="harris">Harris-Benedict</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">Calculate Calories</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Results Section -->
                            <div id="results" class="results-card">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card nutrition-card">
                                            <div class="card-header text-center">
                                                Your Daily Calorie Needs
                                            </div>
                                            <div class="card-body">
                                                <div class="row text-center">
                                                    <div class="col-12 my-2">
                                                        <p class="mb-1">Basal Metabolic Rate (BMR)</p>
                                                        <h3 class="calorie-value" id="bmr-value">0</h3>
                                                        <p class="small text-muted">Calories/day</p>
                                                    </div>
                                                </div>
                                                
                                                <hr>
                                                
                                                <div class="row">
                                                    <div class="col-sm-4 text-center my-2">
                                                        <p class="mb-1">Maintenance</p>
                                                        <h3 class="calorie-value" id="maintenance-value">0</h3>
                                                        <p class="goal-description">to maintain weight</p>
                                                    </div>
                                                    <div class="col-sm-4 text-center my-2">
                                                        <p class="mb-1">Weight Loss</p>
                                                        <h3 class="calorie-value" id="weight-loss-value">0</h3>
                                                        <p class="goal-description" id="loss-description">to lose 0.5kg/week</p>
                                                    </div>
                                                    <div class="col-sm-4 text-center my-2">
                                                        <p class="mb-1">Weight Gain</p>
                                                        <h3 class="calorie-value" id="weight-gain-value">0</h3>
                                                        <p class="goal-description" id="gain-description">to gain 0.5kg/week</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="accordion" id="calorieAccordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        Calories in Common Foods
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#calorieAccordion">
                                                    <div class="accordion-body">
                                                        <div class="table-responsive">
                                                            <table class="table food-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Food</th>
                                                                        <th>Serving Size</th>
                                                                        <th>Calories</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr><td colspan="3"><strong>Fruits</strong></td></tr>
                                                                    <tr><td>Apple</td><td>1 medium (100g)</td><td>59</td></tr>
                                                                    <tr><td>Banana</td><td>1 medium (120g)</td><td>151</td></tr>
                                                                    <tr><td>Grapes</td><td>150g</td><td>100</td></tr>
                                                                    <tr><td>Orange</td><td>1 medium (120g)</td><td>53</td></tr>
                                                                    <tr><td colspan="3"><strong>Vegetables</strong></td></tr>
                                                                    <tr><td>Broccoli</td><td>100g</td><td>45</td></tr>
                                                                    <tr><td>Carrots</td><td>100g</td><td>50</td></tr>
                                                                    <tr><td>Lettuce</td><td>100g</td><td>15</td></tr>
                                                                    <tr><td>Tomato</td><td>100g</td><td>22</td></tr>
                                                                    <tr><td colspan="3"><strong>Proteins</strong></td></tr>
                                                                    <tr><td>Chicken breast</td><td>100g cooked</td><td>165</td></tr>
                                                                    <tr><td>Egg</td><td>1 large (50g)</td><td>78</td></tr>
                                                                    <tr><td>Beef</td><td>100g cooked</td><td>250</td></tr>
                                                                    <tr><td>Salmon</td><td>100g cooked</td><td>208</td></tr>
                                                                    <tr><td>Quark</td><td>100g</td><td>90</td></tr>
                                                                    <tr><td colspan="3"><strong>Dairy & Breakfast</strong></td></tr>
                                                                    <tr><td>Milk (2%)</td><td>1 dl</td><td>50</td></tr>
                                                                    <tr><td>Yogurt</td><td>100g</td><td>80</td></tr>
                                                                    <tr><td>Cheese (Gouda)</td><td>30g</td><td>110</td></tr>
                                                                    <tr><td>Oatmeal</td><td>100g cooked</td><td>150</td></tr>
                                                                    <tr><td>Müsli</td><td>50g</td><td>190</td></tr>
                                                                    <tr><td colspan="3"><strong>Carbohydrates</strong></td></tr>
                                                                    <tr><td>Rice</td><td>100g cooked</td><td>130</td></tr>
                                                                    <tr><td>Pasta</td><td>100g cooked</td><td>160</td></tr>
                                                                    <tr><td>Bread</td><td>1 slice (30g)</td><td>75</td></tr>
                                                                    <tr><td>Potato</td><td>1 medium (150g)</td><td>130</td></tr>
                                                                    <tr><td>Rye bread</td><td>1 slice (40g)</td><td>90</td></tr>
                                                                    <tr><td colspan="3"><strong>Other</strong></td></tr>
                                                                    <tr><td>Pizza</td><td>1 slice (100g)</td><td>285</td></tr>
                                                                    <tr><td>Olive oil</td><td>1 tbsp (15ml)</td><td>120</td></tr>
                                                                    <tr><td>Chocolate</td><td>30g</td><td>160</td></tr>
                                                                    <tr><td>Wine</td><td>1 glass (150ml)</td><td>125</td></tr>
                                                                    <tr><td>Beer</td><td>330ml</td><td>150</td></tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Calories Burned in Common Activities
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#calorieAccordion">
                                                    <div class="accordion-body">
                                                        <div class="table-responsive">
                                                            <table class="table food-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Activity (1 hour)</th>
                                                                        <th>Calories Burned</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="activities-table">
                                                                    <tr><td>Walking (3.5 mph)</td><td id="walking">0</td></tr>
                                                                    <tr><td>Running (6 mph)</td><td id="running">0</td></tr>
                                                                    <tr><td>Cycling (12-14 mph)</td><td id="cycling">0</td></tr>
                                                                    <tr><td>Swimming</td><td id="swimming">0</td></tr>
                                                                    <tr><td>Weight Training</td><td id="weights">0</td></tr>
                                                                    <tr><td>Basketball</td><td id="basketball">0</td></tr>
                                                                    <tr><td>Soccer</td><td id="soccer">0</td></tr>
                                                                    <tr><td>Tennis</td><td id="tennis">0</td></tr>
                                                                    <tr><td>Dancing</td><td id="dancing">0</td></tr>
                                                                    <tr><td>Yoga</td><td id="yoga">0</td></tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <p class="small text-muted">* Values estimated based on your weight. Actual calories burned may vary.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Formula Information
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#calorieAccordion">
                                                    <div class="accordion-body">
                                                        <h5>Mifflin-St Jeor Equation:</h5>
                                                        <p>For men: BMR = 10 × weight(kg) + 6.25 × height(cm) - 5 × age(y) + 5</p>
                                                        <p>For women: BMR = 10 × weight(kg) + 6.25 × height(cm) - 5 × age(y) - 161</p>
                                                        
                                                        <h5>Harris-Benedict Equation:</h5>
                                                        <p>For men: BMR = 13.397 × weight(kg) + 4.799 × height(cm) - 5.677 × age(y) + 88.362</p>
                                                        <p>For women: BMR = 9.247 × weight(kg) + 3.098 × height(cm) - 4.330 × age(y) + 447.593</p>
                                                        
                                                        <p class="formula-info">The Mifflin-St Jeor Equation is considered the most accurate equation for calculating BMR for the general population. The Harris-Benedict Equation was one of the earliest equations used but tends to overestimate calories.</p>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
        // Sync form fields between metric and imperial
        document.getElementById('age').addEventListener('input', function() {
            document.getElementById('age-imperial').value = this.value;
        });

        document.getElementById('age-imperial').addEventListener('input', function() {
            document.getElementById('age').value = this.value;
        });

        document.getElementById('male').addEventListener('change', function() {
            document.getElementById('male-imperial').checked = true;
        });

        document.getElementById('female').addEventListener('change', function() {
            document.getElementById('female-imperial').checked = true;
        });

        document.getElementById('male-imperial').addEventListener('change', function() {
            document.getElementById('male').checked = true;
        });

        document.getElementById('female-imperial').addEventListener('change', function() {
            document.getElementById('female').checked = true;
        });

        // Convert between metric and imperial
        document.getElementById('height-cm').addEventListener('input', function() {
            const cm = parseFloat(this.value);
            if (!isNaN(cm)) {
                const inches = cm / 2.54;
                const feet = Math.floor(inches / 12);
                const remainingInches = Math.round(inches % 12);
                
                document.getElementById('height-ft').value = feet;
                document.getElementById('height-in').value = remainingInches;
            }
        });

        document.getElementById('weight-kg').addEventListener('input', function() {
            const kg = parseFloat(this.value);
            if (!isNaN(kg)) {
                const lb = Math.round(kg * 2.20462);
                document.getElementById('weight-lb').value = lb;
            }
        });

        function updateHeightFromImperial() {
            const feet = parseFloat(document.getElementById('height-ft').value) || 0;
            const inches = parseFloat(document.getElementById('height-in').value) || 0;
            const totalInches = feet * 12 + inches;
            const cm = Math.round(totalInches * 2.54);
            document.getElementById('height-cm').value = cm;
        }

        document.getElementById('height-ft').addEventListener('input', updateHeightFromImperial);
        document.getElementById('height-in').addEventListener('input', updateHeightFromImperial);

        document.getElementById('weight-lb').addEventListener('input', function() {
            const lb = parseFloat(this.value);
            if (!isNaN(lb)) {
                const kg = Math.round((lb / 2.20462) * 10) / 10;
                document.getElementById('weight-kg').value = kg;
            }
        });

        // Main calculator function
        document.getElementById('calorieCalculator').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get active tab (metric or imperial)
            const metricActive = document.getElementById('metric-tab').classList.contains('active');
            
            // Get form values
            let age, gender, height, weight;
            
            if (metricActive) {
                age = parseFloat(document.getElementById('age').value);
                gender = document.querySelector('input[name="gender"]:checked').value;
                height = parseFloat(document.getElementById('height-cm').value);
                weight = parseFloat(document.getElementById('weight-kg').value);
            } else {
                age = parseFloat(document.getElementById('age-imperial').value);
                gender = document.querySelector('input[name="gender-imperial"]:checked').value;
                const feet = parseFloat(document.getElementById('height-ft').value) || 0;
                const inches = parseFloat(document.getElementById('height-in').value) || 0;
                height = Math.round((feet * 12 + inches) * 2.54); // Convert to cm
                weight = parseFloat(document.getElementById('weight-lb').value) / 2.20462; // Convert to kg
            }
            
            const activity = parseFloat(document.getElementById('activity').value);
            const formula = document.getElementById('formula').value;
            
            // Calculate BMR
            let bmr;
            if (formula === 'mifflin') {
                // Mifflin-St Jeor Equation
                if (gender === 'male') {
                    bmr = 10 * weight + 6.25 * height - 5 * age + 5;
                } else {
                    bmr = 10 * weight + 6.25 * height - 5 * age - 161;
                }
            } else {
                // Harris-Benedict Equation
                if (gender === 'male') {
                    bmr = 13.397 * weight + 4.799 * height - 5.677 * age + 88.362;
                } else {
                    bmr = 9.247 * weight + 3.098 * height - 4.330 * age + 447.593;
                }
            }
            
            // Calculate TDEE (Total Daily Energy Expenditure)
            const maintenance = Math.round(bmr * activity);
            const weightLoss = Math.round(maintenance - 500); // 500 calorie deficit for weight loss
            const weightGain = Math.round(maintenance + 500); // 500 calorie surplus for weight gain
            
            // Display results
            document.getElementById('bmr-value').textContent = Math.round(bmr);
            document.getElementById('maintenance-value').textContent = maintenance;
            document.getElementById('weight-loss-value').textContent = weightLoss;
            document.getElementById('weight-gain-value').textContent = weightGain;
            
            // Update goal descriptions based on units
            if (metricActive) {
                document.getElementById('loss-description').textContent = 'to lose 0.5kg/week';
                document.getElementById('gain-description').textContent = 'to gain 0.5kg/week';
            } else {
                document.getElementById('loss-description').textContent = 'to lose 1lb/week';
                document.getElementById('gain-description').textContent = 'to gain 1lb/week';
            }
            
            // Calculate calories burned based on weight (estimations)
            const weightInLbs = weight * 2.20462;
            
            document.getElementById('walking').textContent = Math.round(weightInLbs * 0.3);
            document.getElementById('running').textContent = Math.round(weightInLbs * 0.73);
            document.getElementById('cycling').textContent = Math.round(weightInLbs * 0.49);
            document.getElementById('swimming').textContent = Math.round(weightInLbs * 0.58);
            document.getElementById('weights').textContent = Math.round(weightInLbs * 0.39);
            document.getElementById('basketball').textContent = Math.round(weightInLbs * 0.42);
            document.getElementById('soccer').textContent = Math.round(weightInLbs * 0.45);
            document.getElementById('tennis').textContent = Math.round(weightInLbs * 0.45);
            document.getElementById('dancing').textContent = Math.round(weightInLbs * 0.35);
            document.getElementById('yoga').textContent = Math.round(weightInLbs * 0.23);
            
            // Show results
            document.getElementById('results').style.display = 'block';
            
            // Scroll to results
            document.getElementById('results').scrollIntoView({ behavior: 'smooth' });
        });
    </script>
</body>
</html> 