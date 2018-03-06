<?php
/**
 * Vue Exportation PDF
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
<script type="text/javascript" src="../controleurs/javascript/c_exportPDF.js"></script>

<h2>Mes fiches de frais</h2>
<form method ="POST" action = "vues/v_exportPDF.php">
    <div id = "">
        <table border="1" id = "tableExportPDF">
            <thead>
                <tr>
                    <th>Mois de la fiche</th>
                    <th>Exporter?</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($ficheFrais as $cle => $uneFiche) {
                    ?>
                    <td><?php echo $uneFiche['mois'];?></td>
                    <td>
                        <input type="checkbox" name ="exportPDF<?php echo $cle ?>" value="ON" />
                    </td>            
                    <?php
                }
                    ?>
                    <tr>
                        <td>
                            <input type="text" name="fileOutPutLocationPDF" value="" />
                        </td>
                        <td>
                            <input id="ok" type="submit" value="Valider" class="btn btn-success" role="button"/>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
</form>