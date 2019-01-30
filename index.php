<?php
// Démarrage de la session
session_start();
$_SESSION['IsBasket'] = 0;
// Inclusion du fichier d'ouverte de connexion à la base de données
include('includes/connexion_bd.php');
// Inclusion du fichier d'en tête
include('includes/header.php');
include('includes/securite.php');
?>
<!-- Page Content -->
<div class="container">
  <!-- row -->
  <div class="row">
    <!-- col-lg-3 -->
    <div class="col-lg-3">
      <h1 class="my-4 text-center">Venez Pistachoter</h1>
      <div class="list-group">
        <?php
        // Requête SQL pour récupérer le nom des catégories
        $result = mysqli_query($connect,"SELECT name FROM category ORDER BY categoryID ASC") or die (mysqli_error($connect));

        // Lecture de chaque ligne dans la base de données
        while ($row = mysqli_fetch_array($result)) {
          $name = $row["name"];

          echo '<a href="index.php?name=' . $name . '" class="list-group-item">' . $name . '</a>';
        }
        // Libération des ressources associées au jeu de résultats
        mysqli_free_result($result);

        // Cas du premier lancement de la page, pré selection de la catégorie à ALL
        if (empty($_GET)) {
          header('Location: index.php?name=ALL');
        }

        // Récupération de l'ID de la catégorie sélectioné
        $result = mysqli_query($connect,'SELECT categoryID from category where name LIKE "' . Securite::bdd($connect, $_GET['name']) . '"') or die (mysqli_error($connect));
        $row = mysqli_fetch_array($result);
        $category_choix = $row["categoryID"];
        ?>
      </div>
    </div>
    <!-- /.col-lg-3 -->

    <!-- col-lg-9 -->
    <div class="col-lg-9">
      <br />
      <br />
      <!-- row -->
      <div class="row">
        <?php
        // Récupération dans des variables les variables de session
        $surname = $_SESSION['surname'];
        $name = $_SESSION['name'];

        // Test si la catégorie choisie n'est pas ALL
        if($category_choix != 4){
          // Récupération les informations des produits contenu dans la catégorie choisie
          $result = mysqli_query($connect,"SELECT productID,name,picture,qty_available,price,description from products where categoryID=".$category_choix."") or die (mysqli_error($connect));
        }else{
          // Récupération les informations des produits contenu dans toutes les catégories
          $result = mysqli_query($connect,"SELECT productID,name,picture,qty_available,price,description from products") or die (mysqli_error($connect));
        }
        // Lecture de chaque ligne dans la base de données
        while ($row = mysqli_fetch_array($result)) {
          $name_product = $row["name"];
          $price = $row["price"];
          $picture = $row["picture"];
          $qty_available = $row["qty_available"];
          $productID = $row["productID"];
          $description =  $row["description"];

          // Ecriture de données dans un fichier
          file_put_contents("image_bd/".$productID.".jpg",$picture);

          // Affichage de la fiche produit
          echo "
          <div class=\"col-lg-4 col-md-6 mb-4\">
          <div class=\"card h-100\">
          <img class=\"card-img-top\" src='image_bd/".$productID.".jpg'>
          <div class=\"card-body\">
          <h4 class=\"card-title\">
          <a href=\"#\">".$name_product."</a>
          </h4>
          <h5>".$price." € </h5>
          <p class=\"card-text\">".$description."
          <br />
          <br />
          ";
          if($qty_available != 0){
            echo "Il ne reste plus que ".$qty_available." produits disponible";
          }else{
            echo "Cet article n'est plus disponible";
          }
          echo"
          </p>
          </div>
          <div class=\"card-footer\">
          <form method=\"POST\" action=\"index.php?name=ALL\">
          <small class=\"text-muted\">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
          ";
          // Test si un utilisateur est loggé et que la quantité est différente de 0 pour afficher ou non le bouton d'ajout au panier
          if($name != "" && $surname != "" && $qty_available != 0 ){
            echo "<button type=\"submit\" name=\"ajouter\" value=".$productID." class=\"btn btn-success offset-3\"> Ajouter</button>";
          }
          echo "</form>
          </div>
          </div>
          </div>
          ";
        }
        // Libération des ressources associées au jeu de résultats
        mysqli_free_result($result);

        // Test si un utilisateur est loggé et Test l'appui sur le bouton d'ajout au panier
        if($name != "" && $surname != "" && isset($_POST['ajouter']) && $_POST['ajouter'] != "") {
          // Récupération de l'ID du produit
          $pID = $_POST['ajouter'];
          // Récupération de l'ID de l'utilisateur
          $result = mysqli_query($connect,"SELECT userID FROM users WHERE name = '".$name."' AND surname = '".$surname."'") or die (mysqli_error($connect));
          $row = mysqli_fetch_array($result);
          $uID = $row['userID'];

          // Libération des ressources associées au jeu de résultats
          mysqli_free_result($result);

          $result = mysqli_query($connect,"SELECT productID FROM basket WHERE productID = $pID AND userID = $uID");

          $row = mysqli_fetch_array($result);
          if($row['productID'] == ""){
            $stmt = $connect->query("INSERT INTO basket (userID, productID, quantity) VALUES ($uID,$pID,1)");
          }else{
            echo "<script>alert(\"Le produit existe déjà dans le panier\")</script>";
          }
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
// Fermeture de la connection mysql
mysqli_close($connect);
// Inclusion du fichier de bas de page
include('includes/footer.php');
?>
