<?php
include('header.php');
?>
<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">LePistachier.com</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="login.php">Se connecter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="basket.php">Panier
              <img src="images/basket.png" alt="basket" width ="10%">
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">
        <h1 class="my-4">Venez Pistachoter</h1>
        <div class="list-group">
          <?php
          // Variable de connexion à la base de donnée
          $host_name = "localhost";
          $database = "dii5_bd_pistachier";
          $user_name = "user";
          $password = "user";
          $port = "3308";
          $category_choix = "";

          // Connection à la base de donnée
          $connect = mysqli_connect($host_name, $user_name, $password, $database,$port);

          // Lecture Base de donnée
          $res = mysqli_query($connect,"SELECT name FROM category ORDER BY categoryID ASC") or die (mysqli_error($connect));

          // Lecture de chaque ligne dans la base de donnée
          while ($row = mysqli_fetch_array($res)) {
            $name = $row["name"];
            echo "<a href=\"index.php?name='".$name."'\" class=\"list-group-item\">".$name."</a>";
            //echo "<option value=".$row["name"].">".$row["name"]."</option>";
          }

          $adresse = $_SERVER['PHP_SELF'];
          $i = 0;
          foreach($_GET as $cle => $valeur){
            $adresse .= ($i == 0 ? '?' : '&').$cle.($valeur ? '='.$valeur : '');
            $i++;
          }
          if($adresse != "/git_pistachier/index.php"){

            // Lecture Base de donnée
            $res_choix = mysqli_query($connect,"SELECT categoryID from category where name LIKE ".$_GET['name']) or die (mysqli_error($connect));
            $res_choix->data_seek(0);
            $row = $res_choix->fetch_assoc();
            $category_choix = $row["categoryID"];
          }
          if($category_choix ==""){
            //ALL
            $category_choix = 4;
          }
          ?>
        </div>
      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">
        <br />
        <br />
        <div class="row">
          <?php
          if($category_choix != 4){
            // Lecture Base de donnée
            $res = mysqli_query($connect,"SELECT productID,name,picture,qty_available,price,description from products where categoryID=".$category_choix."") or die (mysqli_error($connect));
          }else{
            $res = mysqli_query($connect,"SELECT productID,name,picture,qty_available,price,description from products") or die (mysqli_error($connect));
          }
          // Lecture de chaque ligne dans la base de donnée
          while ($row = mysqli_fetch_array($res)) {
            $name_product = $row["name"];
            $price = $row["price"];
            $picture = $row["picture"];
            $qty_available = $row["qty_available"];
            $productID = $row["productID"];
            $description =  $row["description"];

            //echo  "<option value ="."$serialNumber".">"."$serialNumber"."</option>";
            file_put_contents($productID.".jpg",$picture);

            echo "
            <div class=\"col-lg-4 col-md-6 mb-4\">
            <div class=\"card h-100\">
            <img class=\"card-img-top\"  src='".$productID.".jpg'>
            <div class=\"card-body\">
            <h4 class=\"card-title\">
            <a href=\"#\">".$name_product."</a>
            </h4>
            <h5>".$price." € </h5>
            <p class=\"card-text\">
            ".$description."
            <br />
            <br />
            Il ne reste plus que ".$qty_available." produits disponible
            </p>
            </div>
            <div class=\"card-footer\">
            <small class=\"text-muted\">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            <button type=\"button\" name=\"go\" OnClick=\"javascript:window.location.reload()\" value=".$productID." class=\"btn btn-success offset-3\"> Ajouter</button>
            </div>
            </div>
            </div>
            ";
          }

  //        if(isset($_POST['go'])){
          //  $productIDSelected = $_POST['go'];
            $res1 = $connect->query("INSERT INTO Basket (productID) VALUES (1)");
            //echo "INSERT INTO Basket (productID) VALUES ($productIDSelected)";
//          }


          ?>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.col-lg-9 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->

  <br />
  <br />
  <?php
  include('footer.php');

  // Fermeture de la connection mysql
  mysqli_close($connect);
  ?>

</body>



</html>
