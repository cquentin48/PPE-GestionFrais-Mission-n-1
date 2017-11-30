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
                            <select id="lstVisiteur" name="lstVisiteur" class="form-control" onchange=<!--"majMois(readData);"-->>
                                <option value ='-1' selected>
                                    Choisir un visiteur
                                </option>
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
                            <label for="lstMois" accesskey="n">Mois : </label>
                            <select id="lstMois" name="lstMois" class="form-control">
                                <?php
                                    foreach ($lesMois as $unMois) {
                                        $mois = $unMois['mois'];
                                        $numAnnee = $unMois['numAnnee'];
                                        $numMois = $unMois['numMois'];
                                        if ($mois == $moisASelectionner) {
                                            ?>
                                            <option selected value="<?php echo $mois ?>">
                                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                                            <?php
                                        }
                                        else if($_SESSION['visiteurSelectionne']==-1){
                                            ?>
                                            <option selected value="<?php echo $mois ?>" disabled>
                                                <?php echo 'Aucun visiteur sélectionné!' ?> </option>
                                            <?php
                                        }else {
                                            ?>
                                            <option value="<?php echo $mois ?>">
                                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                                            <?php
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
            <input id="reporter" type="submit" value="Reporter" class="btn btn-danger"<!--Initialement en mode "invisible"--> 
                   role="button">
        </form>
    </div>
</div>