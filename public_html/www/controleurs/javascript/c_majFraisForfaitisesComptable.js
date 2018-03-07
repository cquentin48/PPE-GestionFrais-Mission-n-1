//Fonctions gestion javascript
/**
 * @author Sébastien et Johann Pardannaud (openclassroom)
 * @returns {ActiveXObject|XMLHttpRequest}
 */
function getXMLHttpRequest() {
	var xhr = null;
	
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest(); 
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}
	
	return xhr;
}
/**
 * Mettre à jour les frais forfaitisés
 * 
 */
function majFraisForfaitisesComptable(){
	var xhr = getXMLHttpRequest();
        var page = "../../vues/v_validationFraisComptable.php";
        
        //Import de la liste déroulante du mois
        var moisDropDownList = document.getElementById("lstVisiteur");
        //Retour de l'élement sélectionné
        var selectedMois = moisDropDownList[moisDropDownList.selectedIndex].value;
        //Liste déroulante de la liste des visiteurs
        var visiteurDropDownList = document.getElementById("lstVisiteur");
        //Element sélectionné
        var selectedVisiteur = visiteurDropDownList.options[visiteurDropDownList.selectedIndex].value;
        //Découpage de l'identifiant utilisateur par le groupe de caractères " - "
        var idVisiteur = selectedVisiteur.split(" - ");
        
        //Retourner la liste des frais forfaitises
        var list = returnFraisForfaitises();
        
        var operationType = "majFraisForfaitises";
        
        //Encode au format JSON de la liste des frais forfaitisés
        var listeFraisForfaitisesJSON = JSON.stringify(list);
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			callback(xhr.responseText);
		}
	};
	
        //Chargement dans la page de mise à jour
	xhr.open("POST", page, true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        //Envoie des données au format POST
	xhr.send("operationType="+operationType+"&userId="+idVisiteur[1]+"&mois="+selectedMois+"&listeFraisForfaitises="+listeFraisForfaitisesJSON);
}


/**
 * Modifie les données du tableau des élements de frais hors-forfait sur la page "Mes fiches de frais"
 * @author Quentin CHAPEL
 * @version 0.5
 * @param {type} sData
 */
function readData(sData) {
        //On met à jour les données
        document.getElementsByClassName("table table-bordered table-responsive").innerHTML = sData;
        
        //On met à jour la fenêtre d'information
            //Affiche le tableau
        /*document.getElementById("tableauMajInfos").style.visibity = 'visible';
        document.getElementById("tableauMajInfosTitre").innerHTML += " : mise à jour des fiches hors-forfait";
        document.getElementById("tableauMajInfosLibelle").innerHTML = " éléments ont été supprimés.";*/
}

/**
 * Retourne la liste des cases à cocher
 * @returns {list} le tableau de valeurs des frais hors-forfait
 */
function returnFraisForfaitises(){
    var list = [];
    list['ETP'] = document.getElementByName('lesFrais[ETP]');
    list['KM'] = document.getElementByName('lesFrais[KM]');
    list['NUI'] = document.getElementByName('lesFrais[NUI]');
    list['REP'] = document.getElementByName('lesFrais[REP]');
    return list;
}