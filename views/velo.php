<?php

// Disable caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Inclure le fichier VelosController.php
require_once '../controllers/VelosController.php';

function shortenDescription($description, $maxLength = 25) {
    if (strlen($description) > $maxLength) {
        return substr($description, 0, $maxLength) . '...';
    } else {
        return $description;
    }
}

// Instancier le contrôleur des vélos
$velosControl = new VelosController();

// Récupérer l'ID du vélo depuis l'URL
$id_velo = isset($_GET['id_velo']) ? $_GET['id_velo'] : null;
// Récupérer les détails du vélo
$veloDetails = $velosControl->getVeloDetails($id_velo);
$allVelos = $velosControl->getAllVelos();


$current_page = 'velo';
$title_page = $veloDetails['modele'];
include 'header.php';

echo "<main>";
echo "<section class='velo'>";
    echo "<div class='other'>";
    echo "<div class='navigation'>";
    echo "<span><a href='./catalogue'>Catalogue</a></span>";
    echo "<span> &gt; </span>";
    echo "<span>" . htmlspecialchars($veloDetails['modele']) . "</span>";
    echo "</div>";
    
    // Affichage des étiquettes pour les nouveaux produits et les meilleurs produits
    if ($veloDetails['nouveau_produit'] == 1) {
        echo "<p class='new'>Nouveau vélo</p>";
    }

    if ($veloDetails['meilleur_produit'] == 1) {
        echo "<p class='best'>Un des meilleurs</p>";
    }
    echo "</div>";

        echo "<div class='velo-details'>";
        if (!empty($veloDetails['URL'])) {
            echo "<div class='img-container'>";
            echo "<img src='" . htmlspecialchars($veloDetails['URL']) . "' alt='" . htmlspecialchars($veloDetails['alt']) . "'>";
            echo "</div>";
        }

        echo "<div class='content'>";
        echo "<h1>" . htmlspecialchars($veloDetails['modele']) . "</h1>";
        echo "<p>" . htmlspecialchars($veloDetails['prix_par_jour']) . " € par jour</p>";
        echo "<p>" . htmlspecialchars($veloDetails['description_velo']) . "</p>";
        echo "<h2>Caractéristiques</h2>";
        echo "<p class='flex-container'><span class='label'>Taille</span><span class='value'>" . htmlspecialchars($veloDetails['taille']) . " cm</span></p>";
        echo "<p class='flex-container'><span class='label'>Catégorie</span><span class='value'>" . htmlspecialchars($veloDetails['nom_categorie']) . "</span></p>";
        echo "<p class='flex-container last'><span class='label'>Nombre de vitesses</span><span class='value'>" . htmlspecialchars($veloDetails['nbr_vitesse']) . "</span></p>";


        echo "<form class='form-container' action='' method='POST'>";
        echo "<ul class='info-list'>";
        echo "<li><i class='fas fa-info-circle'></i> Les réservations sont disponibles de 8h à 17h tous les jours.</li>";
        echo "</ul>";
            echo "<div class='form-row'>";
                echo "<div class='form-date'>";
                    echo "<label for='start_date'>Date de début</label>";
                    echo "<input type='date' id='start_date' name='start_date' >";
                echo "</div>";
                echo "<div class='form-date'>";
                    echo "<label for='start_time'>Heure de début</label>";
                    echo "<input type='time' id='start_time' name='start_time' >";
                echo "</div>";
            echo "</div>";

            echo "<div class='form-row'>";
                echo "<div class='form-date'>";
                    echo "<label for='end_date'>Date de fin</label>";
                    echo "<input type='date' id='end_date' name='end_date' >";
                echo "</div>";
                echo "<div class='form-date'>";
                    echo "<label for='end_time'>Heure de fin</label>";
                    echo "<input type='time' id='end_time' name='end_time' >";
                echo "</div>";
            echo "</div>";

            // Boutons de vérification de disponibilité et d'ajout au panier
            echo "<button id='checkAvailabilityButton' title='bouton Vérifier la disponibilité'>Vérifier la disponibilité</button>";
            echo "<button id='addToBucketButton' title='bouton Ajouter au panier' data-id='" . htmlspecialchars($id_velo) . "' disabled class='tooltip'>Ajouter au Panier<span class='tooltiptext'>Veuillez vérifier la disponibilité avant d'ajouter au panier</span></button>";
        echo "</form>";

        echo "</div>";
    echo "</div>"; 
echo "</section>"; 
?>

<script>
    var veloDetailsBis = <?php echo json_encode($veloDetails); ?>;
</script>
<section class="cards-container">
    <div class="card">
        <div class="card-icon">
            <i class="fa-solid fa-location-dot" style="color: #000; font-size: 80px;"></i>
        </div>
        <div class="card-content">
            <h2>100 points de location</h2>
            <p>Découvrez notre réseau de location de vélos avec plus de 100 points stratégiquement répartis pour votre commodité.</p>
        </div>
    </div>
    <div class="card c2">
        <div class="card-icon">
        <i class="fa-solid fa-truck" style="color: #000000; font-size: 80px;"></i>
        </div>
        <div class="card-content">
            <h2>Livraison de vos vélos</h2>
            <p>Profitez de notre service de livraison pratique qui vous apporte les vélos directement à votre porte, sans tracas ni soucis.</p>
        </div>
    </div>
    <div class="card c3">
        <div class="card-icon">
        <i class="fa-solid fa-rotate-left" style="color: #000; font-size: 80px;"></i>
        </div>
        <div class="card-content">
            <h2>Annulation gratuite</h2>
            <p>Avec notre politique d'annulation flexible, vous pouvez réserver en toute confiance, sachant que vous pouvez modifier ou annuler votre réservation sans frais.</p>
        </div>
    </div>
    </div>
</section>

<section class="main-product">
  <div class="link-container">
    <div class="btn-container">
      <button onclick="showNewProducts()" id="newButton" class="tab-button active" title="bouton nouveaux vélos">Nouveautés</button>
      <button onclick="showBestProducts()" id="bestButton" class="tab-button" title="bouton les meilleurs vélos">Les meilleurs</button>
    </div>
    <a href="./catalogue">Voir tout&nbsp;&#8250;</a>
  </div>
  <button id="prev-slide" class="slide-btn" title="bouton précédent slider">
    <img src="public/images/slide-btn.svg" alt="bouton flèche gauche">
    <span class="sr-only">Bouton précédent</span>
  </button>
  <div class="product-container">
    <div id="best-products" class="product">
      <?php
      $bestVelos = $velosControl->getBestVelos();

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
          echo "</a>";
        }
      } else {
        echo "<p>Aucun meilleur produit trouvé</p>";
      }
      ?>
    </div>
  </div>

  <div class="product-container">
    <div id="new-products" class="product" style="display: none;">
      <?php
      $newVelos = $velosControl->getNewVelos();

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
          echo "</a>";
        }
      } else {
        echo "<p>Aucun nouveau produit trouvé</p>";
      }
      ?>
    </div>
  </div>
  <button id="next-slide" class="slide-btn" title="bouton suivant slider">
    <img src="public/images/slide-btn.svg" alt="bouton flèche droite">
    <span class="sr-only">Bouton Suivant</span>
  </button>
</section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>