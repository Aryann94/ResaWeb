<?php
$current_page = 'reservation';
include 'header.php';
require_once '../controllers/ReservationController.php';

$reservationController = new ReservationController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $reservationController->handleReservation($_POST);
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
        <input required type="text" placeholder=" " id="last_name" name="user_last_name">
        <label for="last_name">Nom</label>
      </div>
      <div class="form-group">
        <input required type="text" placeholder=" " id="first_name" name="user_first_name">
        <label for="first_name">Prénom</label>
      </div>
      <div class="form-group">
        <input required type="email" placeholder=" " id="email" name="user_email">
        <label for="email">Adresse mail</label>
      </div>  
      
      <div id="veloDetailsContainer"></div>

      <button class="submit-button" type="submit">Réservez</button>
    </form>

    <div class="order">
        <h2>Votre commande</h2>
        <div>
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
          <div class="form-group">
            <input type="hidden" name="velo_ids[]" value="${item.id}">
            <input type="date" name="start_dates[]" value="${item.start_date}" readonly>
            <input type="time" name="start_times[]" value="${item.start_time}" readonly>
            <input type="date" name="end_dates[]" value="${item.end_date}" readonly>
            <input type="time" name="end_times[]" value="${item.end_time}" readonly>
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
      localStorage.removeItem('reserveItems');
      localStorage.removeItem('bucket');
      setTimeout(function() {
        window.location.href = './index';
      }, 1000);
    }
  });
</script>


</body>
</html>
