<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - Swift</title>
  <link rel="stylesheet" href="public/css/main.css">
  <link rel="stylesheet" href="public/css/index.css">
  <script src="https://kit.fontawesome.com/98633f0b27.js" crossorigin="anonymous"></script>
  <link href="https://api.fontshare.com/v2/css?f[]=satoshi@300,400,401,500,700&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="public/js/panier.js" defer></script>
</head>
<body>
  
  <header class="navbar">
    <nav class="nav-link">
      <a class="<?php echo ($current_page == 'index') ? 'active' : ''; ?>" href="/resaweb/index">Accueil</a>
      <a class="<?php echo ($current_page == 'catalogue') ? 'active' : ''; ?>" href="/resaweb/catalogue">Catalogue</a>
      <a class="<?php echo ($current_page == 'about') ? 'active' : ''; ?>" href="#">À propos</a>
    </nav>

    <div class="nav-logo">
      <a href=""><img src="public/images/logo.svg" alt=""></a>
    </div>

    <div class="nav-buttons">
      <button><i class="fa-solid fa-magnifying-glass"></i></button>
      <a href="/resaweb/panier"><i class="fa-solid fa-bag-shopping"></i><span id="bucketCount">0</span></a>
    </div>
  </header>