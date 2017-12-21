<?php
    //On fait appel à la classe PdoGsb
    include_once '../includes/class.pdogsb.inc.php';
    
    //On récupère les données nécessaires pour la validation des données
    $idVisiteur = $_SESSION['idVisiteur'];
    $mois = $_POST['mois'];

    validerFiche($mois, $idVisiteur);
?>