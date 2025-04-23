<?php
// Include session handler at the very beginning
include 'session_handler.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/signin.php");
    exit();
}

// Function to get the daily quote
function getDailyQuote() {
    $quotes = [
        "The only bad workout is the one that didn't happen.",
        "Your body can stand almost anything. It's your mind you have to convince.",
        "The hard days are what make you stronger.",
        "Don't stop when you're tired. Stop when you're done.",
        "Success isn't always about greatness. It's about consistency.",
        "The body achieves what the mind believes.",
        "Strength does not come from the body. It comes from the will.",
        "The difference between try and triumph is a little umph.",
        "The pain you feel today will be the strength you feel tomorrow.",
        "If it doesn't challenge you, it doesn't change you.",
        "Wake up with determination. Go to bed with satisfaction.",
        "Good things come to those who sweat.",
        "Your only limit is you.",
        "Be stronger than your excuses.",
        "It's not about having time, it's about making time."
    ];
    
    // Use today's date as seed for the random selection
    $day = date('z') + date('Y') * 1000; // Day of year plus year
    srand($day);
    $index = rand(0, count($quotes) - 1);
    srand(); // Reset the seed
    
    return $quotes[$index];
}

// Define playlists by category
$playlistCategories = [
    'cardio' => [
        'title' => 'Cardio',
        'icon' => 'lni lni-heart',
        'playlists' => [
            [
                'title' => 'Beast Mode Running',
                'description' => 'Energetic hits to power your run or cardio session',
                'embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DX76Wlfdnj7AP'
            ],
            [
                'title' => 'Hype',
                'description' => 'Need some motivation? This playlist will hype you up for your workout',
                'embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DX4eRPd9frC1m'
            ]
        ]
    ],
    'strength' => [
        'title' => 'Strength Training',
        'icon' => 'lni lni-bolt',
        'playlists' => [
            [
                'title' => 'Workout',
                'description' => 'Pop hits to soundtrack your workout',
                'embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DX70RN3TfWWJh'
            ],
            [
                'title' => 'Power Workout',
                'description' => 'Bass-heavy bangers for your lifting session',
                'embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DWUVpAXiEPK8P'
            ]
        ]
    ],
    'chill' => [
        'title' => 'Yoga & Stretching',
        'icon' => 'lni lni-surf-board',
        'playlists' => [
            [
                'title' => 'Chill Hits',
                'description' => 'Modern chill hits for your cool down or stretching',
                'embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DX0MLFaUdXnjA'
            ],
            [
                'title' => 'Lo-Fi Beats',
                'description' => 'Chill beats for focus, yoga and recovery',
                'embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DWWQRwui0ExPn'
            ]
        ]
    ],
    'trending' => [
        'title' => 'Trending Workout',
        'icon' => 'lni lni-graph',
        'playlists' => [
            [
                'title' => 'Workout Beats',
                'description' => 'Latest and greatest tracks for your workout',
                'embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DX3ZeFHRhhi7Y'
            ],
            [
                'title' => 'Mint',
                'description' => 'Fresh electronic dance music for your workout',
                'embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DX4dyzvuaRJ0n'
            ]
        ]
    ]
];

// Motivational videos
$videos = [
    [
        'title' => 'No Excuses',
        'description' => 'The video that will change your life',
        'embed_url' => 'https://www.youtube.com/embed/wnHW6o8WMas'
    ],
    [
        'title' => 'Push Your Limits',
        'description' => 'Break through your barriers',
        'embed_url' => 'https://www.youtube.com/embed/mgmVOuLgFB0'
    ],
    [
        'title' => 'Never Give Up',
        'description' => 'When life gets tough, you get tougher',
        'embed_url' => 'https://www.youtube.com/embed/DNITe9snHqA'
    ]
];

// Get today's quote
$dailyQuote = getDailyQuote();

// Lägg till JS-variabel för att dela spellistorna med musik.js
// Placera detta precis efter DOCTYPE-deklarationen

$playlistJson = json_encode($playlistCategories);
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
    <style>
        .quote-banner {
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .quote-banner::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 10px;
            font-size: 8rem;
            opacity: 0.2;
            font-family: Georgia, serif;
        }
        
        .quote-banner::after {
            content: '"';
            position: absolute;
            bottom: -70px;
            right: 10px;
            font-size: 8rem;
            opacity: 0.2;
            font-family: Georgia, serif;
        }
        
        .category-header {
            border-bottom: 2px solid #f8f9fa;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .category-icon {
            background: #f8f9fa;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
        }
        
        .playlist-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .playlist-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        
        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,0.8);
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .favorite-btn:hover {
            background: white;
            transform: scale(1.1);
        }
        
        .favorite-btn i {
            color: #6c757d;
            transition: color 0.2s ease;
        }
        
        .favorite-btn.active i {
            color: #dc3545;
        }
        
        .tabs-container {
            margin-bottom: 2rem;
        }
        
        .nav-tabs .nav-link.active {
            font-weight: 600;
            border-bottom: 3px solid #0d6efd;
        }
        
        .video-section {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }
        
        .favorite-section {
            display: none;
        }
        
        .favorite-section.show {
            display: block;
        }
        
        .toast-container {
            z-index: 5000;
        }
    </style>
    
    <!-- Preload och prefetch för bättre prestanda -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" as="script">
    <link rel="preload" href="js/script.js" as="script">
    <link rel="preload" href="js/music.js" as="script">
