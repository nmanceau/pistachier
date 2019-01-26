<?php
// Démarrage de la session
session_start();
$_SESSION['IsBasket'] = 1;
include('includes/connexion_bd.php');
include('includes/header.php');

$user_id = $_SESSION['userID'];
$customer_name = $_SESSION['surname'] . " " . $_SESSION['name'];

if (isset($_POST['quantity-input']) && isset($_POST['product-ID']))
{
  $result = mysqli_query($connect,
    'UPDATE basket
     SET quantity = ' . $_POST['quantity-input'] . '
     WHERE userID LIKE ' . $user_id .
     ' AND productID LIKE ' . $_POST['product-ID']);
}

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
      $basket_amount = 0;
      $result = mysqli_query($connect, 'SELECT * FROM basket WHERE userID = ' . $user_id);

      if (mysqli_num_rows($result) > 0)
      {
        echo '<a id="btnEmpty" href="basket.php?action=empty">
          <button type="button" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i> Vider mon panier</button>
        </a>';
        $IsPayable = true;
      }
      else
      {
        echo '<div class="alert alert-danger" role="alert">
          Votre panier est vide !
        </div>';
        $IsPayable = false;
      }

      $result = mysqli_query($connect,
      'SELECT p.name AS product_name,
      p.description AS product_desc,
      p.productID AS product_ID,
      p.qty_available AS product_qty,
      p.price AS product_price,
      b.quantity AS prod_basket_qty
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
        <button type="button" class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i> Supprimer</button>
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

        <form method="post" action="basket.php">
        <div class="row">
        <input name="quantity-input" class="col-8 form-control" type="number" value="' . $row['prod_basket_qty'] . '" min="1" max="' . $row['product_qty'] . '">
        <input name="product-ID" type="number" value="' . $row['product_ID'] . '" style="display: none;"></input>
        <button class="col-4 btn btn-success" type="submit"><i class="fas fa-sync-alt"></i></button>
        </div>
        </form>
        </div>
        </div>
        </div>
        <div class="col-sm">
        <button type="button" class="btn btn-info" disabled><i class="fas fa-info-circle"></i> <strong>' . $row['product_qty'] . '</strong> en stock</button>
        </div>
        <div class="col-sm">
        <button type="button" class="btn btn-outline-danger" disabled>Prix <strong>' . number_format(($row['prod_basket_qty'] * $row['product_price']), 2, ',', ' ') . ' €</strong></button>
        </div>
        </div>
        </div>
        </div>
        ';
        $basket_amount += ($row['prod_basket_qty'] * $row['product_price']);
      }
      mysqli_free_result($result);
    }
    else {
      printf(mysqli_error($connect));
    }
    ?>


    <?php
    if ($IsPayable !== false)
    {
    echo '
      <!-- Post Content -->
      <p class="lead">Paiement</p>

      <form id="myPaymentForm" action="payment.php" method="post">
        <!-- eCheque Payment Form -->
        <div class="card my-4">
          <h5 class="card-header">
            <input class="form-check-input" type="radio" name="selectPayment"
            id="selectPayment1" value="eChequePayment" checked>
            <label class="form-check-label" for="selectPayment1">
              <i class="fas fa-money-check"></i> eChèque
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
                  <option>Caisse d\'Epargne</option>
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
              <i class="fas fa-credit-card"></i> Carte Bancaire
            </label>
          </h5>
          <div class="card-body">
            <div class="form-group">
              <div class="row ml-2 mb-4">
                <input id="token" name="token" type="hidden" value="">
                <input id="total" name="total" type="hidden" value="' . $basket_amount . '">
                <input id="customer_name" name="customer_name" type="hidden" value="' . $customer_name . '">
                <img src="./images/single.png" alt="payment options">
              </div>
              <div class="row">
                <div class="col">
                  <input class="form-control" id="ccNo" type="text"
                  size="20" value="" autocomplete="off"
                  placeholder="Numéro de carte" required />
                </div>
                <div class="col">
                  <span>Expire le </span>
                  <input type="text" size="2" id="expMonth"
                  placeholder="MM" required />
                  <span> / </span>
                  <input type="text" size="4" id="expYear"
                  placeholder="YYYY" required />
                </div>
                <div class="col">
                  <input id="cvv" size="4" type="text" value=""
                  placeholder="CVV" autocomplete="off" required />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-2 offset-10">
            <input type="submit" class="btn btn-primary col-12" value="Payer">
          </div>
        </div>
      </form>';
    }
    ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://www.2checkout.com/checkout/api/2co.min.js"></script>

    <script>
    // Called when token created successfully.
    var successCallback = function(data) {
      var myForm = document.getElementById('myPaymentForm');

      // Set the token as the value for the token input
      myForm.token.value = data.response.token.token;

      // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
      myForm.submit();
    };

    // Called when token creation fails.
    var errorCallback = function(data) {
      if (data.errorCode === 200) {
        tokenRequest();
      } else {
        alert(data.errorMsg);
      }
    };

    var tokenRequest = function() {
      // Setup token request arguments
      var args = {
        sellerId: "901402149",
        publishableKey: "B935668B-47CD-423E-A10A-76393763E7CD",
        ccNo: $("#ccNo").val(),
        cvv: $("#cvv").val(),
        expMonth: $("#expMonth").val(),
        expYear: $("#expYear").val()
      };

      // Make the token request
      TCO.requestToken(successCallback, errorCallback, args);
    };

    $(function() {
      // Pull in the public encryption key for our environment
      TCO.loadPubKey('sandbox');

      $("#myPaymentForm").submit(function(e) {
        // Call our token request function
        tokenRequest();

        // Prevent form from submitting
        return false;
      });
    });
  </script>
    <br />

    <p class="lead">Ils ont pistachoté chez nous !</p>

    <!-- Single Comment -->
    <div class="media mb-4">
      <img class="d-flex mr-3 rounded-circle" src="./images/cathy.jpeg" alt="">
      <div class="media-body">
        <h5 class="mt-0">Cathy Dupont</h5>
        Je vous recommande ce site ! On y trouve tout à petit prix !
      </div>
    </div>

    <!-- Comment with nested comments -->
    <div class="media mb-4">
      <img class="d-flex mr-3 rounded-circle" src="./images/jean-jacky.jpeg" alt="">
      <div class="media-body">
        <h5 class="mt-0">Jean-Jacky Moreau</h5>
        J'ai commandé une chamelle en ligne. Envoi rapide !

        <div class="media mt-4">
          <img class="d-flex mr-3 rounded-circle" src="./images/rachida.jpg" alt="">
          <div class="media-body">
            <h5 class="mt-0">Rachida Dati</h5>
            Génial !
          </div>
        </div>

        <div class="media mt-4">
          <img class="d-flex mr-3 rounded-circle" src="./images/donald.jpg" alt="">
          <div class="media-body">
            <h5 class="mt-0">Donald Trump</h5>
            Hello from USA
          </div>
        </div>
      </div>
    </div>

    <br />
    <br />
    <br />
  </div>

  <!-- Sidebar Widgets Column -->
  <div class="col-md-4">

    <!-- Basket Amount-->
    <?php
    if ($IsPayable !== false)
    {
    echo '
      <div class="card my-4">
        <h5 class="card-header">Montant de votre commande</h5>
        <div class="card-body">
          <label><strong>' . number_format($basket_amount, 2, ',', ' ') . ' €</strong></label>
        </div>
      </div>';
    }
    ?>

    <!-- Side Widget -->
    <div class="card my-4">
      <h5 class="card-header">Livraison</h5>
      <div class="card-body">
        Les délais de livraison sont de 3 jours ouvrés en moyenne.
      </div>
    </div>

    <!-- Ad Widget -->
    <div class="card my-4">
      <h5 class="card-header">Publicité</h5>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <a href="https://www.citroen.fr/vehicules-neufs/citroen/citroen-c3/description.html">
              <img class="card-img-top d-flsex rounded" src="./images/pub.png" alt="Publicité">
            </a>
          </div>
        </div>
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
