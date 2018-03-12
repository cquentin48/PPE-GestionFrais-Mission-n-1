<?php
    require_once '../includes/class.pdogsb.inc.php';
    $userId = $_POST['user_id'];
    
    //Chargement des mois en fonction des utilisateurs
    $pdo = PdoGsb::getPdoGsb();
    $dates = $pdo->getLesMoisDisponibles($userId);
    
    //Définition des fonctions pour la liste déroulante
    $tableauId;
    $tableauCell;
    
    foreach($dates as $date){
        $tableauId = $date['mois'];
        $tableauCell = $date['numMois']."/".$date['numAnnee'];
        echo "<option value ='".$tableauId."' selected>";
        echo $tableauCell;
        echo "</option>";
    }
?>