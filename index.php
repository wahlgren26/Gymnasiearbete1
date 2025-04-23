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
    <title>GymLog - Your Personal Fitness Journal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebarstyle.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
            color: white;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80') right center;
            background-size: cover;
            opacity: 0.2;
            mix-blend-mode: overlay;
            pointer-events: none; /* This prevents the overlay from capturing clicks */
        }
        
        .hero-content {
            position: relative;
            z-index: 5; /* Ensure content stays above the overlay */
        }
        
        .hero-buttons {
            position: relative;
            z-index: 10; /* Higher z-index to ensure buttons are clickable */
        }
        
        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-card {
            text-align: center;
            border: none;
            border-radius: 15px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }
        
        .cta-section {
            background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
            color: white;
            border-radius: 15px;
        }
        
        .welcome-message {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #0d6efd;
        }
        
        .quick-access-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s;
        }
        
        .quick-access-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .quick-access-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #0d6efd;
        }
        
        @media (max-width: 768px) {
            .hero-content {
                text-align: center;
            }
        }
    </style>
</head>

<body>
<div class="wrapper">

    <?php include 'sidebar.php'; ?>


    <div class="main p-3">
        <div class="content">
            <?php if(isset($_SESSION['user_id'])): ?>
            <div class="welcome-message">
                <h4>Welcome, <?php echo htmlspecialchars($_SESSION['firstname']); ?>!</h4>
                <p>What would you like to do today? Register a new workout or perhaps update your goals?</p>
            </div>
            <?php endif; ?>
            
            <!-- Hero Section -->
            <div class="hero-section position-relative p-5 mb-5">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-7 hero-content">
                            <h1 class="display-4 fw-bold mb-4">Achieve Your Fitness Goals with GymLog</h1>
                            <p class="lead mb-4">Your personal fitness journal that helps you track, analyze, and improve your workout results.</p>
                            <div class="d-flex flex-wrap gap-2 hero-buttons">
                                <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="workout_log.php" class="btn btn-light btn-lg px-4">Start Training</a>
                                <a href="goal.php" class="btn btn-outline-light btn-lg px-4">Set Your Goals</a>
                                <?php else: ?>
                                <a href="auth/signup.php" class="btn btn-light btn-lg px-4">Get Started</a>
                                <a href="auth/signin.php" class="btn btn-outline-light btn-lg px-4">Log In</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-5 d-none d-lg-block">
                            <!-- Placeholder for potential image -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Section -->
            <div class="container mb-5">
                <div class="row g-4">
                    <div class="col-md-3 col-6">
                        <div class="card stat-card shadow-sm h-100 p-3">
                            <div class="stat-number">100%</div>
                            <div class="text-muted">Satisfied Users</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card stat-card shadow-sm h-100 p-3">
                            <div class="stat-number">150+</div>
                            <div class="text-muted">Exercises</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card stat-card shadow-sm h-100 p-3">
                            <div class="stat-number">98%</div>
                            <div class="text-muted">Goal Achievement</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card stat-card shadow-sm h-100 p-3">
                            <div class="stat-number">24/7</div>
                            <div class="text-muted">Availability</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Features Section -->
            <div class="container mb-5">
                <div class="text-center mb-5">
                    <h2 class="h1 mb-3">What GymLog Offers</h2>
                    <p class="lead text-muted">Everything you need to optimize your training in one place</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-calendar"></i>
                            </div>
                            <h3 class="h4 mb-3">Training Schedule</h3>
                            <p class="text-muted mb-0">Plan your workouts and create a schedule that fits your lifestyle.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-stats-up"></i>
                            </div>
                            <h3 class="h4 mb-3">Track Progress</h3>
                            <p class="text-muted mb-0">Keep track of your progress with detailed graphs and statistics.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-target"></i>
                            </div>
                            <h3 class="h4 mb-3">Goal Setting</h3>
                            <p class="text-muted mb-0">Set personal goals and follow your path to achieving them.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-restaurant"></i>
                            </div>
                            <h3 class="h4 mb-3">Nutrition Advice</h3>
                            <p class="text-muted mb-0">Get help optimizing your nutritional intake for best results.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-weight"></i>
                            </div>
                            <h3 class="h4 mb-3">Weight Management</h3>
                            <p class="text-muted mb-0">Track your weight and body composition to reach your targets.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-music"></i>
                            </div>
                            <h3 class="h4 mb-3">Workout Music</h3>
                            <p class="text-muted mb-0">Play motivating music that helps you perform better.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if(!isset($_SESSION['user_id'])): ?>
            <!-- CTA Section - Only shown to non-logged in users -->
            <div class="cta-section p-5 mb-5">
                <div class="container text-center">
                    <h2 class="display-5 fw-bold mb-4">Ready to Start Your Fitness Journey?</h2>
                    <p class="lead mb-4">Register today and take the first step toward a stronger, healthier future.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="auth/signup.php" class="btn btn-light btn-lg px-4">Create Account</a>
                        <a href="auth/signin.php" class="btn btn-outline-light btn-lg px-4">Log In</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['user_id'])): ?>
            <!-- Quick Access Section for logged in users -->
            <div class="container mb-5">
                <div class="text-center mb-5">
                    <h2 class="h1 mb-3">Quick Access</h2>
                    <p class="lead text-muted">Get quick access to the most used features</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <a href="workout_log.php" class="text-decoration-none">
                            <div class="card quick-access-card shadow-sm h-100 p-4 text-center">
                                <div class="quick-access-icon">
                                    <i class="lni lni-timer"></i>
                                </div>
                                <h3 class="h5 mb-2">New Workout</h3>
                                <p class="text-muted small mb-0">Log a new workout session</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="day.php" class="text-decoration-none">
                            <div class="card quick-access-card shadow-sm h-100 p-4 text-center">
                                <div class="quick-access-icon">
                                    <i class="lni lni-calendar"></i>
                                </div>
                                <h3 class="h5 mb-2">Weekly Schedule</h3>
                                <p class="text-muted small mb-0">Plan your training week</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="goal.php" class="text-decoration-none">
                            <div class="card quick-access-card shadow-sm h-100 p-4 text-center">
                                <div class="quick-access-icon">
                                    <i class="lni lni-target"></i>
                                </div>
                                <h3 class="h5 mb-2">Your Goals</h3>
                                <p class="text-muted small mb-0">Set and track your goals</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="vikt.php" class="text-decoration-none">
                            <div class="card quick-access-card shadow-sm h-100 p-4 text-center">
                                <div class="quick-access-icon">
                                    <i class="lni lni-weight"></i>
                                </div>
                                <h3 class="h5 mb-2">Weight Log</h3>
                                <p class="text-muted small mb-0">Track your weight progress</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <!-- Feature Showcase - Replaces screenshots for non-logged in users -->
            <div class="container mb-5">
                <div class="text-center mb-5">
                    <h2 class="h1 mb-3">Features in GymLog</h2>
                    <p class="lead text-muted">Discover the powerful tools that help you reach your fitness goals</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="mb-4" style="font-size: 3rem; color: #0d6efd;">
                                    <i class="lni lni-calendar"></i>
                                </div>
                                <h5 class="card-title">Weekly Schedule</h5>
                                <p class="card-text text-muted">Plan your workouts for each day of the week. Choose exercises, muscle groups and save your favorite workouts.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="mb-4" style="font-size: 3rem; color: #0d6efd;">
                                    <i class="lni lni-stats-up"></i>
                                </div>
                                <h5 class="card-title">Progress Analysis</h5>
                                <p class="card-text text-muted">Follow your development with detailed statistics and graphs. Track weight gains, repetitions and progress over time.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="mb-4" style="font-size: 3rem; color: #0d6efd;">
                                    <i class="lni lni-target"></i>
                                </div>
                                <h5 class="card-title">Goal Setting</h5>
                                <p class="card-text text-muted">Set personal training goals, track your progress and get motivation when you achieve your goals.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Footer -->
            <footer class="container mt-5 pt-5 pb-3">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h3 class="h5 mb-3">GymLog</h3>
                        <p class="text-muted">Your personal fitness journal for tracking progress and achieving your goals.</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h3 class="h5 mb-3">Quick Links</h3>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="day.php" class="text-decoration-none text-muted">Training Schedule</a></li>
                            <li class="mb-2"><a href="goal.php" class="text-decoration-none text-muted">Goal Setting</a></li>
                            <li class="mb-2"><a href="vikt.php" class="text-decoration-none text-muted">Weight Management</a></li>
                            <li class="mb-2"><a href="faq.php" class="text-decoration-none text-muted">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h3 class="h5 mb-3">Contact</h3>
                        <p class="text-muted">Have questions or feedback? <br>Email us at: <a href="mailto:support@gymlog.com" class="text-decoration-none">support@gymlog.com</a></p>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-center text-muted">
                    <small>&copy; 2025 GymLog. All rights reserved.</small>
                </div>
            </footer>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>
</html>