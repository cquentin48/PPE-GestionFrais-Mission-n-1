/*
 * Validation de la fiche de frais
*/
/**
 * Retourne un tableau des cases à cocher cochées
 * @param {type} documentName
 * @param {type} checkBoxNameTemplate
 * @returns {undefined}
 */
function extractCheckBox(documentName,checkBoxNameTemplate){
    var checkBoxArray = array();
    var tableDocument = document.getElementById(documentName);
    alert(tableDocument.rows.length);
    var i = 0;
    for(i = 0;i<tableDocument.rows.length-1;i++){
        console.log("Tableau avec "+tableDocument.rows.length+" éléments.\n");
        alert(checkBoxName);
        if(document.getElementById(checkBoxName).checked == true){
            checkBoxArray.push(i);
        }
    }
}

/**
 * Mise à jour du libellé des élément hors-forfait avec l'inscription "Refusé"
 * @param {type} id
 * @returns {undefined}
 */
function updateTextRefused(id){
    document.getElementById("txtLibelleHF").value = "REFUSE"+ document.getElementById("txtLibelleHF").value;
}

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
function reportFrais(callback){
        var handlingDataPhpFile = "../../vues/v_MajMysqlFrais.php";
	var xhr = getXMLHttpRequest();
        var checkBoxArray = extractCheckBox("elementsHorsForfait","delete");
        
        //On retourne la clé de l'utilisateur (id dans la base de donnée)
        var selectedIndexVisiteur = document.getElementById("lstVisiteur").value;
        var selectedDate = document.getElementById("lstVisiteur").value;
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                        readData(xhr.responseText, checkBoxArray);
		}
	};

        xhr.open("POST", handlingDataPhpFile, true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.send("user_id="+selectedIndexVisiteur+"&date="+selectedDate+"&checkBoxArray="+checkBoxArray);
}

/**
 * Modifie les données
 * @author Quentin CHAPEL
 * @version 0.5
 * @param {type} sData
 */
function readData(sData) {
    var ficheHorsForfaitTab = document.getElementById("elementsHorsForfait");
    var i = 0, j = 0;
    for(i = 1;i<ficheHorsForfaitTab.rows.length;i++){
        for(j = 0; j<checkBoxArray.length;j++){
            if(i === j+1){
                //Mise à jour des données
                var libelle = ficheHorsForfaitTab.rows[i].cells[1].innerHTML;
                ficheHorsForfaitTab.rows[i].cells[1].innerHTML = "REFUSE"+libelle;
                ficheHorsForfaitTab.rows[i].cells[1].style.color = '#f00';
            }
        }
    }
}