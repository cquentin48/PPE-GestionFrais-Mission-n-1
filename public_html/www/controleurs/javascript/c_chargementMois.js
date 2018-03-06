/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
 * Met à jour les mois 
 */
function majMois(callback){
        var handlingDataPhpFile = "../../vues/v_MajMysql.php";
	var xhr = getXMLHttpRequest();
        
        //On retourne la clé de l'utilisateur (id dans la base de donnée)
        var selectedIndex = document.getElementById("lstVisiteur").value;
        var valeur = document.getElementById("lstMois").value;
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                        /*var text = */readData(xhr.responseText);
                        
		}
	};

	xhr.open("POST", handlingDataPhpFile, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	xhr.send("user_id=" + selectedIndex+"&operation='loading_date'");
}

/**
 * Modifie les données
 * @author Quentin CHAPEL
 * @version 0.5
 * @param {type} oData
 */
function readData(oData) {
        //On met à jour les données
        var updateForm = document.getElementById("lstMois");
        updateForm.innerHTML = oData;
}