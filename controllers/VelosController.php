<?php
include_once '../models/VelosModel.php';

/**
 * Class CategoriesController
 */
class VelosController{
    private VelosModel $velosModel;
    private string $filter;
    private string $sort;
    private string $categorie;

    /**
     * QuizController constructor.
     * @param string|null $search
     */
    function __construct(?string $search = null, ?string $sort = null, ?string $categorie = null) {
        $this->velosModel = new VelosModel();
        $this->filter = $search ?? "";
        $this->sort = $sort ?? "";
        $this->categorie = $categorie ?? "";
    }

    /**
     * @return array
     */
    function getAllVelos() {
        return $this->velosModel->getAllVelos($this->filter, $this->sort, $this->categorie);
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

?>