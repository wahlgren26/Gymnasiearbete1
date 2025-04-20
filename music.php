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
    <link rel="stylesheet" href="css/music.css">
</head>

<body>
    <div class="wrapper">
        <!--start of sidebar-->
        <?php include 'sidebar.php'; ?>
        <!--end of sidebar-->
        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <h1 class="display-4 text-center mb-5">Workout Music & Motivation</h1>
                    
                    <!-- Playlists Section -->
                    <div class="row g-4 mb-5">
                        <?php
                        $playlists = [
                            [
                                'title' => 'Workout Hits',
                                'description' => 'Get pumped with these workout hits!',
                                'embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DX76Wlfdnj7AP'
                            ],
                            [
                                'title' => 'Cardio Mix',
                                'description' => 'Keep your heart rate up with this cardio mix!',
                                'embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DXdxcBWuJkbcy'
                            ]
                        ];

                        foreach ($playlists as $playlist) {
                            echo '<div class="col-md-6 col-sm-12">';
                            echo '<div class="card shadow-sm hover-card">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title fw-bold mb-3">' . htmlspecialchars($playlist['title']) . '</h5>';
                            echo '<p class="card-text text-muted">' . htmlspecialchars($playlist['description']) . '</p>';
                            echo '<iframe src="' . htmlspecialchars($playlist['embed_url']) . '" width="100%" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media" class="rounded"></iframe>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <!-- Motivation Quotes Section -->
                    <h2 class="display-6 text-center mb-4">Daily Motivation</h2>
                    <div class="row g-4">
                        <?php
                        $quotes = [
                            "The only bad workout is the one that didn't happen.",
                            "Your body can stand almost anything. It's your mind you have to convince.",
                            "The hard days are what make you stronger.",
                            "Don't stop when you're tired. Stop when you're done."
                        ];

                        foreach ($quotes as $quote) {
                            echo '<div class="col-md-3 col-sm-6">';
                            echo '<div class="card quote-card h-100 shadow-sm">';
                            echo '<div class="card-body d-flex align-items-center justify-content-center text-center">';
                            echo '<p class="card-text fw-light">' . htmlspecialchars($quote) . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
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

</body>

</html>