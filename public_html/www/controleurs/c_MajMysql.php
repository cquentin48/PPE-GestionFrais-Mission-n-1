<?php

    include_once '../includes/class.pdogsb.inc.php';

    /**
     * Met à jour la base de données pour les données
     * @param String date le mois des fiches hors-forfait
     * @param Array(int) FraisHorsForfaitTab la liste des frais hors-forfait à reporter
     */
    function reporterListeFraisHorsForfait($FraisHorsForfaitTab, $dateFrais, $idVisiteur) {
        $i = 0;
        $dateReportee = reportDate($dateFrais);
        $monPdo = PdoGsb::getPdoGsb();
        //On met à jour la base de donnée Mysql
        for ($i = 0; $i < sizeOf($FraisHorsForfaitTab); $i++) {
            //$monPdo->creeNouvellesLignesFrais($idVisiteur, $dateReportee);
            $monPdo->reporter($FraisHorsForfaitTab[$i], $dateFrais, $dateReportee);
        }
    }
    /**
     * 
     * @param String $date la date à reporter
     * @return String la date reportée
     */
    function reportDate($date) {
        //année et mois
        $annee = intval(substr($date, 0, 4));
        $mois = intval(substr($date, 4, 2));
        //Si nous sommes arrivés en fin d'année
        if ($mois >= 11) {
            $mois = 1;
            $annee++;
            //Sinon ...
        } else {
            $mois++;
        }
        $annee = strval($annee);
        if($mois<10){
            return($annee."0".strval($mois));
        }else{
            return($annee.strval($mois));
        }
    }

?>