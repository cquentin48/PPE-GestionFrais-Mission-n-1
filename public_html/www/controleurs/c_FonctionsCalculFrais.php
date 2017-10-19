<?php

	/*
		@author Quentin CHAPEL
		@name Report au mois Prochain
		@description reporte au mois prochain un frais hors forfait
	*/
	function reportFacture($date, $id){
		//Extraction du mois et de l'année du frait hors forfait
		$annee = intval(substr($date,0,4));
		$mois = intval(substr($date,3,2));
		
		//Incrémentation du mois
		$mois++;
		
		//Mise à jour du mois et de l'année
		if($mois == 13){//Au-delà des 12 mois...
			$mois = 1;//Le mois est alors mis à janvier
			$annee++;//On ajoute une année
		}
		
		//Mise à jour du champs "mois" de la table lignefraishorsforfait
			//Si le mois est avant Octobre
		if($mois<10){
			$date = $annee+"0"+$mois;
		}
		else{
			$date = $annee+$mois;
		}
		//Ajouter ici la requête de mise à jour
	}

	/*
		@author Quentin CHAPEL
		@name Calcul des élements forfaitisés
		@version 1.0
		@description Retourne le coût des éléments forfaitisés
		
		@param $ETP Le nombre de forfait d'étapes
		@param $KM Les frais kilométrique
		@param $NUI Les nuitées d'hôtel
		@param $REP Les repas restaurant
		
		@return coût total des éléments forfaitisés
	*/
	function calculElementsForfaitises($ETP, $KM, $NUI, $REP){
		return ($ETP*110)+($KM*0.60)
						 +($NUI*80)
						 +($REP*25);
	}
	
	/*
		Calcul des élements forfaitisés
		
		@author Quentin CHAPEL
		@version 1.0
		@description Retourne le coût des éléments forfaitisés
		
		@param $coutForfaitise Les coûts forfaitisés
		@param $couthorsforfait Les coût hors-forfaits
		
		@return coût total du mois pour le visiteur
	*/
	function calculCoutTotal($coutForfaitise, $couthorsforfait){
		return $coutForfaitise+$couthorsforfait;
	}
?>