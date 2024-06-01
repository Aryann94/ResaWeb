<?php
require_once '../models/ReservationModel.php';
require_once '../models/AvailabilityModel.php'; 


/**
 * Class ReservationController
 */
class ReservationController
{
    private $reservationModel;


    public function __construct() {
        $this->reservationModel = new ReservationModel();
    }

    /**
     * Handle the reservation form submission
     *
     * @param array $data
     * @return bool
     */
    public function handleReservation($data) {
        $id_velo = $data['id_velo'];
        $start_date_time = $data['start_date'] . ' ' . $data['start_time'] . ':00';
        $end_date_time = $data['end_date'] . ' ' . $data['end_time'] . ':00';
        $name = $data['user_first_name'] . ' ' . $data['user_last_name'];
        $email = $data['user_email'];

        $reservationSuccess = $this->reservationModel->addReservation($id_velo, $start_date_time, $end_date_time, $name, $email);

        return $reservationSuccess;
    }
}
?>
