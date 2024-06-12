<?php
$current_page = 'reservation';
include 'header.php';
require_once '../controllers/ReservationController.php';

$reservationController = new ReservationController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $reservationController->handleReservation($_POST);
        $toMail = $_POST['user_email'];
        $fromMail = "info@resaweb.inc.butmmi.o2switch.site";
        
        $subject = "Confirmation de réservation";
        
        $nom = $_POST["user_last_name"];
        $prenom = $_POST["user_first_name"];
        
        $start_dates = $_POST['start_dates'];
        $end_dates = $_POST['end_dates'];
        
        $message = "
        <html>
        <head>
            <title>Confirmation de reservation</title>
        </head>
        <body>
            <p>Bonjour $prenom $nom,</p>
            <p>Merci pour votre réservation à Swift !</p>
            <p>Voici les détails de votre réservation :</p>
            <ul>";
        
        for ($i = 0; $i < count($start_dates); $i++) {
            $message .= "<li>Date : " . htmlspecialchars($start_dates[$i]) . " to " . htmlspecialchars($end_dates[$i]) . "</li>";
        }
        
        $message .= "
            </ul>
            <p>À bientôt !</p>
        </body>
        </html>";
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: info@resaweb.inc.butmmi.o2switch.site" . "\r\n";
         
        mail($toMail, $subject, $message, $headers);
        echo "<p id='success-message'>Reservation successfully added!</p>";
    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<div class="container">
  <form class="form-container" action="" method="POST">
      <h2>Réservez vos Swift</h2> 
      <div class="form-group">
        <input required type="text" placeholder=" " id="last_name" name="user_last_name" aria-describedby="lastNameHelp">
        <label for="last_name">Nom</label>
        <small id="lastNameHelp">Votre nom de famille.</small>
      </div>
      <div class="form-group">
        <input required type="text" placeholder=" " id="first_name" name="user_first_name" aria-describedby="firstNameHelp">
        <label for="first_name">Prénom</label>
        <small id="firstNameHelp">Votre prénom usuel.</small>
      </div>
      <div class="form-group">
        <input required type="email" placeholder=" " id="email" name="user_email" aria-describedby="emailHelp">
        <label for="email">Adresse mail</label>
        <small id="emailHelp">Nous ne partagerons jamais votre adresse email.</small>
      </div>  
      
      <div id="veloDetailsContainer"></div>
      <!-- règle 69 -->
      <p>Tous les champs sont obligatoires.</p> 
      <button class="submit-button" type="submit">Réservez</button>
    </form>

    <div class="order">
        <h2>Votre commande</h2>
        <div class="order-info">
            <p id="productCount"></p>
            <p>Livraison Gratuit</p>
            <h3 id="totalPrice"></h3>
        </div>
        <div id="productList"></div>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const reserveItems = JSON.parse(localStorage.getItem('reserveItems')) || [];
    const veloDetailsContainer = document.getElementById('veloDetailsContainer');
    const totalPriceElement = document.getElementById('totalPrice');
    const productList = document.getElementById('productList');
    const productCountElement = document.getElementById('productCount');

    let totalPrice = 0;

    if (reserveItems.length > 0) {
      let formHtml = '';
      let orderHtml = '';
      reserveItems.forEach(item => {
        const startDate = new Date(item.start_date);
        const endDate = new Date(item.end_date);
        const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
        const itemTotalPrice = item.prix * days * item.quantity;
        totalPrice += itemTotalPrice;

        formHtml += `
        <div class="form-group" style="display: none;">
          <input type="hidden" name="velo_ids[]" value="${item.id}">
          <input type="hidden" name="start_dates[]" value="${item.start_date}" readonly>
          <input type="hidden" name="start_times[]" value="${item.start_time}" readonly>
          <input type="hidden" name="end_dates[]" value="${item.end_date}" readonly>
          <input type="hidden" name="end_times[]" value="${item.end_time}" readonly>
        </div>
      `;

      orderHtml += `
        <div class="product">
          <div class="img-container">
            <img src="${item.img}" alt="${item.modele}">
          </div>
          <div>
              <p>${item.modele} - ${itemTotalPrice} €</p>
              <p>Quantités : ${item.quantity}</p>
              <p>Début de réservation : <br>${item.start_date} à ${item.start_time}</p>
              <p>Fin de réservation : <br>${item.end_date} à ${item.end_time}</p>
          </div>
        </div>
      `;
    });
      veloDetailsContainer.innerHTML = formHtml;
      productList.innerHTML = orderHtml;
      productCountElement.innerHTML = `${reserveItems.length} produits`;
      totalPriceElement.innerHTML = `Prix total de la réservation : ${totalPrice} €`;
    }


    const successMessage = document.getElementById('success-message');

    if (successMessage) {
        // Afficher une alerte de succès
        Swal.fire({
            icon: 'success',
            title: 'Réservation réussie !',
            text: 'Votre réservation a été effectuée avec succès.',
            showConfirmButton: false,
            timer: 2000 // Fermer automatiquement après 2 secondes
        }).then(() => {
            // Nettoyer le local storage après la réservation réussie
            localStorage.removeItem('reserveItems');
            localStorage.removeItem('bucket');
            // Rediriger vers la page d'accueil après un court délai
            setTimeout(function () {
                window.location.href = './index';
            }, 2000); // Rediriger après 2 secondes
        });
    }

  });

</script>


</body>
</html>