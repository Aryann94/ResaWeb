<?php
showView("header");

// Disable caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<?php
// Inclure le fichier VelosController.php
require_once '../controllers/VelosController.php';


// Récupérer l'ID du vélo depuis l'URL
$id_velo = isset($_GET['id_velo']) ? $_GET['id_velo'] : null;

// Instancier le contrôleur des vélos
$velosControl = new VelosController();

// Récupérer les détails du vélo
$veloDetails = $velosControl->getVeloDetails($id_velo);

// Afficher les détails du vélo
if (!empty($veloDetails['URL'])) {
  echo "<img src='" . htmlspecialchars($veloDetails['URL']) . "' alt='" . htmlspecialchars($veloDetails['alt']) . "'>";
}
echo "<h1>" . htmlspecialchars($veloDetails['modele']) . "</h1>";
echo "<p>Prix par jour : " . htmlspecialchars($veloDetails['prix_par_jour']) . " €</p>";
echo "<p>Description : " . htmlspecialchars($veloDetails['description_velo']) . "</p>";
echo "<p>Taille : " . htmlspecialchars($veloDetails['taille']) . " cm</p>";
echo "<p>Catégorie : " . htmlspecialchars($veloDetails['nom_categorie']) . "</p>";
echo "<p>Nombre de vitesses : " . htmlspecialchars($veloDetails['nbr_vitesse']) . "</p>";

// Vérifier si le vélo est un nouveau produit ou l'un des meilleurs produits
if ($veloDetails['nouveau_produit'] == 1) {
    echo "<p>Nouveau produit</p>";
}

if ($veloDetails['meilleur_produit'] == 1) {
    echo "<p>Meilleur produit</p>";
}
?>

<!-- Date and Time Picker -->
<label for="start_date">Date de début:</label>
<input type="date" id="start_date" name="start_date">

<label for="start_time">Heure de début:</label>
<input type="time" id="start_time" name="start_time">

<label for="end_date">Date de fin:</label>
<input type="date" id="end_date" name="end_date">
<label for="end_time">Heure de fin:</label>
<input type="time" id="end_time" name="end_time">

<button id="checkAvailabilityButton">Vérifier la disponibilité</button>
<button id="addToBucketButton" data-id="<?php echo $id_velo; ?>" style="display:none;">Ajouter au Panier</button>


<script>
  $(function() {
        $("#start_date, #end_date").datepicker({ dateFormat: 'yy-mm-dd' });
    });
    document.addEventListener('DOMContentLoaded', function() {
      const checkAvailabilityButton = document.getElementById('checkAvailabilityButton');

        const addToBucketButton = document.getElementById('addToBucketButton');

        checkAvailabilityButton.addEventListener('click', function() {
            const startDate = document.getElementById('start_date').value;
            const startTime = document.getElementById('start_time').value + ":00";
            const endDate = document.getElementById('end_date').value;
            const endTime = document.getElementById('end_time').value + ":00";

            const startDateTime = `${startDate} ${startTime}`;
            const endDateTime = `${endDate} ${endTime}`;

            $.ajax({
                url: '/resaweb/check_availability',
                method: 'POST',
                data: {
                    velo_id: addToBucketButton.getAttribute('data-id'),
                    start: startDateTime,
                    end: endDateTime
                },
                success: function(response) {
                    if (response.available) {
                        alert('Le vélo est disponible.');
                        addToBucketButton.style.display = 'block';
                    } else {
                        alert('Le vélo n\'est pas disponible.');
                        addToBucketButton.style.display = 'none';
                    }
                }
            });
        });

        if (addToBucketButton) {
            addToBucketButton.addEventListener('click', function() {
                const veloId = this.getAttribute('data-id');
                const veloDetails = {
                    id: veloId,
                    modele: "<?php echo htmlspecialchars($veloDetails['modele']); ?>",
                    prix: "<?php echo htmlspecialchars($veloDetails['prix_par_jour']); ?>",
                    description: "<?php echo htmlspecialchars($veloDetails['description_velo']); ?>",
                    quantity: 1 // Default to 1, or fetch the actual quantity if needed
                };

                let bucket = JSON.parse(localStorage.getItem('bucket')) || [];
                const existingItemIndex = bucket.findIndex(item => item.id === veloId);
                if (existingItemIndex > -1) {
                    bucket[existingItemIndex].quantity += 1;
                } else {
                    bucket.push(veloDetails);
                }

                localStorage.setItem('bucket', JSON.stringify(bucket));
                updateBucketCount();
            });
        }
    });
</script>

</body>
</html>