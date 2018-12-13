<!DOCTYPE html>
<html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Basket Page">
    <meta name="author" content="YPE">

    <title>Votre Panier - Le Pistachier.com</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog-post.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Le Pistachier.com</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive"
            aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-8">

          <!-- Title -->
          <h1 class="mt-4">Votre Panier</h1>

          <!-- Subtitle -->
          <p class="lead">Merci pour votre commande !</p>

          <!-- Product Card -->
          <div class="card my-4">
            <h5 class="card-header">Nespresso - Machine à café</h5>
            <div class="card-body">
              <img class="d-flsex mr-3 rounded"
                src="./images/nespresso.png" alt="">
              Machine à café Nespresso Vendue sans capsules
            </div>
          </div>

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

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
