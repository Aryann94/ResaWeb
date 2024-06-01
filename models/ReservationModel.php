<?php
require_once '../models/Database.php';

/**
 * Class ReservationModel
 */
class ReservationModel
{
    /**
     * Add a new reservation to the database
     *
     * @param int $id_velo
     * @param string $start_date_time
     * @param string $end_date_time
     * @param string $name
     * @param string $email
     * @param string $status
     * @return bool
     */
    public function addReservation($id_velo, $start_date_time, $end_date_time, $name, $email) {
        $mysqli = Database::getInstance();
        $date_resa = date('Y-m-d H:i:s'); // Current timestamp for reservation date

        $sql = "INSERT INTO reservation (id_velo, date_heure_debut, date_heure_fin, nom_resa, mail, date_resa)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Failed to prepare the SQL statement: " . $mysqli->error);
        }

        $stmt->bind_param('isssss', $id_velo, $start_date_time, $end_date_time, $name, $email, $date_resa);

        if (!$stmt->execute()) {
            throw new Exception("Failed to execute the SQL statement: " . $stmt->error);
        }

        // update planning table
        $sql = "INSERT INTO planning (velo_id, debut_dispo, fin_dispo)
                VALUES (?, ?, ?)";
        
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Failed to prepare the SQL statement: " . $mysqli->error);
        }

        $stmt->bind_param('iss', $id_velo, $start_date_time, $end_date_time);

        if (!$stmt->execute()) {
            throw new Exception("Failed to execute the SQL statement: " . $stmt->error);
        }


        $stmt->close();
        $mysqli->close();

        return true;
    }
}
?>
