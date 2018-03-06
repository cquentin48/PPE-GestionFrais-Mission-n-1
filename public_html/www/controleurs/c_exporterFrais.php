<?php
/**
 * Gestion de l'exportation des fichiers PDF
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
if($_SESSION == null){
    session_start();
}
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = $_SESSION['idVisiteur'];
$ficheFrais = $pdo->getFichesValides($idVisiteur);//On retourne les fiches valides de l'utilisateur
include 'vues/v_exportationPDF.php';
?>