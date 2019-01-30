<?php
// Démarrage de la session
session_start();
$_SESSION['IsBasket'] = 0;
// Inclusion de la classe sécurité
include('includes/securite.php');
// Inclusion du fichier de connexion à la base de données
include('includes/connexion_bd.php');
// Incluse du fichier d'en tête
include('includes/header.php');
?>
<body class="image_background">
  <div class="container-fluid" >
    <div class="row " >
      <div class="col-sm-4">
      </div>
      <div class="col-sm-4">
        <div class="login-form main_div">
          <div class="panel">
            <h2>Connectez vous à votre espace membre </h2>
            <br/>
          </div>
          <form id="Login" method="post" action="login.php">
            <div class="form-group">
              <input type="text" name="login" class="form-control" id="inputEmail" placeholder="Username">
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" autocomplete="off">
            </div>
            <?php

            // Test l'appui sur le bouton submit et test si les champs login et password sont mises à 1
            if(isset($_POST['submit']) && $_POST['submit']=='Login' && isset($_POST["login"]) && isset($_POST["password"])){
              // Initialisation des variables
              $username = Securite::bdd($connect, $_POST["login"]);
              $password = Securite::bdd($connect, $_POST["password"]);

              // Utilisation de l'algorithme bcrypt par défault
              $password_hash = password_hash(trim($password), PASSWORD_DEFAULT);
              // Utilisation de l'affichage du password haché pour entrer en dur le mot de passe hashé en base de données
              //echo $password_hash;

              // Test si l'utilisateur existe déjà dans la base de données
              if($stmt = mysqli_prepare($connect, "SELECT email, surname, name, userID, password from users WHERE email = ?")){
                // Lecture des paramètres de marques et utilisation de la classe de sécurité
                mysqli_stmt_bind_param($stmt, "s", $username);

                /* Test et exécution de la requête */
                if(!mysqli_stmt_execute($stmt)){
                  printf(mysqli_connect_error());
                }
                // Récupération du password hashé et de l'email
                mysqli_stmt_bind_result($stmt,$emailBdd,$surnameBdd,$nameBdd,$userIDBdd,$passwordBdd);
                // Récupération des valeurs
                mysqli_stmt_fetch($stmt);

                // Vérification du mot de passe
                $password_verify = password_verify(trim($password),$passwordBdd);
              }else{
                printf(mysqli_connect_error());
              }

              // Test si l'email de l'utilisateur est en base de données et que son mot de passe est bon
              if ($emailBdd != "" && $password_verify) {
                // Récupération dans des variables sessions du nom, prénom et userID pour la personne connectée
                $_SESSION['surname'] = $surnameBdd;
                $_SESSION['name'] = $nameBdd;
                $_SESSION['userID'] = $userIDBdd;
                header('Location: index.php?name=ALL');

                mysqli_stmt_close($stmt);
              }else {
                // Réinitialisation des variables de sessions
                $_SESSION['surname'] = "";
                $_SESSION['name'] = "";
                $_SESSION['userID'] = "";
                // Affichage d'un message d'erreur si l'identiant et/ ou mot de passe est faux
                echo "<h4> Votre identifiant et/ou mot de passe est erronées </h4>";
              }
            }
            // Fermeture de la connection mysql
            mysqli_close($connect);
            ?>
            <button type="submit" name="submit" class="btn btn-success" value="Login">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
  include('includes/footer.php');
  ?>
