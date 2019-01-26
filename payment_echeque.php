<?php
// Démarrage de la session
session_start();
$_SESSION['IsBasket'] = 0;
include('includes/connexion_bd.php');
$user_id = $_SESSION['userID'];
$customer_name = $_SESSION['surname'] . " " . $_SESSION['name'];

// GESTION ECHEQUE
include('includes/header.php');

$result = mysqli_query($connect,
  'SELECT productID, quantity
   FROM basket
   WHERE userID = ' . $user_id
  );

if ($result)
{
  while($row = mysqli_fetch_array($result))
  {
    $updateResult = mysqli_query($connect,
      'UPDATE products
      SET qty_available = qty_available - ' . $row['quantity'] . ' WHERE productID LIKE ' . $row['productID']
      );
  }
  mysqli_free_result($result);
}
else
{
  printf(mysqli_error($connect));
}

$result = mysqli_query($connect,
  'DELETE FROM basket
   WHERE userID LIKE ' . $user_id
  );

if (!$result)
{
  printf(mysqli_error($connect));
}

echo '
<div class="container">

  <div class="row">

    <!-- Post Content Column -->
    <div class="col-lg-8">

      <!-- Title -->
      <h1 class="mt-4">Merci '. $_POST['customer_name'] . ' d\'avoir utilisé eChèque !</h1>


      <div class="card my-4">
        <h5 class="card-header">
          Contact de la banque
        </h5>
        <div class="card-body">
          Nous allons contacter votre banque pour procéder au paiement.
          Vous serez informés dès que cette dernière aura accepté la transaction.
          Dès lors, vos produits vous seront expédiés.

          Redirection en cours vers l\'accueil ...
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
  ';

include('includes/footer.php');
header("refresh:5;url=index.php");

?>
