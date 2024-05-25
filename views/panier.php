<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="public/css/main.css">
  <script src="https://kit.fontawesome.com/98633f0b27.js" crossorigin="anonymous"></script>
  <link href="https://api.fontshare.com/v2/css?f[]=satoshi@300,400,401,500,700&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="public/js/panier.js" defer></script>
</head>
<body>
<header class="navbar">
    <nav class="nav-link">
      <a class="active" href="#">Accueil</a>
      <a href="#">Catalogue </a>
      <a href="#">À propos</a>
    </nav>

    <div class="nav-logo">
      <a href=""><img src="public/images/logo.svg" alt=""></a>
    </div>

    <div class="nav-buttons">
      <button><i class="fa-solid fa-magnifying-glass"></i></button>
      <a href="#"><i class="fa-solid fa-bag-shopping"></i><span id="bucketCount">0</span></a>
    </div>
</header>

<h1>Panier</h1>
<div id="bucketContents"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bucketContents = document.getElementById('bucketContents');
        let bucket = JSON.parse(localStorage.getItem('bucket')) || [];

        function groupItems(bucket) {
            const groupedItems = {};
            bucket.forEach(item => {
                if (groupedItems[item.id]) {
                    groupedItems[item.id].quantity += item.quantity; // Increment quantity properly
                } else {
                    groupedItems[item.id] = {...item};
                }
            });
            return Object.values(groupedItems);
        }

        function renderBucket() {
            if (bucket.length === 0) {
                bucketContents.innerHTML = '<p>Votre panier est vide.</p>';
                updateBucketCount();
                return;
            }

            const groupedItems = groupItems(bucket);
            let html = '<ul>';

            groupedItems.forEach(item => {
                html += `<li>
                            <h2>${item.modele} - ${item.prix} €</h2>
                            <p>Description: ${item.description}</p>
                            <p>Quantité: ${item.quantity}</p>
                            <button class="delete-button" data-id="${item.id}">Supprimer</button>
                         </li>`;
            });

            html += '</ul>';
            bucketContents.innerHTML = html;

            // Add event listeners to the delete buttons
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    removeFromBucket(itemId);
                });
            });

            updateBucketCount();
        }

        function removeFromBucket(itemId) {
            bucket = bucket.filter(item => item.id !== itemId);
            localStorage.setItem('bucket', JSON.stringify(bucket));
            location.reload(); // Reload the page
        }

        renderBucket();
    });
</script>

</body>
</html>
