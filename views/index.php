<?php
$current_page = 'index';

$title_page = 'Accueil';

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

        showController("VelosController");

        // Get filter from URL if available
        $filter = isset($_GET['search']) ? $_GET['search'] : null;

        // Instantiate the VelosController and get velos
        $velosControl = new VelosController();
        $allVelos = $velosControl->getAllVelos($filter);

        
?>
<script type="module" src="https://unpkg.com/@splinetool/viewer@1.4.1/build/spline-viewer.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/split-type"></script>




  <main>
  <section class="hero">
    <spline-viewer url="https://prod.spline.design/D9km3KuSiVg5jNeH/scene.splinecode"></spline-viewer>
    <div class="hide"></div>
    <div class="cercle"></div>
    <img src="public/images/SwiftText.svg"/>
    <h1> Roulez vite, Roulez bien.</h1>
    <p>Explorez la Ville en toute Facilité avec nos Vélos Fiables et Écologiques.</p>
    <a href="">Découvrez Nos Modèles</a>
  </section>

<section class="info">
  <img src="public/images/logoBig.svg" alt="">
  <p class="reveal-type">Découvrez notre passion pour le vélo et notre engagement pour un avenir plus vert. <br>Que vous soyez passionné de VTT, de vélo de route, urbain ou à assistance électrique, Swift a ce qu'il vous faut.</p>
  <a href="/resaweb/propos" class="reveal-type">en savoir plus &nbsp;&#8250;</a>
</section>

<section class="main-product">
  <div class="link-container">
    <div class="btn-container">
      <button onclick="showNewProducts()" id="newButton" class="tab-button active">Nouveautés</button>
      <button onclick="showBestProducts()" id="bestButton" class="tab-button">Meilleurs produits</button>
    </div>
    <a href="/resaweb/catalogue"">Voir tout&nbsp;&#8250;</a>
  </div>
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
</section>


    <section class="categorie-container">
    <div id="tiles"></div>

    <?php
    showController("CategoriesController");

    $filter = isset($_GET['search']) ? $_GET['search'] : null;

    $categoriesControl = new CategoriesController();
    $allCategories = $categoriesControl->getAllCategories($filter);

    echo "<div class='categorie'>";
    if (count($allCategories) > 0) {
        foreach ($allCategories as $category) {
          echo "<a class='categorie-card' href='catalogue?categorie=" . urlencode($category['id_categorie']) . "' class='categorie-card-link'>";
            echo "<div class='categorie-text'>";
            echo "<h3>" . htmlspecialchars($category['nom_categorie']) . "</h1>";
            echo "<p>" . htmlspecialchars($category['description_categorie']) . "</p>";
            echo "</div>";
            echo "<div class='categorie-img'>";
            echo "<img src='public/images/categorie/" . htmlspecialchars($category['image_categorie']) . ".png' alt='Image de la catégorie'>";
            echo "</div>";
            echo "</a>";
          }
        } else {
          echo "<h1>Aucune catégorie trouvée</h1>";
        }
        echo "</div>";
    ?>
  </section>
  
  <div class="ecology-container">
        <div class="main-section">
            <div class="section">
                <h3>Sauver la planète</h3>
            </div>
            <div class="content">
                <svg viewBox="0 0 1440 4096" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g class="backers">
                        <path d="M-3317 96H387c276.142 0 500 223.858 500 500v1064.51c0 99.41-80.589 180-180 180H434.99c-99.412 0-180.001 80.58-180.001 180V4248" stroke="red" stroke-width="100" stroke-linecap="round"/>
                        <path d="M4379 804H1387c-276.14 0-499.997 223.86-499.997 500v356.51c0 99.41-80.589 180-180 180H434.991c-99.411 0-180 80.59-180 180V4248" stroke="red" stroke-width="100" stroke-linecap="round"/>
                        <path d="M4423 96H1387.02c-276.14 0-500.001 223.858-500.001 500.001V1660.51c0 99.41-80.589 180-180 180H434.995c-99.411 0-180 80.59-180 180l.001 2227.49" stroke="red" stroke-width="100" stroke-linecap="round"/>
                    </g>
                    <g class="fillers">
                        <path d="M-3317 96H387c276.142 0 500 223.858 500 500v1064.51c0 99.41-80.589 180-180 180H434.99c-99.412 0-180.001 80.58-180.001 180V4248" stroke="red" stroke-width="100" stroke-linecap="round"/>
                        <path d="M4379 804H1387c-276.14 0-499.997 223.86-499.997 500v356.51c0 99.41-80.589 180-180 180H434.991c-99.411 0-180 80.59-180 180V4248" stroke="red" stroke-width="100" stroke-linecap="round"/>
                        <path d="M4423 96H1387.02c-276.14 0-500.001 223.858-500.001 500.001V1660.51c0 99.41-80.589 180-180 180H434.995c-99.411 0-180 80.59-180 180l.001 2227.49" stroke="red" stroke-width="100" stroke-linecap="round"/>
                    </g>
                </svg>
                <div class="section"><span>Faire du vélo</span></div>
                <div class="section"><span>Réduire les émissions</span></div>
                <div class="section"><span>Vivre plus sainement</span></div>
                <div class="section"><span>Protéger la nature</span></div>
            </div>
        </div>
    </div>


  
  </main>
  <script src="https://cdn.jsdelivr.net/npm/animejs@3.0.1/lib/anime.min.js"></script>
</body>
</html>
