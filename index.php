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
    <title>GymLog - Din Personliga Träningsdagbok</title>
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
        
        .testimonial-card {
            border-radius: 15px;
            border: none;
            overflow: hidden;
        }
        
        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
        
        @media (max-width: 768px) {
            .hero-content {
                text-align: center;
            }
        }
    </style>
</head>

<body>
<div class="wrapper">
    <!--start of sidebar-->
    <?php include 'sidebar.php'; ?>
    <!--end of sidebar-->
    
    <div class="main p-3">
        <div class="content">
            <!-- Hero Section -->
            <div class="hero-section position-relative p-5 mb-5">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-7 hero-content">
                            <h1 class="display-4 fw-bold mb-4">Nå Dina Träningsmål med GymLog</h1>
                            <p class="lead mb-4">Din personliga träningsdagbok som hjälper dig att spåra, analysera och förbättra dina träningsresultat.</p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="day.php" class="btn btn-light btn-lg px-4">Börja Träna</a>
                                <a href="goal.php" class="btn btn-outline-light btn-lg px-4">Sätt Dina Mål</a>
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
                            <div class="stat-number">1000+</div>
                            <div class="text-muted">Nöjda Användare</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card stat-card shadow-sm h-100 p-3">
                            <div class="stat-number">150+</div>
                            <div class="text-muted">Träningsövningar</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card stat-card shadow-sm h-100 p-3">
                            <div class="stat-number">98%</div>
                            <div class="text-muted">Måluppfyllelse</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card stat-card shadow-sm h-100 p-3">
                            <div class="stat-number">24/7</div>
                            <div class="text-muted">Tillgänglighet</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Features Section -->
            <div class="container mb-5">
                <div class="text-center mb-5">
                    <h2 class="h1 mb-3">Vad GymLog Erbjuder</h2>
                    <p class="lead text-muted">Allt du behöver för att optimera din träning på ett ställe</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-calendar"></i>
                            </div>
                            <h3 class="h4 mb-3">Träningsschema</h3>
                            <p class="text-muted mb-0">Planera dina träningspass och skapa ett schema som passar din livsstil.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-stats-up"></i>
                            </div>
                            <h3 class="h4 mb-3">Spåra Framsteg</h3>
                            <p class="text-muted mb-0">Håll koll på dina framsteg med detaljerade grafer och statistik.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-target"></i>
                            </div>
                            <h3 class="h4 mb-3">Målsättning</h3>
                            <p class="text-muted mb-0">Sätt personliga mål och följ din väg mot att uppnå dem.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-restaurant"></i>
                            </div>
                            <h3 class="h4 mb-3">Nutritionsråd</h3>
                            <p class="text-muted mb-0">Få hjälp med att optimera ditt näringsintag för bästa resultat.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-weight"></i>
                            </div>
                            <h3 class="h4 mb-3">Vikthantering</h3>
                            <p class="text-muted mb-0">Spåra din vikt och kroppssammansättning för att nå dina målsättningar.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card feature-card shadow-sm h-100 p-4">
                            <div class="feature-icon">
                                <i class="lni lni-music"></i>
                            </div>
                            <h3 class="h4 mb-3">Träningsmusik</h3>
                            <p class="text-muted mb-0">Spela motiverande musik som hjälper dig att prestera bättre.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonials -->
            <div class="container mb-5">
                <div class="text-center mb-5">
                    <h2 class="h1 mb-3">Vad Våra Användare Säger</h2>
                    <p class="lead text-muted">Framgångshistorier från vårt community</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card testimonial-card shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User Avatar" class="testimonial-img me-3">
                                    <div>
                                        <h4 class="h5 mb-0">Erik Johansson</h4>
                                        <p class="text-muted small mb-0">Använder GymLog i 8 månader</p>
                                    </div>
                                </div>
                                <p class="mb-0">"GymLog har revolutionerat mitt sätt att träna. Jag har gått ner 15 kg och byggt den muskelmassa jag alltid drömt om. Rekommenderas starkt!"</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card testimonial-card shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User Avatar" class="testimonial-img me-3">
                                    <div>
                                        <h4 class="h5 mb-0">Sofia Lindberg</h4>
                                        <p class="text-muted small mb-0">Använder GymLog i 1 år</p>
                                    </div>
                                </div>
                                <p class="mb-0">"Att kunna spåra min framgång visuellt har gett mig en ökad motivation. Jag har äntligen nått mitt mål att springa en halvmaraton tack vare den strukturerade träningsplanen."</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card testimonial-card shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="User Avatar" class="testimonial-img me-3">
                                    <div>
                                        <h4 class="h5 mb-0">Marcus Ek</h4>
                                        <p class="text-muted small mb-0">Använder GymLog i 6 månader</p>
                                    </div>
                                </div>
                                <p class="mb-0">"Som nybörjare var jag överväldigad av all träningsinformation. GymLog gjorde allt enkelt att förstå och jag känner mig trygg i mitt träningsupplägg nu."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- CTA Section -->
            <div class="cta-section p-5 mb-5">
                <div class="container text-center">
                    <h2 class="display-5 fw-bold mb-4">Redo att Börja Din Träningsresa?</h2>
                    <p class="lead mb-4">Registrera dig idag och ta det första steget mot en starkare, hälsosammare framtid.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="auth/signup.php" class="btn btn-light btn-lg px-4">Skapa Konto</a>
                        <a href="auth/signin.php" class="btn btn-outline-light btn-lg px-4">Logga In</a>
                    </div>
                </div>
            </div>
            
            <!-- App Screenshots Section -->
            <div class="container mb-5">
                <div class="text-center mb-5">
                    <h2 class="h1 mb-3">Se GymLog i Aktion</h2>
                    <p class="lead text-muted">Upptäck funktionerna som gör GymLog till det perfekta verktyget för din träning</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <img src="https://via.placeholder.com/600x400/f8f9fa/212529?text=Träningsschema" class="card-img-top" alt="App Screenshot">
                            <div class="card-body">
                                <h5 class="card-title">Träningsschema</h5>
                                <p class="card-text text-muted">Planera dina träningspass enkelt och smidigt.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <img src="https://via.placeholder.com/600x400/f8f9fa/212529?text=Framstegsspårning" class="card-img-top" alt="App Screenshot">
                            <div class="card-body">
                                <h5 class="card-title">Framstegsspårning</h5>
                                <p class="card-text text-muted">Följ din utveckling med detaljerade statistik och grafer.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <img src="https://via.placeholder.com/600x400/f8f9fa/212529?text=Målsättning" class="card-img-top" alt="App Screenshot">
                            <div class="card-body">
                                <h5 class="card-title">Målsättning</h5>
                                <p class="card-text text-muted">Sätt och uppnå dina personliga träningsmål.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="container mt-5 pt-5 pb-3">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h3 class="h5 mb-3">GymLog</h3>
                        <p class="text-muted">Din personliga träningsdagbok för att spåra framsteg och uppnå dina mål.</p>
                    </div>
                    <div class="col-md-3 mb-4">
                        <h3 class="h5 mb-3">Snabblänkar</h3>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="day.php" class="text-decoration-none text-muted">Träningsschema</a></li>
                            <li class="mb-2"><a href="goal.php" class="text-decoration-none text-muted">Målsättning</a></li>
                            <li class="mb-2"><a href="vikt.php" class="text-decoration-none text-muted">Vikthantering</a></li>
                            <li class="mb-2"><a href="faq.php" class="text-decoration-none text-muted">Vanliga Frågor</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 mb-4">
                        <h3 class="h5 mb-3">Följ Oss</h3>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-muted fs-5"><i class="lni lni-facebook-original"></i></a>
                            <a href="#" class="text-muted fs-5"><i class="lni lni-instagram-original"></i></a>
                            <a href="#" class="text-muted fs-5"><i class="lni lni-twitter-original"></i></a>
                            <a href="#" class="text-muted fs-5"><i class="lni lni-youtube"></i></a>
                        </div>
                    </div>
                    <div class="col-md-2 mb-4">
                        <h3 class="h5 mb-3">Ladda Ner</h3>
                        <div class="d-flex flex-column gap-2">
                            <a href="#" class="btn btn-sm btn-outline-dark"><i class="lni lni-apple me-2"></i> App Store</a>
                            <a href="#" class="btn btn-sm btn-outline-dark"><i class="lni lni-play-store me-2"></i> Google Play</a>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-center text-muted">
                    <small>&copy; 2023 GymLog. Alla rättigheter förbehållna.</small>
                </div>
            </footer>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>