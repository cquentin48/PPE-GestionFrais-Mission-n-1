<?php
/**
 * Vue Liste des mois
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
?>
<script type="text/javascript" src="../controleurs/javascript/c_ficheValidee.js"></script>
<script type="text/javascript" src="../controleurs/javascript/c_reportFrais.js"></script>
<script type="text/javascript" src="../controleurs/javascript/c_ChargementMois.js"></script>
<h2>Mes fiches de frais</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un mois : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=etatFrais&action=voirEtatFrais" 
              method="post" role="form">
            <table>
                <tr>
                    <td>
                        <div id = "form-group-visiteur" class="form-group">
                            <label for="lstVisiteur" accesskey="n">Visiteur : </label>
                            <select id="lstVisiteur" name="lstVisiteur" class="form-control" onchange ="majMois(this);">
                                <option value ='-1' selected>
                                    Choisir le visiteur :
                                </option>
                                <!--Ajouter ici l'id du visiteur sélectionné-->
                                <?php
                                    foreach ($lesVisiteurs as $key => $unVisiteur) {
                                        ?><option value="<?php echo $key;?>">
                                            <?php echo $unVisiteur;?>
                                        </option>
                                <?php    }
                                ?>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div id ="form-group-mois" class="form-group">
                                <!--Ajouter ici l'id du mois sélectionné en plus de la liste-->
                            <label for="lstMois" accesskey="n">Mois : </label>
                            <select id="lstMois" name="lstMois" class="form-control">
                                <?php
                                if($_SESSION['comptable']==0){
                                    foreach ($lesMois as $unMois) {
                                        $mois = $unMois['mois'];
                                        $numAnnee = $unMois['numAnnee'];
                                        $numMois = $unMois['numMois'];
                                        if ($mois == $moisASelectionner) {
                                            ?>
                                            <option selected value="<?php echo $mois ?>">
                                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo $mois ?>">
                                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </td>
                </tr>
            </table>
            <input id="ok" type="submit" value="Valider" class="btn btn-success"
                   role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
                   role="button">
        </form>
    </div>
</div>