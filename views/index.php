<script type="module" src="https://unpkg.com/@splinetool/viewer@1.4.1/build/spline-viewer.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/ScrollTrigger.min.js"></script>
<script src="https://unpkg.com/split-type"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>





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
  <section class="hero" style="position: relative;">
    <spline-viewer style="transform: translateY(-100px); padding-left: 100px;" url="https://prod.spline.design/D9km3KuSiVg5jNeH/scene.splinecode"></spline-viewer>
    <div style="position: absolute; top: 88%; right: 0; width: 160px; height: 100px; background-color: #242A28; z-index: 9999999;"></div>
    <div style="position: absolute; top: 40%; left: 50%;  transform: translate(-50%, -50%); width: 310px; height: 310px; background: radial-gradient(circle, #22E49F, #6DA0C1); filter: blur(250px); z-index: -3;"></div>
    <img src="public/images/SwiftText.svg" style="position: absolute; top: 40%; left: 50%;  transform: translate(-50%, -50%); z-index: -2;" />
    <h1 style="position: absolute; top: 75%; left: 50%;  transform: translate(-50%, -50%); font-size: 3.813rem;"> Roulez vite, Roulez bien.</h1>
    <p style="position: absolute; top: 82%; left: 50%;  transform: translate(-50%, -50%);">Explorez la Ville en toute Facilité avec nos Vélos Fiables et Écologiques.</p>
    <a style="position: absolute; top: 90%; left: 50%;  transform: translate(-50%, -50%);background-color: #22E49F; color: black; padding: 16px 32px; text-transform: uppercase; text-decoration: none; font-weight: 700; border-radius: 12px;" href="">Découvrez Nos Modèles</a>
  </section>

<!-- Your text element here. For example: -->
<div class="info">
  <img src="public/images/logoBig.svg" alt="">
  <p class="split-word">Découvrez notre passion pour le vélo et notre engagement pour un avenir plus vert. <br>Que vous soyez passionné de VTT, de vélo de route, urbain ou à assistance électrique, Swift a ce qu'il vous faut.</p>
  <a class="split-word" href="#">en savoir plus &nbsp;&#8250;</a>
</div>

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
            echo "<img src='public/images/" . htmlspecialchars($category['image_categorie']) . ".png' alt='Image de la catégorie'>";
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
  <script>
    const wrapper = document.getElementById("tiles");
    const categorieContainer = document.querySelector(".categorie-container");
    const tileWidth = 200;
    const tileHeight = 200;

    // Calculer le nombre de colonnes et de lignes en fonction de la taille de la .categorie-container
    let columns = Math.floor(categorieContainer.offsetWidth / tileWidth);
    let rows = Math.floor(categorieContainer.offsetHeight / tileHeight);

    const colors = [
    "hsl(159, 27%, 16%)",
    "hsl(158, 27%, 16%)",
    "hsl(159, 78%, 11%)",
    "hsl(156, 6%, 10%)"
    ];

    let count = -1;

    const handleOnClick = index => {
    count = count + 1;

    anime({
    targets: ".tile",
    backgroundColor: colors[count % (colors.length - 1)],
    delay: anime.stagger(50, {
      grid: [columns, rows],
      from: index
    })
    })
    }

    const createTile = (index) => {
    const tile = document.createElement("div");
    tile.classList.add("tile");
    tile.onclick = e => handleOnClick(index);
    return tile;
    }

    const createTiles = () => {
    for (let i = 0; i < columns * rows; i++) {
        wrapper.appendChild(createTile(i));
    }
    }

    const createGrid = () => {
    // Nettoyer le contenu existant de la grille
    wrapper.innerHTML = "";

    // Mettre à jour le nombre de colonnes et de lignes en fonction de la taille de .categorie-container
    columns = Math.floor(categorieContainer.offsetWidth / tileWidth);
    rows = Math.floor(categorieContainer.offsetHeight / tileHeight);

    // Définir les propriétés de la grille CSS personnalisées
    wrapper.style.setProperty("--columns", columns);
    wrapper.style.setProperty("--rows", rows);

    // Créer les tuiles dans la grille mise à jour
    createTiles();
    }

    // Appeler createGrid une fois pour créer la grille initiale
    createGrid();

    // Appeler createGrid à nouveau lors du redimensionnement de la fenêtre pour mettre à jour la grille en conséquence
    window.addEventListener("resize", createGrid);

    // Déclencher les clics de manière aléatoire à des intervalles réguliers
    setInterval(() => {
    const randomIndex = Math.floor(Math.random() * (columns * rows));
    handleOnClick(randomIndex);
    }, 2000); // Changement de tuile toutes les 2 secondes (2000 millisecondes)


    let typeSplit;

    // Split the text up
    function runSplit() {
    typeSplit = new SplitType(".split-word", {
      types: "words" // Split the text into words
    });
    createAnimation();
    }

    runSplit();

    // Register GSAP plugins
    gsap.registerPlugin(ScrollTrigger);

    // Create staggered animation
      function createAnimation() {
      let words = document.querySelectorAll(".word");

      let tl = gsap.timeline({
        scrollTrigger: {
          trigger: ".split-word",
          start: "top 80%",
          end: "bottom center",
          scrub: 1
        }
      });

      tl.to(words, {
        opacity: 1,
        duration: 1,
        stagger: 0.5
      });
      }



    function showBestProducts() {
        document.getElementById("best-products").style.display = "flex";
        document.getElementById("new-products").style.display = "none";
        document.getElementById("newButton").classList.remove("active");
        document.getElementById("bestButton").classList.add("active");
      }

      function showNewProducts() {
        document.getElementById("best-products").style.display = "none";
        document.getElementById("new-products").style.display = "flex";
        document.getElementById("bestButton").classList.remove("active");
        document.getElementById("newButton").classList.add("active");
      }

      showNewProducts();



      gsap.to('.content', {
        scrollTrigger: {
          trigger: '.custom-container',
          scrub: 0.5,
          start: "top 70%",
          end: "bottom top",
        },
        scale: 1
      })

  </script>
</body>
</html>
