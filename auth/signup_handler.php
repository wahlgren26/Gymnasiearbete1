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
    header("Location: signup.php");
    exit();
}

// Inkludera databasanslutningen
require_once '../config/db_connect.php';

// Kontrollera anslutningen
if (!isset($conn) || $conn === null) {
    $_SESSION['error'] = "Kunde inte ansluta till databasen";
    header("Location: signup.php");
    exit();
}

// Kontrollera om formuläret är skickat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Hämta och validera indata
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validera obligatoriska fält
    if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Alla fält måste fyllas i";
        header("Location: signup.php");
        exit();
    }
    
    // Validera e-post
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Ogiltig e-postadress";
        header("Location: signup.php");
        exit();
    }
    
    // Kontrollera om lösenorden matchar
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Lösenorden matchar inte";
        header("Location: signup.php");
        exit();
    }
    
    // Kontrollera lösenordsstyrka
    if (strlen($password) < 8) {
        $_SESSION['error'] = "Lösenordet måste vara minst 8 tecken";
        header("Location: signup.php");
        exit();
    }
    
    try {
        // Kontrollera om tabellen finns
        $checkTable = $conn->query("SHOW TABLES LIKE 'users'");
        if ($checkTable->rowCount() == 0) {
            $_SESSION['error'] = "Databasen är inte korrekt konfigurerad. Användartabellen saknas.";
            header("Location: signup.php");
            exit();
        }
        
        // Kontrollera om användarnamnet redan finns
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Användarnamnet är redan taget";
            header("Location: signup.php");
            exit();
        }
        
        // Kontrollera om e-postadressen redan finns
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "E-postadressen används redan";
            header("Location: signup.php");
            exit();
        }
        
        // Hascha lösenordet
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Lägg till användaren i databasen
        $stmt = $conn->prepare("INSERT INTO users (username, password, firstname, lastname, email) 
                               VALUES (?, ?, ?, ?, ?)");
        
        $stmt->execute([$username, $hashedPassword, $firstname, $lastname, $email]);
        
        // Sätt användarinformation i sessionen
        $_SESSION['user_id'] = $conn->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['firstname'] = $firstname;
        
        // Omdirigera till startsidan
        header("Location: ../index.php");
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Registreringsfel: " . $e->getMessage();
        header("Location: signup.php");
        exit();
    }
}
else {
    // Om användaren försöker öppna denna fil direkt utan att skicka ett formulär
    header("Location: signup.php");
    exit();
}
?> 