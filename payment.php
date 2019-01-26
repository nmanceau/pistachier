<?php
// Démarrage de la session
session_start();
$_SESSION['IsBasket'] = 0;
include('includes/connexion_bd.php');
$user_id = $_SESSION['userID'];

// GESTION CARTE BANCAIRE
require_once("payment-api/Twocheckout.php");

Twocheckout::privateKey('2118FCF8-BEC2-4CEC-84FC-D533F02C6CFD');
Twocheckout::sellerId('901402149');
Twocheckout::sandbox(true);


try {
    $charge = Twocheckout_Charge::auth(array(
        "merchantOrderId" => "PISTACHIER",
        "token"      => $_POST['token'],
        "currency"   => 'EUR',
        "total"      => $_POST['total'],
        "billingAddr" => array(
            "name" => $_POST['customer_name'],
            "addrLine1" => '64 avenue Jean Portalis',
            "city" => 'Tours',
            "state" => 'Indre-et-Loire',
            "zipCode" => '37200',
            "country" => 'FR',
            "email" => 'eput@univ-tours.fr',
            "phoneNumber" => '0247361414'
        )
    ));

    if ($charge['response']['responseCode'] == 'APPROVED') {


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

        header('Location: post_payment.php');
        exit();
    }
}
catch (Twocheckout_Error $e)
{
  include('includes/header.php');

  echo '
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">Désolé '. $_POST['customer_name'] . ', votre commande a échouée !</h1>


        <div class="card my-4">
          <h5 class="card-header">
            Erreur
          </h5>
          <div class="card-body"> ';
            print_r($e->getMessage());
            echo '
            Vous allez être redirigé vers l\'accueil
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
    ';

  include('includes/footer.php');
  header("refresh:4;url=index.php");
}
 ?>
