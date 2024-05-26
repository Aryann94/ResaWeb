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

    <div class="categorie-container">
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
</div>

  
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
    </script>
</body>
</html>
