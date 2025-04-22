<?php
// Inkludera session
include 'session_handler.php';

// Inkludera databaskoppling
require_once 'config/db_connect.php';

// Kontrollera om användaren är inloggad
if (!isset($_SESSION['user_id'])) {
    // Svara med felkod om användaren inte är inloggad
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Ej inloggad']);
    exit();
}

// Ta emot POST-data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['show'])) {
    $showProgress = ($_POST['show'] === '1');
    
    try {
        // Kontrollera om kolumnen finns i tabellen
        $stmt = $conn->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'users' AND COLUMN_NAME = 'show_progress_tracker'");
        $stmt->execute();
        
        // Om kolumnen inte finns, skapa den
        if ($stmt->rowCount() === 0) {
            $conn->exec("ALTER TABLE users ADD COLUMN show_progress_tracker BOOLEAN DEFAULT 1");
        }
        
        // Spara inställningen i databasen
        $stmt = $conn->prepare("UPDATE users SET show_progress_tracker = :show_progress WHERE user_id = :user_id");
        $stmt->bindParam(':show_progress', $showProgress, PDO::PARAM_BOOL);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        
        // Spara även i sessionen för den nuvarande sessionen
        $_SESSION['show_progress_tracker'] = $showProgress;
        
        // Svara med framgång
        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    } catch (PDOException $e) {
        // Svara med felkod om något går fel med databasen
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Databasfel: ' . $e->getMessage()]);
        exit();
    }
} else {
    // Svara med felkod om data saknas
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Felaktig förfrågan']);
    exit();
}
?> 