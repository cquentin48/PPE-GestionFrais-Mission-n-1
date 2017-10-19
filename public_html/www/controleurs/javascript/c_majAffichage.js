/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Mise à jour du libellé des élément hors-forfait avec l'inscription "Refusé"
 * @param {type} id
 * @returns {undefined}
 */
function updateTextRefused(id){
    document.getElementById("txtLibelleHF").value = "REFUSE"+ document.getElementById("txtLibelleHF").value;
}