<?php
    //Récupération du type d'opération
    $operationType = $_POST['operationType'];
    //Récupération de l'identifiant visiteur et le mois
    $userID = $_POST['userId'];
    $mois = $_POST['mois'];
    //Parcours du type d'opération
    switch($operationType){
        case "majFraisForfaitises":
            //Récupération de la liste au format JSON du tableau des frais forfaitisés
            $listeFraisForfaitises = json_decode($_POST['listeFraisForfaitises']);
            //Maj des frais forfaitisés => Le résultat affiche les détails de l'opération
            $resultat = modifierFicheFraisForfaitises($userID, $mois, $listeFraisForfaitises);
        break;
    
        case "majFraisHF":
            //Récupération de la liste au format JSON du tableau des frais forfaitisés
            $listeFraisHF = json_decode($_POST['listeFraisHFJSON']);
            //Maj des frais hors-forfait => Le résultat affiche les détails de l'opération
            $resultat = modifierFicheFraisHF($userID, $mois, $listeFraisHF);
        break;
    
        case "majNbJustificatifs":
            //Récupération du nombre de justificatifs
            $nbJustificatif = $_POST['nbJustificatifs'];
            //Maj du nombre de justificatifs => Le résultat affiche les détails de l'opération
            $resultat = modifierFicheNbJustificatifs($userID, $mois, $listeFraisHF);
        break;
    }
?>