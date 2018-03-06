/* 
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */

/**
 * Crée un objet request utilisé pour les requêtes AJAX
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
 * Crée un fichier pdf
 */
function exportPDF(callback){
        var handlingDataPhpFile = '../../vues/v_exportPDF.php';
	var xhr = getXMLHttpRequest();
        
        var exportPDFIndex = returnCheckBoxList("exportPDF");
        var jSONARRAYExportPDFIndex = JSON.stringify(exportPDFIndex);
        
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                        var text = readData(xhr.responseText);
		}
	};

	xhr.open("POST", handlingDataPhpFile, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	xhr.send("exportPDFIndex=" + jSONARRAYExportPDFIndex);
}

/**
 * Modifie les données
 * @author Quentin CHAPEL
 * @version 0.5
 * @param {type} oData
 */
function readData(oData) {
    console.log(oData);
}

/**
 * Retourne la liste des cases à cocher
 * @param String list template pour le nom des cases à cocher
 * @returns {returnCheckBoxList.checkedBoxTab} le tableau des cases cochées
 */
function returnCheckBoxList(list){
    var i = 0;
    var indiceMax = document.getElementById("tableExportPDF").rows.length-1;
    var checkedBoxTab = new Array();
    for(i = 0;i<indiceMax;i++){
        if(document.getElementById(list+i).checked == true){
            checkedBoxTab.push(document.getElementById("tableExportPDF").rows[i+1].cells[0].innerHTML);
        }
    }
    if(checkedBoxTab.length == 0){
        alert("Veuillez sélectionner au moins un élément pour l'export des fiches.");
    }
    return checkedBoxTab;
}