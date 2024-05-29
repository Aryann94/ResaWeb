<script type="module" src="https://unpkg.com/@splinetool/viewer@1.4.1/build/spline-viewer.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/ScrollTrigger.min.js"></script>
<script src="https://unpkg.com/split-type"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script></script>




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
  <section class="hero" style="position: relative; transform: translateY(-300px); padding-left: 90px;">
    <spline-viewer url="https://prod.spline.design/D9km3KuSiVg5jNeH/scene.splinecode"></spline-viewer>
    <div style="position: absolute; top: 95%; right: 0; width: 160px; height: 100px; background-color: #242A28; z-index: 9999999;"></div>
    <div style="position: absolute; top: 48%; left: 50%;  transform: translate(-50%, -50%); width: 310px; height: 310px; background: radial-gradient(circle, #22E49F, #6DA0C1); filter: blur(250px); z-index: -3;"></div>
    <img src="public/images/SwiftText.svg" style="position: absolute; top: 48%; left: 50%;  transform: translate(-50%, -50%); z-index: -2;" />
    <h1 style="position: absolute; top: 75%; left: 50%;  transform: translate(-50%, -50%); font-size: 3.813rem;"> Roulez vite, Roules bien.</h1>
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

  
  </main>
  <script src="https://cdn.jsdelivr.net/npm/animejs@3.0.1/lib/anime.min.js"></script>
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
    start: "top center",
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
  </script>
</body>
</html>
