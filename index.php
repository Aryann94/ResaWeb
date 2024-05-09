 <!DOCTYPE html>
 <html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Swift</title>
  <link rel="stylesheet" href="styles.css">
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
      <button><i class="fa-solid fa-magnifying-glass"></i></i></button>
      <a href=""><i class="fa-solid fa-bag-shopping"></i></a>
    </div>
  </header>
 </body>
 </html>


<?php
  try {
    $db=new PDO('mysql:host=localhost;dbname=resa_web;port=3306;charset=utf8', 'root', '');
    // $requete="SELECT * FROM film,genre,realisateur WHERE id_genre=fk_genre AND id_real=fk_real";

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "";
  } catch(PDOException $e) {
      echo "Erreur de connexion : " . $e->getMessage();
  }

  /*
  if (isset($_GET["tri"])) {
      $requete = $requete . " ORDER BY " . $_GET["tri"];
  };

  $stmt=$db->query($requete);
  $resultat=$stmt->fetchall(PDO::FETCH_ASSOC);
  foreach ($resultat as $film){
      echo "<tr><td>".$film["titre"]."</td><td>".$film["nom_real"]."</td><td>".$film["nom_genre"]."</td></tr>";
      // echo "<tr><td>{$film["titre"]}</td><td>{$film["nom_real"]}</td><td>{$film["nom_genre"]}</td></tr>";
  }
  */
?>