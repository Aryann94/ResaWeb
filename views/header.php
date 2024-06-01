<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($title_page); ?> - Swift</title>
  <link rel="stylesheet" href="public/css/main.css">
  <!-- <link rel="stylesheet" href="public/css/index.css"> -->
  <link rel="stylesheet" href="public/css/<?php echo htmlspecialchars($current_page); ?>.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://kit.fontawesome.com/98633f0b27.js" crossorigin="anonymous"></script>
  <link href="https://api.fontshare.com/v2/css?f[]=satoshi@300,400,401,500,700&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="public/js/<?php echo htmlspecialchars($current_page); ?>.js" defer></script>
  <script src="public/js/panier.js" defer></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.getElementById('search-btn');
    const searchContainer = document.getElementById('search-container');
    const blurBackground = document.getElementById('blur-background');
    
    searchBtn.addEventListener('click', function() {
      if (searchContainer.classList.contains('show')) {
        searchContainer.classList.remove('show');
        setTimeout(() => {
          searchContainer.style.display = 'none';
        }, 300); // Correspond à la durée de la transition CSS
      } else {
        searchContainer.style.display = 'flex';
        setTimeout(() => {
          searchContainer.classList.add('show');
        }, 10); // Petit délai pour permettre le changement de display avant l'ajout de la classe
      }
      
      if (blurBackground.classList.contains('show')) {
        blurBackground.classList.remove('show');
        setTimeout(() => {
          blurBackground.style.display = 'none';
        }, 300); // Correspond à la durée de la transition CSS
      } else {
        blurBackground.style.display = 'block';
        setTimeout(() => {
          blurBackground.classList.add('show');
        }, 10); // Petit délai pour permettre le changement de display avant l'ajout de la classe
      }
    });

    blurBackground.addEventListener('click', function() {
      searchContainer.classList.remove('show');
      blurBackground.classList.remove('show');
      setTimeout(() => {
        searchContainer.style.display = 'none';
        blurBackground.style.display = 'none';
      }, 300); // Correspond à la durée de la transition CSS
    });
  });
</script>
</head>
<body>
  
  <header class="navbar">
    <nav class="nav-link">
      <a class="<?php echo ($current_page == 'index') ? 'active' : ''; ?>" href="/resaweb/index">Accueil</a>
      <a class="<?php echo ($current_page == 'catalogue') ? 'active' : ''; ?>" href="/resaweb/catalogue">Catalogue</a>
      <a class="<?php echo ($current_page == 'about') ? 'active' : ''; ?>" href="#">À propos</a>
    </nav>

    <div class="nav-logo">
      <a href="/resaweb/index"><img src="public/images/logo.svg" alt=""></a>
    </div>

    <div class="nav-buttons">
      <button id="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
      <a href="/resaweb/panier"><i class="fa-solid fa-bag-shopping"></i><span id="bucketCount">0</span></a>
    </div>
  </header>

  <div id="blur-background"></div>
  <div class="search-container" id="search-container">
    <form class="search-form-header" method="GET" action="catalogue">
      <input type="text" name="search" placeholder="Rechercher par nom de vélo" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
      <button class="search-header" type="submit"><i class="fa-solid fa-magnifying-glass" style="color: #000;"></i></button>
    </form>
  </div>
