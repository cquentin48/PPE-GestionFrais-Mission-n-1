<?php
$max;
$i;
$delTabArray;
for ($i = 0; $i < $max; $i++) {
    foreach ($lesFraisHorsForfait as $key => $unFraisHorsForfait) {
        $date = $unFraisHorsForfait['date'];
        if ($i == $delTab) {
            $libelle = "REFUSE : " + $libelle;
        } else {
            $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
        }
        $montant = $unFraisHorsForfait['montant'];
        ?>
        <tr>
            <td><?php echo $date ?></td>
            <td><?php echo $libelle ?></td>
            <td><?php echo $montant ?></td>
            <td><?php
                $reportCheckBoxName = "checkbox" . $index;
                echo '<input id="$reportCheckBoxName" type="checkbox"/>';
                $index++;
                ?></td>
            <td><?php
                $removeCheckBoxName = "checkbox" . $index;
                echo '<input id="$checkboxValue" type="checkbox"/>';
                $index++;
                ?></td>
        </tr>
        <?php
    }
}
?>