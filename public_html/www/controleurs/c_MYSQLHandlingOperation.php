<?php
    $updateData;
    include_once '../includes/class.pdogs.inc.php';
    /**
     * Met à jour la base de données
     * @param type $visiteur l'id du visiteur
     * @param type $mois le mois et l'année
     */
    function handlingSQL($operationType, $tableName, $data, $where = ""){
        $PDO = new PDO();//Création d'un Pdo
        //Mise à jour des données MYSQL
        $requetePrepare = PdoGsb::$monPdo->handlingTable('update',
                                                        $tableName,
                                                        $updateData,
                                                        $where
                                                      );
    }
    /**
     * Formatage de date
     * @param type $month le mois
     * @param type $year l'année
     * @return type Date formatée au format MMYYYY | text
     */
    function dateFormat($month, $year){
        return $month.$year;
    }

?>