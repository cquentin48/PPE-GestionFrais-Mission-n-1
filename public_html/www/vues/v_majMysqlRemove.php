<?php
include_once '../controleurs/c_majMYSQL.php';
include_once '../include/class.pdogsb.inc.php';

//Création de la date au format MMYYYY
$date = dateFormat($_POST['month'],$POST['year']);

//Création du tableau pour la mise à jour
$updateData = array();

//Mise à jour des données de la bas MYSQL
$return = handlingSQL("Remove",$_SESSION['idVisiteur'],$date,updateData);

//Affichage du message de mise à jour
echo $return;

?>