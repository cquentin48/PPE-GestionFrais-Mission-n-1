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
 * Annule toutes les opérations que l'utilisateur du site souhaite retirer
 * 
 */
function cancelFrais(){
	var xhr = getXMLHttpRequest();
        var page = "";
        
        //Elements de la maj des données
        var date = $_POST['date'];
        var userId = $_POST['visiteurId'];
        var casescoches = returnCheckBoxList("delete");
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			callback(xhr.responseText);
		}
	};
	
        //Chargement dans la page de mise à jour
	xhr.open("POST", page, true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.send("date="+date+"&userId="+userId+"reports="+casescoches);
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
        document.getElementById("tableauMajInfos").style.visibity = 'visible';
        document.getElementById("tableauMajInfosTitre").innerHTML += " : mise à jour des fiches hors-forfait"
        document.getElementById("tableauMajInfosLibelle").innerHTML = " éléments ont été supprimés."
}

/**
 * Retourne la liste des cases à cocher
 * @param {type} list template pour le nom des cases à cocher
 * @returns {returnCheckBoxList.checkedBoxTab} le tableau des cases cochées
 */
function returnCheckBoxList(list){
    var i = 0;
    var checkedBoxTab = array();
    for(i = 0;i<list.size;i++){
        if(document.getElementById(list+i).checked == true){
            checkedBoxTab.push(list+i);
        }
    }
    return checkedBoxTab;
}