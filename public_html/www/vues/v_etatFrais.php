<?php
/**
 * Vue État de Frais
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
<hr>
<div class="panel panel-primary">
    <div class="panel-heading">Fiche de frais du mois 
        <?php echo $numMois . '-' . $numAnnee ?> : </div>
    <div class="panel-body">
        <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
        depuis le <?php echo $dateModif ?> <br> 
        <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Eléments forfaitisés</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $libelle = $unFraisForfait['libelle']; ?>
                <th> <?php echo htmlspecialchars($libelle) ?></th>
                <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $quantite = $unFraisForfait['quantite']; ?>
                <td class="qteForfait"><?php echo $quantite ?> </td>
                <?php
            }
            ?>
        </tr>
    </table>
</div>
<div class="panel panel-primary" id ="tableauMajInfos" style="visibility:hidden;">
    <div class="panel-heading" id = "tableauMajInfosTitre">Information sur la fiche
        <?php echo $numMois . '-' . $numAnnee ?> : </div>
    <div class="panel-body" id ="tableauMajInfosLibelle">

    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Descriptif des éléments hors forfait - 
        <?php echo $nbJustificatifs ?> justificatifs reçus</div>
        <form action = "result.php" method = "POST">
    <table  class="table table-bordered table-responsive" id="elementsHorsForfait">
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>
            <th class='montant'>Supprimer?</th>
        </tr>
        <?php
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            $date = $unFraisHorsForfait['date'];
            $id = $unFraisHorsForfait['id'];
            $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
            $montant = $unFraisHorsForfait['montant'];
        ?>
            <tr>
                <td style="display:none;"><?php echo $id ?></td>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <td><input type = "checkbox" name = "<?php echo 'delete'.$id; ?>" id = "<?php echo 'delete'.$id; ?>"</td>
            </tr>
            <?php
        }
        ?>
        </table>
    </form>
    <div class="col-md-4">
        <input id="reporter" type="submit" value="Reporter" class="btn btn-success" onclick="reportFrais(this);"
                   role="button">
            <input id="validerFrais" type="submit" value="Confirmer les frais" class="btn btn-danger" onclick = "validerFrais(this);"
                   role="button">
    </div>
            
</div>