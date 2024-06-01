<?php
$current_page = 'catalogue';
$title_page = 'Catalogue';

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
require_once '../controllers/CategoriesController.php';

$filter = isset($_GET['search']) ? $_GET['search'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : null;
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : null;

$categoriesControl = new CategoriesController();
$allCategories = $categoriesControl->getAllCategories($filter);
?>

<div class="product-container">
    <form class="search-form" method="GET" action="catalogue">
        <div class="search-bar">
            <input type="text" name="search" placeholder="Rechercher par nom de vélo" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="search" type="submit"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i></button>
        </div>
        <div class="filter-sort-button">
            <button id="filter-sort-btn" type="button">
                <span>Filtrer & Trier</span>
                <i class="fa-solid fa-sliders" style="color: #ffffff;"></i>
            </button>
            <div id="dropdown-content" class="dropdown-content">
            <select id="categorie-select">
              <option value="all">Toutes les catégories</option>
              <?php
              foreach ($allCategories as $category) {
                echo "<option value='" . htmlspecialchars($category['id_categorie']) . "'>" . htmlspecialchars($category['nom_categorie']) . "</option>";
              }
              ?>
            </select>
                <select id="sort-select" name="sort">
                    <option value="">Trier par prix</option>
                    <option value="asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'selected' : ''; ?>>Prix croissant</option>
                    <option value="desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? 'selected' : ''; ?>>Prix décroissant</option>
                </select>
                
                <button class="apply" type="submit">Appliquer</button>
            </div>
        </div>
    </form>
    <?php

    // Instantiate the VelosController and get velos
    $velosControl = new VelosController($filter, $sort, $categorie);
    $allVelos = $velosControl->getAllVelos();

    // Check if velos were found and display them
    echo "<div id='velo-list' class='product'>";
    if (count($allVelos) > 0) {
        foreach ($allVelos as $velo) {
            echo "<a href='velo?id_velo=" . $velo['id_velo'] . "' class='product-link'>";
            echo "<div class='product-card' data-price='" . htmlspecialchars($velo['prix_par_jour']) . "' data-category='" . htmlspecialchars($velo['id_categorie']) . "'>";
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
            echo "</a>";
        }
    } else {
        echo "<h1>Aucun vélo trouvé</h1>";
    }
    echo "</div>";
    ?>
</div>

</body>
</html>