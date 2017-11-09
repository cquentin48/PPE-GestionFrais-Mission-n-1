<table class="table table-bordered table-responsive">
    <tr>
        <th class="date">Date</th>
        <th class="libelle">Libellé</th>
        <th class='montant'>Montant</th>                
        <th class='montant'>Supprimer?</th>
    </tr>
    <?php
    $delNumber = $_POST['delNumber'];
    foreach ($lesFraisHorsForfait as $key => $unFraisHorsForfait) {
        $date = $unFraisHorsForfait['date'];
        $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
        $montant = $unFraisHorsForfait['montant'];
        ?>
        <tr>
            <td><?php echo $date ?></td>

            <td>
                <?php
                if (in_array($key, $_POST['delNumber'])) {//S'il s'agit d'un élément reporté
                    echo "REFUSE : ";
                }
                echo $libelle;
                ?>
            </td>
            <td><?php echo $montant ?></td>
            <td><input type = "checkbox" name = "<?php echo 'delete' . $delNumber; ?>" id = "<?php echo 'delete' . $delNumber; ?>" <?php $delNumber++; ?></td>
        </tr>
        <?php
    }
    ?>
    <input type = "submit" value = "Envoyer"> 
</table>