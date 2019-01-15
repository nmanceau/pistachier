<?php
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
            include('includes/connexion_bd.php');
            // Démarrage de la session
            session_start();

            if(isset($_POST['submit']) && $_POST['submit']=='Login'){
              // Test si les champs login et password sont mises à 1
              if(isset($_POST["login"]) && isset($_POST["password"])){
                // Initialisation des variables
                $username = $_POST["login"];
                $password = $_POST["password"];

                // Lecture Base de donnée
                $res_exist = $connect->query("SELECT EXISTS (SELECT * from users WHERE (email = '$username' and password = '$password')) AS user_exists");
                $row_exist = mysqli_fetch_array($res_exist);

                if ($row_exist['user_exists'] == 1) {
                  // Lecture Base de donnée
                  $res_user = $connect->query("SELECT surname, name from users WHERE (email = '$username' and password = '$password')");
                  $row_user = mysqli_fetch_array($res_user);

                  $_SESSION['surname'] = $row_user['surname'];
                  $_SESSION['name'] = $row_user['name'];
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
