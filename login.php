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
            <br />
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

            if(isset($_POST['submit']) AND $_POST['submit']=='Login'){
              // Test si les champs login et password sont mises à 1
              if(isset($_POST["login"]) && isset($_POST["password"])){
                // Initialisation des variables
                $username = $_POST["login"];
                $password = $_POST["password"];

                // Lecture Base de donnée
                $res = $connect->query("SELECT EXISTS (SELECT * from users WHERE (email = '$username' and password = '$password')) AS user_exists");
                $res->data_seek(0);
                $row = $res->fetch_assoc();

                if ($row['user_exists'] == true) {
                  header('Location: index.php');
                }
                else {
                  $profil_db = 0;
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
