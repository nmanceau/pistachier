<?php
// Démarrage de la session
session_start();
$_SESSION['IsBasket'] = 1;
include('includes/connexion_bd.php');
include('includes/header.php');

$user_id = $_SESSION['userID'];

if (!empty($_GET["action"]))
{
  switch($_GET["action"])
  {
    case "remove":
    {
      $result = mysqli_query($connect,
        'DELETE FROM basket
         WHERE userID LIKE ' . $user_id .
         ' AND productID LIKE ' . $_GET["productID"]);

      if (!$result)
      {
        printf(mysqli_error($connect));
      }

      break;
    }

    case "empty":
    {
      $result = mysqli_query($connect,
        'DELETE FROM basket
         WHERE userID LIKE ' . $user_id
        );

      if (!$result)
      {
        printf(mysqli_error($connect));
      }

      break;
    }
  }
}
?>
<!-- Page Content -->
<div class="container">

  <div class="row">

    <!-- Post Content Column -->
    <div class="col-lg-8">

      <!-- Title -->
      <h1 class="mt-4">Votre Panier</h1>

      <?php
      $result = mysqli_query($connect, 'SELECT * FROM basket WHERE userID = ' . $user_id . ')');

      if ($result)
      {
        echo '<a id="btnEmpty" href="basket.php?action=empty">
          <button type="button" class="btn btn-outline-danger">Vider mon panier</button>
        </a>';
      }

       ?>

      <?php

      $result = mysqli_query($connect,
      'SELECT p.name AS product_name,
      p.description AS product_desc,
      p.productID AS product_ID,
      p.qty_available AS product_qty,
      p.price AS product_price
      FROM products AS p
      INNER JOIN basket AS b
      ON b.productID = p.productID
      WHERE b.userID LIKE ' . $user_id
    );

    if ($result)
    {
      while($row = mysqli_fetch_array($result))
      {
        echo '
        <!-- Product Card -->
        <div class="card my-4">
        <h5 class="card-header">
        '. $row['product_name'] . '
        <a id="btnEmpty" href="basket.php?action=remove&productID=' . $row['product_ID'] . '">
        <button type="button" class="btn btn-outline-danger btn-sm">Supprimer</button>
        </a>
        </h5>
        <div class="card-body">
        <div class="row mb-1">
        <div class="col-lg-3">
        <img class="card-img-top d-flsex rounded"
        src="./image_bd/' . $row['product_ID'] . '.jpg" alt="TEST">
        </div>
        <div class="col-sm">
        ' . $row['product_desc'] . '
        </div>
        </div>
        <div class="row">
        <div class="col-sm">
        <div class="row">
        <label for="quantity-input" class="col-6 col-form-label">Quantité</label>
        <div class="col-6">
        <input class="form-control" type="number" value="1" min="0" max="' . $row['product_qty'] . '" id="quantity-input">
        </div>
        </div>
        </div>
        <div class="col-sm">
        <span><strong>' . $row['product_qty'] . '</strong> en stock</span>
        </div>
        <div class="col-sm">
        <span>Prix unitaire : <strong>' . $row['product_price'] . ' €</strong></span>
        </div>
        </div>
        </div>
        </div>
        ';
      }
      mysqli_free_result($result);
    }
    else {
      printf(mysqli_error($connect));
    }
    ?>

    <!-- Post Content -->
    <p class="lead">Paiement</p>

    <form>
      <!-- eCheque Payment Form -->
      <div class="card my-4">
        <h5 class="card-header">
          <input class="form-check-input" type="radio" name="selectPayment"
          id="selectPayment1" value="eChequePayment" checked>
          <label class="form-check-label" for="selectPayment1">
            eChèque
          </label>
        </h5>
        <div class="card-body">
          <p>Découvrez notre système eChèque très sécurisé !</p>
          <div class="form-group">
            <p>
              Sélectionnez votre banque compatible
              <select class="form-control" id="paymentFormBankSelect">
                <option>Banque Populaire</option>
                <option>BNP Paribas</option>
                <option>Caisse d'Epargne</option>
                <option>Crédit Agricole</option>
                <option>Crédit Mutuel - CIC</option>
                <option>HSBC</option>
                <option>La Banque Postale</option>
                <option>LCL</option>
                <option>Société Générale</option>
              </select>
            </p>
            <p>
              <div class="row">
                <div class="col">
                  <input type="text" class="form-control"
                  id="paymentFormBanckAccountNumber" placeholder="Numéro de compte">
                </div>
                <div class="col">
                  <input type="text" class="form-control"
                  id="paymentFormChequeNumber" placeholder="Numéro de chèque">
                </div>
              </div>
            </p>
          </div>
        </div>
      </div>

      <!-- Debit Card Payment Form -->
      <div class="card my-4">
        <h5 class="card-header">
          <input class="form-check-input" type="radio" name="selectPayment"
          id="selectPayment2" value="debitCardPayment">
          <label class="form-check-label" for="selectPayment2">
            Carte Bancaire
          </label>
        </h5>
        <div class="card-body">
          <div class="form-group">
            <p>
              Sélectionnez votre carte
              <img src="./images/single.png" alt="payment options">
              <select class="form-control" id="debitCardTypeSelect">
                <option>Visa</option>
                <option>MasterCard</option>
                <option>CB</option>
                <option>Visa Electron</option>
                <option>American Express</option>
              </select>
            </p>
            <p>
              <div class="row">
                <div class="col">
                  <input type="text" class="form-control"
                  id="paymentFormDebitCardNumber" placeholder="Numéro de carte">
                </div>
                <div class="col">
                  <input type="text" class="form-control"
                  id="paymentFormCCVNumber" placeholder="CCV">
                </div>
              </div>
            </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-2 offset-10">
          <button type="submit" class="btn btn-primary col-12">Payer</button>
        </div>
      </div>
    </form>

    <br />

    <p class="lead">Ils ont pistachoté chez nous !</p>

    <!-- Single Comment -->
    <div class="media mb-4">
      <img class="d-flex mr-3 rounded-circle" src="./images/cathy.jpeg" alt="">
      <div class="media-body">
        <h5 class="mt-0">Cathy Soukhal</h5>
        Je vous recommande ce site ! On y trouve tout à petit prix !
      </div>
    </div>

    <!-- Comment with nested comments -->
    <div class="media mb-4">
      <img class="d-flex mr-3 rounded-circle" src="./images/jean-jacky.jpeg" alt="">
      <div class="media-body">
        <h5 class="mt-0">Jean-Jacky Chemla</h5>
        J'ai commandé une chamelle en ligne. Envoi rapide !

        <div class="media mt-4">
          <img class="d-flex mr-3 rounded-circle" src="./images/rachida.jpg" alt="">
          <div class="media-body">
            <h5 class="mt-0">Rachida Abdul</h5>
            Votre chamelle va t-elle dans les steppes arides de Tunisie ?
          </div>
        </div>

        <div class="media mt-4">
          <img class="d-flex mr-3 rounded-circle" src="./images/donald.jpg" alt="">
          <div class="media-body">
            <h5 class="mt-0">Donald Trump</h5>
            Fermez vos gueules !!!
          </div>
        </div>

      </div>
    </div>

  </div>

  <!-- Sidebar Widgets Column -->
  <div class="col-md-4">

    <!-- Search Widget -->
    <div class="card my-4">
      <h5 class="card-header">Montant de votre commande</h5>
      <div class="card-body">
        <label><strong>85,00 €</strong></label>
      </div>
    </div>

    <!-- Categories Widget -->
    <div class="card my-4">
      <h5 class="card-header">Categories</h5>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6">
            <ul class="list-unstyled mb-0">
              <li>
                <a href="#">Web Design</a>
              </li>
              <li>
                <a href="#">HTML</a>
              </li>
              <li>
                <a href="#">Freebies</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-6">
            <ul class="list-unstyled mb-0">
              <li>
                <a href="#">JavaScript</a>
              </li>
              <li>
                <a href="#">CSS</a>
              </li>
              <li>
                <a href="#">Tutorials</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Side Widget -->
    <div class="card my-4">
      <h5 class="card-header">Side Widget</h5>
      <div class="card-body">
        You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
      </div>
    </div>

  </div>

</div>
<!-- /.row -->

</div>
<!-- /.container -->

<?php
include('includes/footer.php');
?>
