<?php
// Démarrage de la session
session_start();
include('includes/securite.php');
include('includes/connexion_bd.php');
include('includes/header.php');
?>
<body style="background: url(images/tree.jpg) no-repeat center fixed; background-size: cover;">
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
              <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
            <?php

            // Test l'appui sur le bouton submit
            if(isset($_POST['submit']) && $_POST['submit']=='Login'){
              // Test si les champs login et password sont mises à 1
              if(isset($_POST["login"]) && isset($_POST["password"])){
                // Initialisation des variables
                $username = $_POST["login"];
                $password = $_POST["password"];

                // Utilisation de l'algorithme bcrypt par défault
                $password_hash = password_hash(trim($password), PASSWORD_DEFAULT);
                echo $password_hash;
                $password_verify = password_verify($password,$password_hash);

                // Test hachage
                if ($password_verify) {
                    echo 'Le mot de passe est valide !';
                } else {
                    echo 'Le mot de passe est invalide.';
                }


                // Test si l'utilisateur existe déjà dans la base de données
                if($res_exist = mysqli_prepare($connect, "SELECT EXISTS (SELECT * from users WHERE email = ? and password = ? ) AS user_exists")){
                  mysqli_stmt_bind_param($res_exist, "ss", Securite::bdd($connect,$username), Securite::bdd($connect,$password_hash));
-
                  if(!mysqli_stmt_execute($res_exist)){
                    printf(mysqli_connect_error());
                  }
                  mysqli_stmt_bind_result($res_exist,$row_exist);
                  mysqli_stmt_fetch($res_exist);
                }else{
                  printf(mysqli_connect_error());
                }

                if ($row_exist == 1) {
                  mysqli_stmt_close($res_exist);

                  // Récupération des informations de l'utilisateur
                  $res_user = $connect->query("SELECT surname, name, userID from users WHERE email = '$username'");
                  $row_user = mysqli_fetch_array($res_user);

                  $_SESSION['surname'] = $row_user['surname'];
                  $_SESSION['name'] = $row_user['name'];
                  $_SESSION['userID'] = $row_user['userID'];
                  header('Location: index.php');
                }
                else {
                  $_SESSION['surname'] = "";
                  $_SESSION['name'] = "";
                  echo "<h4> Votre identifiant et/ou mot de passe est erronées </h4>";
                }
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
