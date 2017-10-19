<?php
    $updateData;
    include_once './includes/class.pdogs.inc.php';
    /**
     * Met à jour la base de données
     * @param type $visiteur l'id du visiteur
     * @param type $mois le mois et l'année
     */
    function updateMYSQL($visiteur, $mois, $data){
        PdoGsb update = new PdoGsb();
        update->updateTable('fichefrais', $updateData, array("idvisiteur = ", "mois = "));//A compléter ici
    }

?>