<?php
    include_once '../includes/class.pdogsb.inc.php';
    /**
     * Met à jour la base de données pour les données
     * @param type $userId
     * @param type $date
     * @param type $dateFraisTab
     */
    function updateData($userId, $dateFraisTab){
        $dateFraisTabReporte = $dateFraisTab;
        for($i = 0; $i<$dateFraisTabReporte.size();$i++){
            //année et mois
            $annee = intval(substr($dateFraisTabReporte,-3,-1));
            $mois = intval(substr($dateFraisTabReporte,0,4));
            //Si nous sommes arrivés en fin d'année
            if($mois++<12){
                $mois = 1;
                $annee++;
            //Sinon ...
            }else{
                $mois++;
            }
        }
        $pdo = PDOGSB::getPdoGsb();
        //On met à jour la base de donnée Mysql
        for($i = 0; $i<dateFaisTabReporte.size(); $i++){
            $pdo->reporter($userId, $dateFraisTab[i], $dateFraisTabReporte[i]);
        }
    }
?>