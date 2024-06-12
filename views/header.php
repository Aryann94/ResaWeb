<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($title_page); ?> - Swift</title>
  <link rel="stylesheet" href="public/css/main.css">
  <!-- <link rel="stylesheet" href="public/css/index.css"> -->
  <link rel="stylesheet" href="public/css/<?php echo htmlspecialchars($current_page); ?>.css">
  <link href="https://api.fontshare.com/v2/css?f[]=satoshi@300,400,401,500,700&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="icon" type="image/x-icon" href="public/images/favicon.ico" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js" defer></script>
  <script src="https://kit.fontawesome.com/98633f0b27.js" crossorigin="anonymous" defer></script>
  <script src="public/js/<?php echo htmlspecialchars($current_page); ?>.js" defer></script>
  <script src="public/js/panier.js" defer></script>
  <script src="public/js/header.js" defer></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js" defer></script>
  <script src="https://unpkg.com/lenis@1.1.1/dist/lenis.min.js" defer></script>
</head>
<body>
  <div class="loader-container">
    <div class="loader"></div>
  </div>
  
  <header class="navbar">
    <nav class="nav-link">
      <a class="<?php echo ($current_page == 'index') ? 'active' : ''; ?>" href="./index">Accueil</a>
      <a class="<?php echo ($current_page == 'catalogue') ? 'active' : ''; ?>" href="./catalogue">Catalogue</a>
      <a class="<?php echo ($current_page == 'propos') ? 'active' : ''; ?>" href="./propos"">À propos</a>
    </nav>

    <div class="nav-logo">
      <a href="./index"><img src="public/images/logo.svg" alt="Accueil, logo de Swift"></a>
    </div>

    <div class="nav-buttons">
      <button id="search-btn" title="bouton rechercher">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span class="sr-only">Rechercher</span>
      </button>
      <a href="./panier"><i class="fa-solid fa-bag-shopping"></i><span id="bucketCount">0</span></a>
    </div>
  </header>

  <div id="blur-background"></div>
  <div class="search-container" id="search-container">
    <form class="search-form-header" method="GET" action="catalogue">
    <label class="sr-only" for="search">Rechercher par nom de vélo</label>
    <input type="text" id="search" name="search" placeholder="Rechercher par nom de vélo" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
      <button class="search-header" type="submit" title="bouton rechercher">
        <i class="fa-solid fa-magnifying-glass" style="color: #000;"></i>
        <span class="sr-only">Rechercher</span>
      </button>
    </form>
  </div>
