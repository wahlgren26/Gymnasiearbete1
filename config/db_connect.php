<?php
// Aktivera felsökning
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Skapa anslutningen till databasen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gymlog";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Sätt PDO felläge till Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8mb4");
    
    // Kontrollera om users-tabellen finns
    $tableCheck = $conn->query("SHOW TABLES LIKE 'users'");
    if ($tableCheck->rowCount() == 0) {
        // Läs in database.sql-filen om den finns
        if (file_exists(__DIR__ . '/database.sql')) {
            $sql = file_get_contents(__DIR__ . '/database.sql');
            $conn->exec($sql);
        }
    }
    
} catch(PDOException $e) {
    // I en produktionsmiljö bör man inte visa detaljerade felmeddelanden, men för felsökning är det användbart
    if (isset($_SESSION)) {
        $_SESSION['error'] = "Databasfel: " . $e->getMessage();
    } else {
        echo "Anslutning misslyckades: " . $e->getMessage();
    }
    die();
}
?> 