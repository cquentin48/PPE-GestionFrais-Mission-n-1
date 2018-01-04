<?php
//Variables transmises par la méthode POST : l'id du visiteur et la date (mois/année) de la fiche de frais
include("../controleurs/c_MajMysql.php");
$date = $_POST['date'];
$idVisiteur = $_POST['user_id'];
$checkBoxArray = ($_POST['checkBoxArray']);
print_r($checkBoxArray);
//MAJ données
include_once('../controleurs/c_MajMysql.php');
reporterListeFraisHorsForfait($checkBoxArray, $date, $idVisiteur);
echo "Report de ".sizeof($checkBoxArray)."élément au mois prochain.";
?>