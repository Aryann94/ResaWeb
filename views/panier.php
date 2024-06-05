<?php
$current_page = 'panier';

include 'header.php';
?>
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
          groupedItems[item.id] = { ...item };
        }
      });
      return Object.values(groupedItems);
    }

    function renderBucket() {
      if (bucket.length === 0) {
          bucketContents.innerHTML = `
              <div class='panier'>
                <div class="content">
                  <h1>Votre panier est vide.</h1>
                  <p>Vous n'avez pas encore ajouté de vélo à votre panier.</p>
                  <a href="/resaweb/catalogue">Aller au catalogue</a>
                </div>
              </div>
          `;
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
                    <p>Date de début: ${item.start_date} ${item.start_time}</p>
                    <p>Date de fin: ${item.end_date} ${item.end_time}</p>
                    <button class="delete-button" data-id="${item.id}">Supprimer</button>
                    <button class="reserve-button" data-id="${item.id}">Réserver</button>
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

      // Add event listeners to the reserve buttons
      document.querySelectorAll('.reserve-button').forEach(button => {
        button.addEventListener('click', function() {
          const itemId = this.getAttribute('data-id');
          const item = bucket.find(item => item.id === itemId);
          localStorage.setItem('reserveItem', JSON.stringify(item));
          window.location.href = '/resaweb/reservation';
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
