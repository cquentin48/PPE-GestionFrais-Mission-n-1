<?php
    //Changement de contexte : la page devient pdf
    require_once '../includes/class.pdf.inc.php';//Inclusion de la classe pdf pour la génération du fichier pdf
    require_once '../includes/fct.inc.php';
?>
<?php
/**
 * Gestion de l'exportation des fichiers PDF
 *
 * PHP Version 7
 *
 */
    if(!isset($_SESSION)){
        session_start();
    }
    $arrayIndexName = "exportPDF";
    $i = 0;
    $arrayIndexExportPDF = createIndexArrayExport($_POST,$arrayIndexName);
    
    //Récupération des données
    $idVisiteur = $_SESSION['idVisiteur'];
    $nomComplet = $_SESSION['nom']." ".$_SESSION['prenom'];
    
    //Création du fichier pdf
    $PDF = new PDF($arrayIndexExportPDF, $idVisiteur, $nomComplet);
?>