/*
 * Validation de la fiche de frais
 */
/**
 * Retourne un tableau des cases à cocher cochées
 * @param {type} documentName le nom du tableau
 * @param {type} checkBoxNameTemplate le prototype du nom des cases à cocher (sans l'indice)
 * @return {type} la liste des cases cochées
 */
function extractCheckBox(documentName, checkBoxNameTemplate) {
    var checkBoxArray = [];
    var tableDocument = document.getElementById(documentName);
    //Indice maximal de l'identifiant des frais hors-forfait de la fiche du mois en cours
    var indiceMax = tableDocument.rows.length - 1;
    //Compteur pour la boucle for ci-dessous
    var i = 0;
    alert(indiceMax);
    for (i = 1; i <= indiceMax; i++) {
        var indiceDelete = tableDocument.rows[i].cells[0].innerHTML;
        var checkBoxName = checkBoxNameTemplate + indiceDelete;
        console.log("Tableau avec " + tableDocument.rows.length - 1 + " éléments.\n");
        if (document.getElementById(checkBoxName).checked) {
            //On ajoute l'élément à la liste
            checkBoxArray.push(tableDocument.rows[i].cells[0].innerHTML);
        }
    }
    return checkBoxArray;
}

function getXMLHttpRequest() {
    var xhr = null;

    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
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
function reportFrais(callback) {
    var handlingDataPhpFile = "../../vues/v_MajMysqlFrais.php";
    var xhr = getXMLHttpRequest();
    var checkBoxArray = extractCheckBox("elementsHorsForfait", "delete");

    //On retourne la clé de l'utilisateur (id dans la base de donnée)
    var selectedIndexVisiteur = document.getElementById("lstVisiteur").value;
    var selectedDate = document.getElementById("lstMois").value;

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            updateData(xhr.responseText, checkBoxArray);
        }
    };

    xhr.open("POST", handlingDataPhpFile, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("user_id=" + selectedIndexVisiteur + "&date=" + selectedDate + "&checkBoxArray=" + checkBoxArray);
}

/**
 * Modifie les données
 * @author Quentin CHAPEL
 * @version 0.5
 * @param {type} sData
 * @param {type} checkBoxArray la liste des cases cochées pour le report des fiches hors-forfait
 */
function updateData(sData, checkBoxArray) {
    var ficheHorsForfaitTab = document.getElementById("elementsHorsForfait");
    var i = 0, j = 0;
    if (typeof checkBoxArray != 'undefined') {
        for (i = 1; i < ficheHorsForfaitTab.rows.length; i++) {
            for (j = 0; j < checkBoxArray.length; j++) {
                if (i === checkBoxArray[j]) {
                    //Mise à jour des données
                    var libelle = ficheHorsForfaitTab.rows[i].cells[1].innerHTML;
                    console.log("Opération : hors-forfait " + ficheHorsForfaitTab.rows[i].cells[1].innerHTML + " reporté au mois suivant.")
                    ficheHorsForfaitTab.rows[i].cells[2].innerHTML = "REFUSE : " + libelle;
                    ficheHorsForfaitTab.rows[i].cells[2].style.color = '#f00';
                }
            }
        }
    }

    var operationInfoTableId = document.getElementById("tableauMajInfos");

    //Affichage de la table de résultat
    operationInfoTableId.style.visibility = 'visible';
    document.getElementById("tableauMajInfosLibelle").innerHTML = sData;
}