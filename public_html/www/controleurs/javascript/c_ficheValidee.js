/* 
 * Here comes the text of your license
 * Each line should be prefixed with  * 
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
 * Met à jour les fiches de frais
 */
function validerFrais(callback){
    if(confirm("Confirmer la validation de la fiche de frais?")){
        var handlingDataPhpFile = "../../vues/v_ValidationFrais.php";
	var xhr = getXMLHttpRequest();
        
        //On retourne la clé de l'utilisateur (id dans la base de donnée)
        var selectedIndexVisiteur = document.getElementById("lstVisiteur").value;
        var selectedDate = document.getElementById("lstMois").value;
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                        updateData(xhr.responseText);
		}
	};

        xhr.open("POST", handlingDataPhpFile, true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.send("user_id="+selectedIndexVisiteur+"&date="+selectedDate);        
    }
}

/**
 * Modifie les données
 * @author Quentin CHAPEL
 * @version 0.5
 * @param {type} sData le texte affiché pour la mise à jour des données
 */
function validateFees(sData) {
    var operationInfoTableId = document.getElementById("tableauMajInfos");
    //Affichage de la table de résultat
    operationInfoTableId.style.visibility='visible';
    document.getElementById("tableauMajInfosLibelle").innerHTML = sData;
}