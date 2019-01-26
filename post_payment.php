<?php
// Démarrage de la session
session_start();
$_SESSION['IsBasket'] = 0;
include('includes/connexion_bd.php');
include('includes/header.php');

$user_id = $_SESSION['userID'];

$customer_name = $_SESSION['name'] . " " . $_SESSION['surname'];

?>
<!-- Page Content -->
<div class="container">

  <div class="row">

    <!-- Post Content Column -->
    <div class="col-lg-8">

      <!-- Title -->
      <h1 class="mt-4">Merci <?php echo $customer_name; ?> votre commande a été validée !</h1>


      <div class="card my-4">
        <h5 class="card-header">
          Redirection en cours ...
        </h5>
        <div class="card-body">
          Vous allez être redirigé vers l'accueil ...
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->

<?php
include('includes/footer.php');
header("refresh:4;url=index.php");
?>
