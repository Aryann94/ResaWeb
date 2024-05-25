<?php
require_once '../models/Database.php';

/**
 * Class AvailabilityModel
 */
class AvailabilityModel
{
    /**
     * Check inclusion availability
     *
     * @param int $velo_id
     * @param string $requested_start
     * @param string $requested_end
     * @return array
     */
    public function checkInclusionAvailability($velo_id, $requested_start, $requested_end) {
        $mysqli = Database::getInstance();
        $sql = "SELECT * FROM planning
                WHERE velo_id = ?
                AND (? BETWEEN debut_dispo AND fin_dispo
                OR ? BETWEEN debut_dispo AND fin_dispo)";
        
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Failed to prepare the SQL statement: " . $mysqli->error);
        }

        $stmt->bind_param('iss', $velo_id, $requested_start, $requested_end);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute the SQL statement: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $row = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $mysqli->close();

        $response = [];

        if (empty($row)) {
            $response['available'] = false;
        } else {
            $response['available'] = true;
        }

        return $response;
    }
}
?>
