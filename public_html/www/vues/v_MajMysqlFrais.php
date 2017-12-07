<?php
//Variables transmises par la méthode POST : l'id du visiteur et la date (mois/année) de la fiche de frais
$date = $_POST['date'];
$idVisiteur = $_POST['user_id'];
$reportId = $_POST['reports'];
$data;
$tabSize;

//MAJ données
include('../controleurs/c_MajMysql.php');
updateData($idVisiteur, $date);

//Affichage de la liste des clés des éléments reportés pour le mois prochain de la fiche de frais
//Entête
    $checkBoxTab;
    foreach ($reports as $report) {
        
    }
?>