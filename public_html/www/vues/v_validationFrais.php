<?php
    //On fait appel à la classe PdoGsb
    include_once '../includes/class.pdogsb.inc.php';
    include_once '../controleurs/c_ValidationFrais.php';
    
    //On récupère les données nécessaires pour la validation des données
    $idVisiteur = $_POST['user_id'];
    $mois = $_POST['date'];

    $result = validerFiche($mois, $idVisiteur);
?>