<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>LePistachier.com</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">
  <link href="css/2-col-portfolio.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">LePistachier.com</a>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <?php
          if(!isset($_SESSION['surname']) && !isset($_SESSION['name'])){
            $_SESSION['surname'] = "";
            $_SESSION['name'] = "";
          }

          // Gestion de la Connection
          if($_SESSION["name"] != "" && $_SESSION["surname"] != ""){
            echo "
            <li class=\"nav-link\"> Bienvenue ".$_SESSION["surname"]." ".$_SESSION["name"]."
            </li>
            <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"deconnexion.php\">Se déconnecter</a>
            </li> ";

            echo $_SERVER['PHP_SELF'];
            if ($_SERVER['PHP_SELF'] != "/git_pistachier/basket.php")
            {
              echo "<li class=\"nav-item\">
                       <a class=\"nav-link\" href=\"basket.php\">
                          <i class=\"fas fa-cart-plus\"></i> Panier
                       </a>
                    </li>";
            }
          }else{
            echo "
            <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"login.php\">Se connecter</a>
            </li>
            ";
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>
