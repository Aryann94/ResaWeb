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

<div class="resa">
  <form class="form-container" action="" method="POST">
      <h2>Réservez votre Swift</h2> 
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
      <div class="form-row">
        <div class="form-date">
          <label for="start_date">Date de début</label>
          <input type="date" id="start_date" name="start_date" >
        </div>
        <div class="form-date">
          <label for="start_time">Heure de début</label>
          <input type="time" id="start_time" name="start_time" >
        </div>
      </div>
      <div class="form-row">
        <div class="form-date">
          <label for="end_date">Date de fin</label>
          <input type="date" id="end_date" name="end_date" >
        </div>
        <div class="form-date">
          <label for="end_time">Heure de fin</label>
          <input type="time" id="end_time" name="end_time" >
        </div>
      </div>
      <input type="hidden" id="id_velo" name="id_velo" value="">

      <button class="submit-button" type="submit">Réservez</button>
    </form>
  </div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const reserveItem = JSON.parse(localStorage.getItem('reserveItem'));
    if (reserveItem) {
      document.getElementById('start_date').value = reserveItem.start_date;
      document.getElementById('start_time').value = reserveItem.start_time;
      document.getElementById('end_date').value = reserveItem.end_date;
      document.getElementById('end_time').value = reserveItem.end_time;
      document.getElementById('id_velo').value = reserveItem.id;
    }

    const successMessage = document.getElementById('success-message');
    if (successMessage) {
      localStorage.removeItem('reserveItem');

      // Also remove the item from the main bucket
      let bucket = JSON.parse(localStorage.getItem('bucket')) || [];
      bucket = bucket.filter(item => item.id !== reserveItem.id);
      localStorage.setItem('bucket', JSON.stringify(bucket));

      setTimeout(function() {
        window.location.href = '/resaweb/index';
      }, 1000);
    }
  });
</script>

</body>
</html>