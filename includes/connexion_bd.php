<?php
// Variable de connexion à la base de données
$host_name = "localhost";
$database = "dii5_bd_pistachier";
$user_name = "user";
$mdp = "user";
// Port MariaDB
$port = "3306";

// Connection à la base de données
$connect = mysqli_connect($host_name, $user_name, $mdp, $database, $port);

/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    printf("Echec de la connexion : %s\n", mysqli_connect_error());
    exit();
}

?>
