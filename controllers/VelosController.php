<?php
include_once '../models/VelosModel.php';

/**
 * Class CategoriesController
 */
class VelosController{
    private VelosModel $velosModel;
    private string $filter;

    /**
     * QuizController constructor.
     * @param string|null $search
     */
    function __construct(?string $search = null) { // search is a string and is nullable
        $this->velosModel = new VelosModel();
        $this->filter = ($search != null) ? $search : "";
    }

    /**
     * @return array
     */
    function getAllVelos(){
        return $this->velosModel->getAllVelos($this->filter);
    }

    function getBestVelos() {
        return $this->velosModel->getBestVelos();
    }

    function getNewVelos() {
        return $this->velosModel->getNewVelos();
    }

    function getVeloDetails($veloId) {
    return $this->velosModel->getVeloDetails($veloId);
    }
    // Récupérer le nom de la catégorie


}