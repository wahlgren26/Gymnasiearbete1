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
    <title>Gymnasiearbete - FAQ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <link rel="stylesheet" href="css/faq.css">
</head>

<body>
    <div class="wrapper">

        <?php include 'sidebar.php'; ?>

        <div class="main p-3">
            <div class="content">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1>Gym Workout FAQ</h1>
                    </div>

                    <!-- FAQ Sections -->
                    <div class="accordion" id="faqAccordion">
                        <!-- Training & Workouts Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#section1">
                                    1. Training & Workouts
                                </button>
                            </h2>
                            <div id="section1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <h4>How often should I work out?</h4>
                                    <p>It depends on your goal and experience level:</p>
                                    <ul>
                                        <li>Beginner: 3-4 days per week</li>
                                        <li>Intermediate: 4-5 days per week</li>
                                        <li>Advanced: 5-6 days per week</li>
                                    </ul>

                                    <h4>What is the best workout split?</h4>
                                    <p>There is no "best" split, but here are some popular ones:</p>
                                    <ul>
                                        <li>Full Body (3x per week) – Good for beginners</li>
                                        <li>Upper/Lower (4x per week) – Balances muscle recovery</li>
                                        <li>Push/Pull/Legs (PPL) (5-6x per week) – For serious lifters</li>
                                        <li>Bro Split (1 muscle per day) – Not the most efficient but works for some</li>
                                    </ul>

                                    <h4>How long should a workout be?</h4>
                                    <p>45-75 minutes is a good range. Focus on quality over quantity.</p>

                                    <h4>Is cardio necessary?</h4>
                                    <p>Not always, but it's useful for heart health and fat loss. Do LISS (walking, cycling) or HIIT depending on your goals.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Muscle Building & Strength Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#section2">
                                    2. Muscle Building & Strength
                                </button>
                            </h2>
                            <div id="section2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <h4>How many reps and sets should I do?</h4>
                                    <ul>
                                        <li>Strength: 4-6 reps, heavy weight</li>
                                        <li>Muscle Growth: 8-12 reps, moderate weight</li>
                                        <li>Endurance: 12-20 reps, lighter weight</li>
                                    </ul>

                                    <h4>How long does it take to see results?</h4>
                                    <ul>
                                        <li>Strength gains: 2-4 weeks</li>
                                        <li>Muscle growth: 8-12 weeks</li>
                                        <li>Fat loss: 4-8 weeks</li>
                                    </ul>

                                    <h4>Should I train to failure?</h4>
                                    <p>Not every set. Save it for the last set of an exercise.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nutrition & Diet Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#section3">
                                    3. Nutrition & Diet
                                </button>
                            </h2>
                            <div id="section3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <h4>How much protein do I need?</h4>
                                    <p>1.6-2.2g per kg of body weight is ideal for muscle growth.</p>

                                    <h4>Best foods for muscle building?</h4>
                                    <ul>
                                        <li>Protein: Chicken, beef, fish, eggs, tofu</li>
                                        <li>Carbs: Rice, oats, potatoes, whole grains</li>
                                        <li>Fats: Nuts, avocados, olive oil, fish</li>
                                    </ul>

                                    <h4>Should I eat before or after workouts?</h4>
                                    <ul>
                                        <li>Before: Light meal with carbs & protein 1-2 hours before</li>
                                        <li>After: Protein & carbs within 1-2 hours</li>
                                    </ul>

                                    <h4>Do I need supplements?</h4>
                                    <p>Not necessary, but helpful:</p>
                                    <ul>
                                        <li>Protein Powder – Convenient</li>
                                        <li>Creatine – Strength & muscle growth</li>
                                        <li>Pre-Workout – Energy boost</li>
                                        <li>Multivitamins & Omega-3 – General health</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Fat Loss & Cutting Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#section4">
                                    4. Fat Loss & Cutting
                                </button>
                            </h2>
                            <div id="section4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <h4>Best way to lose fat?</h4>
                                    <ul>
                                        <li>Caloric Deficit (eat fewer calories than you burn)</li>
                                        <li>Strength Training (to keep muscle)</li>
                                        <li>Cardio (for extra calorie burn)</li>
                                    </ul>

                                    <h4>Should I do fasted cardio?</h4>
                                    <p>It's optional. Some people like it, but it doesn't make a huge difference.</p>

                                    <h4>How do I avoid muscle loss when cutting?</h4>
                                    <ul>
                                        <li>Eat enough protein</li>
                                        <li>Lift heavy</li>
                                        <li>Avoid extreme calorie cuts</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Recovery & Rest Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#section5">
                                    5. Recovery & Rest
                                </button>
                            </h2>
                            <div id="section5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <h4>How important is sleep?</h4>
                                    <p>Very! Aim for 7-9 hours to recover and grow muscle.</p>

                                    <h4>How do I reduce muscle soreness?</h4>
                                    <ul>
                                        <li>Proper warm-up & cool-down</li>
                                        <li>Stay hydrated</li>
                                        <li>Active recovery (light movement)</li>
                                    </ul>

                                    <h4>How many rest days do I need?</h4>
                                    <p>1-2 days per week is usually enough. Listen to your body.</p>
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
</body>
</html>
