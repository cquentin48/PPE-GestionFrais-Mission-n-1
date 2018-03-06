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
 * Met à jour les fiches de frais
 */
function majMois(callback){
        var handlingDataPhpFile = "../../vues/v_MajMysqlFrais.php";
	var xhr = getXMLHttpRequest();
        
        //On retourne la clé de l'utilisateur (id dans la base de donnée)
        var selectedIndexVisiteur = document.getElementById("lstVisiteur").value;
        var selectedDate = document.getElementById("lstVisiteur").value;
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                        readData(xhr.responseText);
		}
	};

        xhr.open("POST", handlingDataPhpFile, true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.send("user_id="+selectedIndexVisiteur+"&date="+selectedDate);
}

/**
 * Modifie les données
 * @author Quentin CHAPEL
 * @version 0.5
 * @param {type} sData
 */
function readData(sData) {
    var ficheHorsForfaitTab = document.getElementById("table table-bordered table-responsive");
    //Tableau des cases cochées
    var listeCasesCochees;
    var i = 0, j = 0;
    for(i; i<ficheHorsForfaitTab.rows.length;i++){
        for(j;j<listeCasesCochees.size;j++){
            if(i === j){
                //On ajoute le texte "Reporte : " au début du libellé
                ficheHorsForfaitTab.rows[i].cells[1].innerHTML = "REPORTE : "+ficheHorsForfaitTab.rows[i].cells[1].innerHTML;
                
                //On met en rouge
                ficheHorsForfaitTab.rows[i].cells[1].style.color = "#FF0000";
            }
        }
    }
    ficheHorsForfaitTab.innerHTML = sData;
}