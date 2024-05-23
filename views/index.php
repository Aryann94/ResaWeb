<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Swift</title>
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
      echo "<p>" . htmlspecialchars($category['description']) . "</p>";
      echo "<img src='public/images/" . htmlspecialchars($category['image_categorie']) . ".png' alt='Image de la catégorie'>";
    }
  } else {
    echo "<h1>Aucune catégorie trouvée</h1>";
  }
  ?>
</body>
</html>
