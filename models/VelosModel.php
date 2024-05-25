<?php
require_once '../models/Database.php';

/**
 * Class Users : Use the Database class to manage a user for register, login and settings pages
 */
class VelosModel
{
    /**
     * @param string $filter for show only categories with a name like $filter, if $filter is empty show all categories
     *  @return array return all categories
     */
    public function getAllVelos(string $filter = "")
    {
        $mysqli = Database::getInstance();

        if (empty($filter)) {
            $sql = "SELECT v.*, i.URL, i.alt 
                    FROM velo v 
                    LEFT JOIN image i ON v.id_velo = i.velo_id";
        } else {
            $sql = "SELECT v.*, i.URL, i.alt 
                    FROM velo v 
                    LEFT JOIN image i ON v.id_velo = i.velo_id 
                    WHERE v.id_velo LIKE ?";
        }

        $stmt = $mysqli->stmt_init();
        if (!$stmt->prepare($sql)) {
            error_log("Fail during preparation of statement\n");
            exit();
        }

        if (!empty($filter)) {
            $stmt->bind_param("s", $filter);
        }

        $stmt->execute();
        $results = $stmt->get_result();
        if (!$results) {
            error_log("Error in query : " . $sql . "\n");
            exit();
        }
        $velos = $results->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $velos;
    }

       /**
     * Récupère tous les vélos marqués comme meilleurs produits.
     * @return array
     */
    public function getBestVelos()
    {
        $mysqli = Database::getInstance();
        $sql = "SELECT v.*, i.URL, i.alt 
                FROM velo v 
                LEFT JOIN image i ON v.id_velo = i.velo_id 
                WHERE v.meilleur_produit = 1";

        $stmt = $mysqli->stmt_init();
        if (!$stmt->prepare($sql)) {
            error_log("Fail during preparation of statement\n");
            exit();
        }

        $stmt->execute();
        $results = $stmt->get_result();
        if (!$results) {
            error_log("Error in query : " . $sql . "\n");
            exit();
        }
        $velos = $results->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $velos;
    }
    /**
     * Récupère tous les vélos marqués comme nouveaux produits.
     * @return array
     */
    public function getNewVelos()
    {
        $mysqli = Database::getInstance();
        $sql = "SELECT v.*, i.URL, i.alt 
                FROM velo v 
                LEFT JOIN image i ON v.id_velo = i.velo_id 
                WHERE v.nouveau_produit = 1";

        $stmt = $mysqli->stmt_init();
        if (!$stmt->prepare($sql)) {
            error_log("Fail during preparation of statement\n");
            exit();
        }

        $stmt->execute();
        $results = $stmt->get_result();
        if (!$results) {
            error_log("Error in query : " . $sql . "\n");
            exit();
        }
        $velos = $results->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $velos;
    }

    public function getVeloDetails($veloId) {
        $mysqli = Database::getInstance();
        $sql = "SELECT v.*, c.nom_categorie, i.URL, i.alt 
                FROM velo v 
                LEFT JOIN categorie c ON v.id_categorie = c.id_categorie
                LEFT JOIN image i ON v.id_velo = i.velo_id 
                WHERE v.id_velo = ?";
    
        $stmt = $mysqli->stmt_init();
        if (!$stmt->prepare($sql)) {
            error_log("Fail during preparation of statement\n");
            exit();
        }
    
        $stmt->bind_param("i", $veloId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }
    

}