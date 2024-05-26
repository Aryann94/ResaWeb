<?php
$current_page = 'index';

include 'header.php';


function shortenDescription($description, $maxLength = 25) {
    if (strlen($description) > $maxLength) {
        return substr($description, 0, $maxLength) . '...';
    } else {
        return $description;
    }
}

// Disable caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>

<?php
        showController("VelosController");

        // Get filter from URL if available
        $filter = isset($_GET['search']) ? $_GET['search'] : null;

        // Instantiate the VelosController and get velos
        $velosControl = new VelosController();
        $allVelos = $velosControl->getAllVelos($filter);
?>

  <main>

  <div class="product-container">
      <h2>Meilleurs Produits</h2>
      <?php
      $bestVelos = $velosControl->getBestVelos();

      echo "<div class='product'>";
      if (count($bestVelos) > 0) {
        foreach ($bestVelos as $velo) {
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
                  echo "<p>" . htmlspecialchars($velo['prix_par_jour']) . "€ / J</p>";
                echo "</div>";
                echo "<p>" . htmlspecialchars(shortenDescription($velo['description_velo'])) . "</p>";
              echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<p>Aucun meilleur produit trouvé</p>";
        }
        echo "</div>";
        echo "</a>";
      ?>
    </div>

    <div class="product-container">
      <h2>Nouveaux Produits</h2>
      <?php
      $newVelos = $velosControl->getNewVelos();

      echo "<div class='product'>";
      if (count($newVelos) > 0) {
        foreach ($newVelos as $velo) {
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
                  echo "<p>" . htmlspecialchars($velo['prix_par_jour']) . "€ / J</p>";
                echo "</div>";
                echo "<p>" . htmlspecialchars(shortenDescription($velo['description_velo'])) . "</p>";
              echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<p>Aucun nouveau produit trouvé</p>";
        }
        echo "</div>";
        echo "</a>";
      ?>
    </div>

    <div class="">
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
  
  </main>
  <script>
        // Fonction pour trier les vélos en JavaScript
        function sortVelos(order) {
            const veloList = document.getElementById('velo-list');
            const velos = Array.from(veloList.getElementsByClassName('product-card'));

            velos.sort((a, b) => {
                const priceA = parseFloat(a.getAttribute('data-price'));
                const priceB = parseFloat(b.getAttribute('data-price'));

                if (order === 'asc') {
                    return priceA - priceB;
                } else {
                    return priceB - priceA;
                }
            });

            velos.forEach(velo => veloList.appendChild(velo));
        }
    </script>
</body>
</html>
