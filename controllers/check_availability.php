<?php
include_once '../models/AvailabilityModel.php';

/**
 * Class AvalibabilityController
 */
class AvalibabilityController{
    private AvailabilityModel $avalibabilityModel;
    private string $velo_id;
    private string $requested_date;
    private string $requested_time;

    /**
     * AvalibabilityController constructor
     * @param string $velo_id
     * @param string $requested_date
     * @param string $requested_time
     */
    function __construct($velo_id, $requested_date, $requested_time){
        $this->velo_id = $velo_id;
        $this->requested_date = $requested_date;
        $this->requested_time = $requested_time;
        $this->avalibabilityModel = new AvailabilityModel();
    }

    function checkExclusionAvailability(){
        return $this->avalibabilityModel->checkExclusionAvailability($this->velo_id, $this->requested_date, $this->requested_time);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $velo_id = $_GET['velo_id'] ?? '';
    $requested_date = $_GET['start'] ?? '';
    $requested_time = $_GET['end'] ?? '';

    $avalibabilityController = new AvalibabilityController($velo_id, $requested_date, $requested_time);
    $response = $avalibabilityController->checkExclusionAvailability();
    
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
