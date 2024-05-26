<?php showView("header"); ?>


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
