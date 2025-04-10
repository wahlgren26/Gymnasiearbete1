<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymLog - Profil</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sidebarstyle.css">
    <link rel="stylesheet" href="profile.css">
</head>

<body>
<div class="wrapper">
    <?php include 'sidebar.php'; ?>
    
    <div class="main p-3">
        <div class="profile-container">
            <div class="profile-header">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="profile-top">
                        <img src="MSNexample.png" alt="Profilbild" class="profile-image">
                        <div class="profile-info">
                            <h2>Anders Andersson</h2>
                            <div class="member-since">Medlem sedan: Januari 2024</div>
                        </div>
                    </div>
                    <a href="editprofile.php" class="btn btn-primary"><i class="lni lni-pencil"></i> Redigera profil</a>
                </div>
                <div class="profile-description">
                    Tränat aktivt i 3 år med fokus på styrketräning. Gillar att pusha mig själv till nya nivåer 
                    och hjälpa andra nå sina träningsmål. Specialiserad inom powerlifting och 
                    funktionell träning.
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="stats-card">
                        <h4>Personlig Information</h4>
                        <hr>
                        <p><strong>Ålder:</strong> 28 år</p>
                        <p><strong>Längd:</strong> 180 cm</p>
                        <p><strong>Vikt:</strong> 75 kg</p>
                        <p><strong>Mål:</strong> Styrkeökning och muskeltillväxt</p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="stats-card">
                        <h4>Personbästa</h4>
                        <hr>
                        <p><strong>Bänkpress:</strong> 100 kg</p>
                        <p><strong>Marklyft:</strong> 160 kg</p>
                        <p><strong>Knäböj:</strong> 120 kg</p>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <h4>Träningsstatistik</h4>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-sm-12 text-center mb-3 mb-md-0">
                        <h5>Pass denna månad</h5>
                        <p class="h2">12</p>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center mb-3 mb-md-0">
                        <h5>Träningstimmar</h5>
                        <p class="h2">18</p>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center">
                        <h5>Aktiva program</h5>
                        <p class="h2">2</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html> 