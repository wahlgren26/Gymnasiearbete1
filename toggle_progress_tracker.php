<?php
// Inkludera session
include 'session_handler.php';

// Kontrollera om användaren är inloggad
if (!isset($_SESSION['user_id'])) {
    // Svara med felkod om användaren inte är inloggad
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Ej inloggad']);
    exit();
}

// Ta emot POST-data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['show'])) {
    // Spara inställningen i sessionen
    $_SESSION['show_progress_tracker'] = ($_POST['show'] === '1');
    
    // Svara med framgång
    http_response_code(200);
    echo json_encode(['success' => true]);
    exit();
} else {
    // Svara med felkod om data saknas
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Felaktig förfrågan']);
    exit();
}
?> 