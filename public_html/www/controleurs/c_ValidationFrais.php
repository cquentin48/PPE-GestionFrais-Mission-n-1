<?php

    include_once '../includes/class.pdogsb.inc.php';

    /**
     * Met à jour la base de données pour les données
     * @param String date le mois des fiches hors-forfait
     * @param Array(int) FraisHorsForfaitTab la liste des frais hors-forfait à reporter
     */
    function validerFiche($mois, $idVisiteur) {
        $monPdo = PdoGsb::getPdoGsb();
        $monPdo->validerFiche($idVisiteur, $mois);
    }
?>