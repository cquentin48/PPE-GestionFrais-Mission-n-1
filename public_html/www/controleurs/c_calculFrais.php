<?php
/**
 * Page calcul frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    CHAPEL QUENTIN
 * @copyright 2017 Réseau CERTA
 * @version 1.0
 */
 
 
 /*
	@name LoadTypeFraisHorsForfaitMySQL
	@description Charge les types de coûts hors-forfait depuis une table mysql
	@author Quentin CHAPEL
	@param $typeFraisHorsForfait => Liste des types de frais hors-forfait | Array(string(K),Int(V)) | Key =>Libellé du montant | Value=>Montant du frais (VIDE)
	@version 0.5
 */
 function LoadTypeFraisHorsForfaitMySQL($typeFraisHorsForfait){
	$PDO = new PDO();
	$requetePrepare = PdoGsb::$monPdo->prepare(
		  'SELECT "libelle", "montant" '
		. 'FROM fichefrais '
    );
	while($laLigne = $requetePrepare->fetch()){
		$typeFraisHorsForfait[$laLigne['libelle']] = $laligne['montant'];
	}
 }
 /*
	@name Calcul des coûts totaux des frais hors-forfait
	@author Quentin CHAPEL
	@param $typeFraisHorsForfait => Liste des types de frais hors-forfait | Array(string(K),Int(V)) | Key =>Libellé du montant | Value=>Montant du frais
	@param $typeFraisHorsForfait => Liste des types de frais hors-forfait | Array(string(K),Int(V)) | Key =>Libellé du frais | Value=>Nombre de fois
	@return coutTotal | integer | coût total
	@version 0.5
 */
 function CalculFraisHorsForfait($typeFraisHorsForfait, $fraisHorsForfait){
	$coutTotal = 0;
	foreach($fraisHorsForfait as $keyFrais =>$nbFrais){
		foreach($typeFraisHorsForfait as $keyType =>$montantFrais){
			if($keyFrais == $keyType){
				$coutTotal = $nbFrais*$montant;
			}
		}
	}
 }
 
	
	//Tableaux
		//frais hors-forfait
		$typeFraisHorsForfait = array();
		$fraisHorsForfait = array();
	
		//frais forfait
		$fraisForfait = array();	
		
		//Total
		$coutsTotal;
		$coutTotalFraisHorsForfait;	
		$totalFraisForfait;
	
	//Chargement des coûts
	LoadTypeFraisHorsForfaitMySQL($typeFraisHorsForfait);
	//Calcul des coûts
	$coutTotalHorsForfait = CalculFraisHorsForfait($typeFraisHorsForfait,$fraisHorsForfait);
	$totalFraisForfait = CalculCoutFraisForfait($fraisForfait);
	$coutsTotal = CalculCoutTotaux($typeFraisHorsForfait,$fraisHorsForfait);
	
	//Créer liste à puces
	echo "Libellé : Validation de la fiche de frais pour ".$dateFiche.".\n";
	echo "Frais forfait : ".$totalFraisForfait.".\n";
	echo "Frais hors-forfait : ".$coutTotalHorsForfait.".\n";
	echo "Total : ".$coutsTotal.".\n";
?>