<?php
$current_page = 'catalogue';

function shortenDescription($description, $maxLength = 25) {
  if (strlen($description) > $maxLength) {
      return substr($description, 0, $maxLength) . '...';
  } else {
      return $description;
  }
}

include 'header.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once '../controllers/VelosController.php';

$filter = isset($_GET['search']) ? $_GET['search'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : null;
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : null;
?>


  <div class="product-container">
      <h2>Tous les Produits</h2>
      <form method="GET" action="catalogue">
          <input type="text" name="search" placeholder="Rechercher par nom de vélo" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
          <select name="sort">
              <option value="">Trier par prix</option>
              <option value="asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'selected' : ''; ?>>Prix croissant</option>
              <option value="desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? 'selected' : ''; ?>>Prix décroissant</option>
          </select>
          <button type="submit">Rechercher</button>
      </form>
      <?php
          echo "<h2>Recherche: " . ($filter ? htmlspecialchars($filter) : "Tous les vélos") . "</h2>";

          // Instantiate the VelosController and get velos
          $velosControl = new VelosController($filter, $sort, $categorie);
          $allVelos = $velosControl->getAllVelos();

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
                      echo "<p>" . htmlspecialchars($velo['prix_par_jour']) . "€ / J</p>";
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
</body>
</html>