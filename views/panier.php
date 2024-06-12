<?php
$current_page = 'panier';
include 'header.php';
?>

<main id="bucketContents"></main>

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
          groupedItems[item.id] = { ...item };
        }
      });
      return Object.values(groupedItems);
    }

    function calculateTotalPrice(bucket) {
      return bucket.reduce((total, item) => total + (item.prix * item.quantity), 0);
    }

    function renderBucket() {
      if (bucket.length === 0) {
          bucketContents.innerHTML = `
              <div class='panier'>
                <div class="content">
                  <h1>Votre panier est vide.</h1>
                  <p>Vous n'avez pas encore ajouté de vélo à votre panier.</p>
                  <a href="./catalogue">Aller au catalogue</a>
                </div>
              </div>
          `;
          updateBucketCount();
          return;
      }

      const groupedItems = groupItems(bucket);
      const totalPrice = calculateTotalPrice(groupedItems);

      let html = '<section class="panier-container"><div class="title-articile"><h1>Votre panier</h1>';

      groupedItems.forEach(item => {
        const itemUrl = `./velo?id_velo=${item.id}`;
        html += `<div class="article-container">
                    <div class="img-container">
                      <a href="${itemUrl}"><img src="${item.img}" alt="Vélo ${item.modele}"></a>
                    </div>
                    <div class="article-info">
                      <div class="article-text">
                        <h2><a href="${itemUrl}">${item.modele}</a></h2>
                        <span class="price">${item.prix}€ par jour</span>
                        <p class="description">${item.description}</p>
                        <div class="text-info">
                        <span>Quantité : ${item.quantity}</span>
                        <p>Début de réservation : <br>${item.start_date} | ${item.start_time}</p>
                        <p>Fin de réservation : <br>${item.end_date} | ${item.end_time}</p>
                        </div>
                      </div>
                      <div class="btn-container">
                        <button class="delete-button" title='bouton supprimer' data-id="${item.id}">
                        <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 24px;"></i>
                         <span class="sr-only">Supprimer</span>
                        </button>
                      </div>
                    </div>
                  </div>`;
      });

      html += `</div><section class="total-price">
      <button id="reserveAllButton" title='bouton réserver'>Réserver</button>
                 <h2>Prix par jour : ${totalPrice}€</h2>
               </section>`;
      html += '</section>';
      bucketContents.innerHTML = html;

      // Add event listeners to the delete buttons
      document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function() {
          const itemId = this.getAttribute('data-id');
          removeFromBucket(itemId);
        });
      });

      // Add event listener to the reserve button
      document.getElementById('reserveAllButton').addEventListener('click', function() {
        localStorage.setItem('reserveItems', JSON.stringify(bucket));
        window.location.href = './reservation';
      });

      updateBucketCount();
    }

    function removeFromBucket(itemId) {
      bucket = bucket.filter(item => item.id !== itemId);
      localStorage.setItem('bucket', JSON.stringify(bucket));
      renderBucket();
    }

    renderBucket();
  });
</script>

<?php include 'footer.php'; ?>
</body>
</html>
