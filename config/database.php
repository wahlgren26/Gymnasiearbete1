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
} catch(PDOException $e) {
    echo "Anslutning misslyckades: " . $e->getMessage();
    die();
} 