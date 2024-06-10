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
        $name = $data['user_first_name'] . ' ' . $data['user_last_name'];
        $email = $data['user_email'];

        $velo_ids = $data['velo_ids'];
        $start_dates = $data['start_dates'];
        $start_times = $data['start_times'];
        $end_dates = $data['end_dates'];
        $end_times = $data['end_times'];

        $reservations = [];
        foreach ($velo_ids as $index => $id_velo) {
            $reservations[] = [
                'id_velo' => $id_velo,
                'start_date_time' => $start_dates[$index] . ' ' . $start_times[$index] . ':00',
                'end_date_time' => $end_dates[$index] . ' ' . $end_times[$index] . ':00'
            ];
        }

        return $this->reservationModel->addReservations($reservations, $name, $email);
    }
}
?>
