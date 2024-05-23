<?php
require_once '../models/Database.php';

/**
 * Class Users : Use the Database class to manage a user for register, login and settings pages
 */
class CategoriesModel
{
    /**
     * @param string $filter for show only categories with a name like $filter, if $filter is empty show all categories
     *  @return array return all categories
     */
    public function getAllCategories(string $filter){
        $mysqli = Database::getInstance();
        if(empty($filter)){
            $sql = "SELECT * FROM categorie";
        }else{
            $sql = "SELECT * FROM categorie WHERE name LIKE '%$filter%'";
        }

        $stmt = $mysqli->stmt_init();
        if(!$stmt->prepare($sql)){
            error_log("Fail during preparation of statement\n");
            exit();
        }
        if(!(empty($filter))){
            $stmt->bind_param("s", $filter);
        }

        $stmt->execute();
        $results = $stmt->get_result();
        if(!$results){
            error_log("Error in query : " . $sql. "\n");
            exit();
        }
        $categories = $results->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $categories;
    }

}