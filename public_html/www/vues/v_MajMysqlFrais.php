<?php
//Variables transmises par la méthode POST : l'id du visiteur et la date (mois/année) de la fiche de frais
include("../controleurs/c_MajMysql.php");
$date = $_POST['date'];
$idVisiteur = $_POST['user_id'];
$checkBoxArray = $_POST['checkBoxArray'];
if(is_array($checkBoxArray)){
    echo "<pre>";
    print_r($checkBoxArray);
}else{
    echo "pas un tableau";
}

//MAJ données
include_once('../controleurs/c_MajMysql.php');
reporterListeFraisHorsForfait($idVisiteur, $checkBoxArray, $date);
?>