<?php
// Variable de connexion à la base de données
$host_name = "localhost";
$database = "dii5_bd_pistachier";
$user_name = "user";
$password = "user";
// Port MariaDB
$port = "3308";

// Connection à la base de données
$connect = mysqli_connect($host_name, $user_name, $password, $database, $port);

/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    printf("Echec de la connexion : %s\n", mysqli_connect_error());
    exit();
}

?>
