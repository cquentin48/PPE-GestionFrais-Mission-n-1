<?php
//Cas de la mise à jour de la liste des mois en fonction de l'identifiant de l'utilisateur
if (isset($_GET['operation'])) {

    if (isset($_GET['user_id']) && $_GET['operation'] == 'loading_date') {
        //On retourne la liste des mois en fonction de l'identifiant du visiteur
        $lesMois = $pdo->getLesMoisDisponibles($_GET['user_id']);
        ?>
        <label for="lstMois" accesskey="n">Mois : </label>
        <select id="lstMois" name="lstMois" class="form-control">
            <?php
            if (count($lesMois) == 0) {//S'il n'y a aucune fiche de frais pour le visiteur
                ?><option selected>Aucune fiche de frais!</option>
        <?php
            } else {//Sinon
                foreach ($lesMois as $unMois) {
                    $mois = $unMois['mois'];
                    $numAnnee = $unMois['numAnnee'];
                    $numMois = $unMois['numMois'];
                    if ($mois == $moisASelectionner) {
                        ?>
                        <option selected value="<?php echo $mois ?>">
                            <?php echo $numMois . '/' . $numAnnee ?> </option>
                        <?php
                    } else if ($visiteurSelectionnee < 0) {
                        ?>
                        <option selected value="<?php echo $mois ?>" disabled>
                            <?php echo 'Aucun visiteur sélectionné!' ?> </option>
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
        <?php
        //Chargement des fiches de frais
    } else if (isset($_GET['user_id']) && isset($_GET['date']) && $_GET['operation'] == 'loading_expense_sheet') {
        
    }
} else {
    echo "<script>console.log( 'Erreur: " . "pas d'opéation trouvée!" . "' );</script>";
}
?>