</head>

<body>
    <!-- Hidden input to store the current user ID for JavaScript -->
    <input type="hidden" id="current_user_id" value="<?php echo $_SESSION['user_id']; ?>">
    
    <div class="wrapper">

        <?php include 'sidebar.php'; ?>

        <div class="main p-3">
            <div class="content">
                <div class="container">
                    <h1 class="display-4 text-center mb-3">Workout Music & Motivation</h1>
                    
                    <!-- Quote of the Day Banner -->
                    <div class="quote-banner mb-5 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-9">
                                <h2 class="h4 mb-3">Daily Motivation</h2>
                                <p class="fs-5 mb-0 fw-light"><?php echo htmlspecialchars($dailyQuote); ?></p>
                            </div>
                            <div class="col-md-3 text-end d-none d-md-block">
                                <i class="lni lni-quotation fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabs Navigation -->
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" id="musicTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-playlists" type="button" role="tab">All Playlists</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="favorites-tab" data-bs-toggle="tab" data-bs-target="#favorites" type="button" role="tab">My Favorites</button>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Tabs Content -->
                    <div class="tab-content" id="musicTabsContent">
                        <!-- All Playlists Tab -->
                        <div class="tab-pane fade show active" id="all-playlists" role="tabpanel" aria-labelledby="all-tab">
                            <?php foreach ($playlistCategories as $category => $categoryData): ?>
                                <!-- Category Header -->
                                <div class="category-header d-flex align-items-center mb-4 mt-5">
                                    <div class="category-icon">
                                        <i class="<?php echo htmlspecialchars($categoryData['icon']); ?>"></i>
                                    </div>
                                    <h2 class="h3 mb-0"><?php echo htmlspecialchars($categoryData['title']); ?></h2>
                                </div>
                                
                                <!-- Playlists -->
                                <div class="row g-4 mb-5">
                                    <?php foreach ($categoryData['playlists'] as $index => $playlist): ?>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="card playlist-card shadow-sm position-relative">
                                                <button class="favorite-btn" 
                                                        data-category="<?php echo htmlspecialchars($category); ?>" 
                                                        data-index="<?php echo $index; ?>"
                                                        title="Add to favorites">
                                                    <i class="lni lni-heart"></i>
                                                </button>
                                                <div class="card-body">
                                                    <h5 class="card-title fw-bold mb-2"><?php echo htmlspecialchars($playlist['title']); ?></h5>
                                                    <p class="card-text text-muted mb-3"><?php echo htmlspecialchars($playlist['description']); ?></p>
                                                    <iframe src="<?php echo htmlspecialchars($playlist['embed_url']); ?>" 
                                                            width="100%" height="352" frameborder="0" 
                                                            allowtransparency="true" allow="encrypted-media" 
                                                            class="rounded"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Favorites Tab -->
                        <div class="tab-pane fade" id="favorites" role="tabpanel" aria-labelledby="favorites-tab">
                            <div class="favorite-section show mt-4">
                                <div id="no-favorites" class="text-center py-5">
                                    <i class="lni lni-heart fs-1 text-muted mb-3"></i>
                                    <h3>No Favorites Yet</h3>
                                    <p class="text-muted">Click the heart icon on any playlist to add it to your favorites</p>
                                </div>
                                <div id="favorites-container" class="row g-4">
                                    <!-- Favorites will be loaded here by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Motivational Videos Section -->
                    <div class="video-section">
                        <h2 class="display-6 text-center mb-4">Motivational Videos</h2>
                        <div class="row g-4">
                            <?php foreach ($videos as $video): ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card playlist-card shadow-sm h-100">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold mb-2"><?php echo htmlspecialchars($video['title']); ?></h5>
                                            <p class="card-text text-muted mb-3"><?php echo htmlspecialchars($video['description']); ?></p>
                                            <div class="ratio ratio-16x9">
                                                <iframe src="<?php echo htmlspecialchars($video['embed_url']); ?>" 
                                                        title="<?php echo htmlspecialchars($video['title']); ?>"
                                                        allowfullscreen class="rounded"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        // Överför PHP-datan till JavaScript
        window.playlistData = <?php echo $playlistJson; ?>;
    </script>
    <script src="js/script.js"></script>
    <script src="js/music.js"></script>
</body>

</html>