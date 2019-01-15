<?php
// Démarrage de la session
session_start();

include('includes/header.php');
?>
<!-- Page Content -->
<div class="container">
  <div class="row">
    <div class="col-lg-3">
      <h1 class="my-4 text-center">Venez Pistachoter</h1>
      <div class="list-group">
        <?php
        include('includes/connexion_bd.php');

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
        }else{
            $category_choix = 4;
        }

        if($category_choix == ""){
          //ALL = 4
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
          <img class=\"card-img-top\" src='".$productID.".jpg'>
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
          <form method=\"POST\" action=\"index.php\">
          <button type=\"submit\" name=\"ajouter\" value=".$productID." class=\"btn btn-success offset-3\"> Ajouter</button>
          </form>
          </div>
          </div>
          </div>
          ";
        }

        // Test si un utilisateur est loggé
        if($_SESSION['name'] != "" && $_SESSION['surname'] != ""){
          // On test la déclaration de nos variables
          if (isset($_POST['ajouter']) && $_POST['ajouter'] != "") {
            // Récupération de l'ID du produit
            $pID = $_POST['ajouter'];
            // Récupération de l'ID de l'utilisateur
            $select = mysqli_query($connect,"SELECT userID FROM users WHERE name = '".$_SESSION['name']."' AND surname = '".$_SESSION['surname']."'") or die (mysqli_error($connect));
            $row = mysqli_fetch_array($select);
            $uID = $row['userID'];

            $res1 = $connect->query("INSERT INTO basket (userID, productID, quantity) VALUES ($uID,$pID,1)");
          }
        }else{
          echo "Veuillez entrer vos identifiants";
        }
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
include('includes/footer.php');

// Fermeture de la connection mysql
mysqli_close($connect);
?>
