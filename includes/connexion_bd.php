<?php
// Variable de connexion à la base de donnée
$host_name = "localhost";
$database = "dii5_bd_pistachier";
$user_name = "user";
$password = "user";
$port = "3306";

// Connection à la base de donnée
$connect = mysqli_connect($host_name, $user_name, $password, $database, $port);

if ($connect->connect_error)
{
  die("Connection failed: " . $connect->error);
}
?>
