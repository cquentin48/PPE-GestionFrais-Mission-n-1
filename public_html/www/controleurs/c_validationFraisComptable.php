<?php
    //Fonctions de validation de frais pour les comptables

    /**
     * Modification des frais forfaitises
     * @param type $userID l'identifiant du visiteur
     * @param type $mois le mois de la fiche de frais (format YYYYMM)
     * @param type $listeFraisForfaitises le tableau des frais forfaitisés
     */
    function modifierFicheFraisForfaitises($userID, $mois, $listeFraisForfaitises){
        //Création d'une instance de PDO GSB pour les opérations MYSQL
        $monPdo = PdoGsb::getPdoGsb();
        //On met à jour la base de donnée Mysql
        $monPdo->majFraisForfait($userID, $mois, $listeFraisForfaitises);
    }
    
    /**
     * Modification des frais forfaitises
     * @param type $userID l'identifiant du visiteur
     * @param type $mois le mois de la fiche de frais (format YYYYMM)
     * @param type $listeFraisForfaitises le tableau des frais forfaitisés
     */
    function modifierFicheFraisHF($userID, $mois, $listeFraisHF){
        //Création d'une instance de PDO GSB pour les opérations MYSQL
        $monPdo = PdoGsb::getPdoGsb();
        //On met à jour la base de donnée Mysql
        foreach($listeFraisHF as $unFraisHF){
            //Fonction de maj mysql du frais Hors-Forfait
            $monPdo->majFraisHorsForfait($userID,
                                         $unFraisHF['idFraisHF'],
                                         $mois,
                                         $unFraisHF['libelle'],
                                         $unFraisHF['date'],
                                         $unFraisHF['montant']);
        }
        
    }
    
    /**
     * Modification des frais forfaitises
     * @param type $userID l'identifiant du visiteur
     * @param type $mois le mois de la fiche de frais (format YYYYMM)
     * @param type $nbJustificatifs le nombre de frais justificatifs
     */
    function modifierFicheNbJustificatifs($userID, $mois, $nbJustificatifs){
        //Création d'une instance de PDO GSB pour les opérations MYSQL
        $monPdo = PdoGsb::getPdoGsb();
        //On met à jour la base de donnée Mysql
        $monPdo->majNbJustificatifs($userID, $mois, $nbJustificatifs);
    }
?>