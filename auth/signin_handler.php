 <?php
// Aktivera felsökning
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Starta session om inte startad
session_start();

// Kontrollera om katalogen finns
if (!file_exists('../config/db_connect.php')) {
    $_SESSION['error'] = "Konfigurationsfilen hittades inte";
    header("Location: signin.php");
    exit();
}

// Inkludera databasanslutningen
require_once '../config/db_connect.php';

// Kontrollera anslutningen
if (!isset($conn) || $conn === null) {
    $_SESSION['error'] = "Kunde inte ansluta till databasen";
    header("Location: signin.php");
    exit();
}

// Kontrollera om formuläret är skickat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Hämta och validera indata
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['password'];
    
    // Validera obligatoriska fält
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Både användarnamn och lösenord krävs";
        header("Location: signin.php");
        exit();
    }
    
    try {
        // Kontrollera om tabellen finns
        $checkTable = $conn->query("SHOW TABLES LIKE 'users'");
        if ($checkTable->rowCount() == 0) {
            $_SESSION['error'] = "Databasen är inte korrekt konfigurerad. Användartabellen saknas.";
            header("Location: signin.php");
            exit();
        }
        
        // Hämta användare från databasen
        $stmt = $conn->prepare("SELECT user_id, username, password, firstname FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        // Om användaren finns
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verifiera lösenordet
            if (password_verify($password, $user['password'])) {
                
                // Sätt användarinformation i sessionen
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['firstname'] = $user['firstname'];
                
                // Omdirigera till startsidan
                header("Location: ../index.php");
                exit();
            } else {
                $_SESSION['error'] = "Felaktigt lösenord";
                header("Location: signin.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Användaren finns inte";
            header("Location: signin.php");
            exit();
        }
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Inloggningsfel: " . $e->getMessage();
        header("Location: signin.php");
        exit();
    }
}
else {
    // Om användaren försöker öppna denna fil direkt utan att skicka ett formulär
    header("Location: signin.php");
    exit();
}
?> 