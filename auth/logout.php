<?php
// Starta session om inte startad
session_start();

// Töm alla sessionsvariabler
$_SESSION = array();

// Förstör sessionen
session_destroy();

// Omdirigera till startsidan
header("Location: ../index.php");
exit();
?> 