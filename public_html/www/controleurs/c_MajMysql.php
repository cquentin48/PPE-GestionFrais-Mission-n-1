<?php

    include_once '../includes/class.pdogsb.inc.php';

    /**
     * Met à jour la base de données pour les données
     * @param int userId l'identifiant de l'utilisateur
     * @param String date le mois des fiches hors-forfait
     * @param Array(int) FraisHorsForfaitTab la liste des frais hors-forfait à reporter
     */
    function reporterListeFraisHorsForfait($userId, $FraisHorsForfaitTab, $dateFrais) {

        $dateReportee = reportDate($dateFrais);
        $pdo = PdoGsb::getPdoGsb();
        //On met à jour la base de donnée Mysql
        for ($i = 0; $i < 1/*$FraisHorsForfaitTab.size()*/; $i++) {
            $pdo->reporter($userId, $dateFrais, $dateReportee);
        }
    }
    /**
     * 
     * @param String $date la date à reporter
     * @return String la date reportée
     */
    function reportDate($date) {
        $dateReporte;
        //année et mois
        $annee = intval(substr($date, -3, -1));
        $mois = intval(substr($date, 0, 4));
        //Si nous sommes arrivés en fin d'année
        if ($mois++ < 12) {
            $mois = 1;
            $annee++;
            //Sinon ...
        } else {
            $mois++;
        }
        return($mois+$annee);
    }

?>