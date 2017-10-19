<?php

	/*
		@author Quentin CHAPEL
		@name Report au mois Prochain
		@description reporte au mois prochain un frais hors forfait
	*/
	function reportFacture($date, $id){
		//Extraction du mois et de l'ann�e du frait hors forfait
		$annee = intval(substr($date,0,4));
		$mois = intval(substr($date,3,2));
		
		//Incr�mentation du mois
		$mois++;
		
		//Mise � jour du mois et de l'ann�e
		if($mois == 13){//Au-del� des 12 mois...
			$mois = 1;//Le mois est alors mis � janvier
			$annee++;//On ajoute une ann�e
		}
		
		//Mise � jour du champs "mois" de la table lignefraishorsforfait
			//Si le mois est avant Octobre
		if($mois<10){
			$date = $annee+"0"+$mois;
		}
		else{
			$date = $annee+$mois;
		}
		//Ajouter ici la requ�te de mise � jour
	}

	/*
		@author Quentin CHAPEL
		@name Calcul des �lements forfaitis�s
		@version 1.0
		@description Retourne le co�t des �l�ments forfaitis�s
		
		@param $ETP Le nombre de forfait d'�tapes
		@param $KM Les frais kilom�trique
		@param $NUI Les nuit�es d'h�tel
		@param $REP Les repas restaurant
		
		@return co�t total des �l�ments forfaitis�s
	*/
	function calculElementsForfaitises($ETP, $KM, $NUI, $REP){
		return ($ETP*110)+($KM*0.60)
						 +($NUI*80)
						 +($REP*25);
	}
	
	/*
		Calcul des �lements forfaitis�s
		
		@author Quentin CHAPEL
		@version 1.0
		@description Retourne le co�t des �l�ments forfaitis�s
		
		@param $coutForfaitise Les co�ts forfaitis�s
		@param $couthorsforfait Les co�t hors-forfaits
		
		@return co�t total du mois pour le visiteur
	*/
	function calculCoutTotal($coutForfaitise, $couthorsforfait){
		return $coutForfaitise+$couthorsforfait;
	}
?>