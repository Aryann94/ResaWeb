<?php
include_once '../models/CategoriesModel.php';

/**
 * Class CategoriesController
 */
class CategoriesController{
    private CategoriesModel $categoriesModel;
    private string $filter;

    /**
     * CategoriesController constructor.
     * @param string|null $search
     */
    function __construct(?string $search = null) { // search is a string and is nullable
        $this->categoriesModel = new CategoriesModel();
        $this->filter = ($search != null) ? $search : "";
    }

    /**
     * @return array
     */
    function getAllCategories(){
        return $this->categoriesModel->getAllCategories($this->filter);
    }
}

?>