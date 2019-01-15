<?php
// Démarrage de la session
session_start();

$_SESSION['surname'] = "";
$_SESSION['name'] = "";

// Destruction de la session
session_destroy();
header('Location: index.php');
?>
