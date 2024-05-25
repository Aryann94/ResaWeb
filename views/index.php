<?php
function shortenDescription($description, $maxLength = 25) {
    if (strlen($description) > $maxLength) {
        return substr($description, 0, $maxLength) . '...';
    } else {
        return $description;
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - Swift</title>
  <link rel="stylesheet" href="public/css/styles.css">
  <script src="https://kit.fontawesome.com/98633f0b27.js" crossorigin="anonymous"></script>
  <link href="https://api.fontshare.com/v2/css?f[]=satoshi@300,400,401,500,700&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <header class="navbar">
    <nav class="nav-link">
      <a class="active" href="#">Accueil</a>
      <a href="#">Catalogue </a>
      <a href="#">À propos</a>
    </nav>

    <div class="nav-logo">
      <a href="#"><i class="fa-solid fa-bicycle" style="color: #ffffff;"></i></a>
    </div>

    <div class="nav-buttons">
      <button><i class="fa-solid fa-magnifying-glass"></i></button>
      <a href=""><i class="fa-solid fa-bag-shopping"></i></a>
    </div>
  </header>

  <main>
  <div>
    <?php
    // Controller function is probably to set up the environment or includes
    showController("CategoriesController");

    // Get filter from URL if available
    $filter = isset($_GET['search']) ? $_GET['search'] : null;

    // Instantiate the CategoriesController and get categories
    $categoriesControl = new CategoriesController();
    $allCategories = $categoriesControl->getAllCategories($filter);

    // Check if categories were found and display them
    if (count($allCategories) > 0) {
      foreach ($allCategories as $category) {
        echo "<h1>" . htmlspecialchars($category['nom_categorie']) . "</h1>";
        echo "<p>" . htmlspecialchars($category['description_categorie']) . "</p>";
        echo "<img src='public/images/" . htmlspecialchars($category['image_categorie']) . ".png' alt='Image de la catégorie'>";
      }
    } else {
      echo "<h1>Aucune catégorie trouvée</h1>";
    }
    ?>
  </div>

  <div class="product-container">
    <h2>Tous les Produits</h2>
    <?php
        showController("VelosController");

        // Get filter from URL if available
        $filter = isset($_GET['search']) ? $_GET['search'] : null;

        // Instantiate the VelosController and get velos
        $velosControl = new VelosController();
        $allVelos = $velosControl->getAllVelos($filter);

        // Check if velos were found and display them
        echo "<div class='product'>";
        if (count($allVelos) > 0) {
          foreach ($allVelos as $velo) {
            echo "<a href='velo?id_velo=" . $velo['id_velo'] . "' class='product-link'>";
              echo "<div class='product-card'>";
                if (!empty($velo['URL'])) {
                  echo "<div class='img'>";
                    echo "<img src='" . htmlspecialchars($velo['URL']) . "' alt='" . htmlspecialchars($velo['alt']) . "'>";
                  echo "</div>";
                }
                echo "<div class='product-text'>";
                  echo "<div>";
                    echo "<p>" . htmlspecialchars($velo['modele']) . "</p>";
                    echo "<p>" . htmlspecialchars($velo['prix_par_jour']) . " €</p>";
                  echo "</div>";
                  echo "<p>" . htmlspecialchars(shortenDescription($velo['description_velo'])) . "</p>";
                echo "</div>";
              echo "</div>";
            }
          } else {
            echo "<h1>Aucun vélo trouvé</h1>";
          }
          echo "</div>";
          echo "</a>";
      ?>
  </div>

  <div class="product-container">
      <h2>Meilleurs Produits</h2>
      <?php
      $bestVelos = $velosControl->getBestVelos();

      echo "<div class='product'>";
      if (count($bestVelos) > 0) {
        foreach ($bestVelos as $velo) {
            echo "<div class='product-card'>";
              if (!empty($velo['URL'])) {
                echo "<div class='img'>";
                  echo "<img src='" . htmlspecialchars($velo['URL']) . "' alt='" . htmlspecialchars($velo['alt']) . "'>";
                echo "</div>";
              }
              echo "<div class='product-text'>";
                echo "<div>";
                  echo "<p>" . htmlspecialchars($velo['modele']) . "</p>";
                  echo "<p>" . htmlspecialchars($velo['prix_par_jour']) . " €</p>";
                echo "</div>";
                echo "<p>" . htmlspecialchars(shortenDescription($velo['description_velo'])) . "</p>";
              echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<p>Aucun meilleur produit trouvé</p>";
        }
        echo "</div>";
      ?>
    </div>

    <div class="product-container">
      <h2>Nouveaux Produits</h2>
      <?php
      $newVelos = $velosControl->getNewVelos();

      echo "<div class='product'>";
      if (count($newVelos) > 0) {
        foreach ($newVelos as $velo) {
          echo "<div class='product-card'>";
          if (!empty($velo['URL'])) {
                echo "<div class='img'>";
                  echo "<img src='" . htmlspecialchars($velo['URL']) . "' alt='" . htmlspecialchars($velo['alt']) . "'>";
                echo "</div>";
              }
              echo "<div class='product-text'>";
                echo "<div>";
                  echo "<p>" . htmlspecialchars($velo['modele']) . "</p>";
                  echo "<p>" . htmlspecialchars($velo['prix_par_jour']) . " €</p>";
                echo "</div>";
                echo "<p>" . htmlspecialchars(shortenDescription($velo['description_velo'])) . "</p>";
              echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<p>Aucun nouveau produit trouvé</p>";
        }
        echo "</div>";
      ?>
    </div>
  </main>
</body>
</html>
