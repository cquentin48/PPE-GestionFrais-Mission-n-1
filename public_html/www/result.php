<?php
    $_POST['date'] = "201610";
    $_POST['idVisiteur'] = "a3";
    echo "<pre>";
    print_r($_POST);
    for($i = 0; $i<3;$i++){
        echo "name = "."\"delete".$i."\"\n";
    }
    
    foreach($_POST as $delKey => $delId){
        if(substr($delKey,0,6) == "delete")
        $delIdArray[substr($delKey,6,1)] = $delId;
    }
    $date = "";
    if(substr($_POST['date'], 4, 2)<12){//Pas fin d'année
        $date = $_POST['date']+1;
    }else{
        $date = substr($_POST['date'],0,4)."01";
    }
    print_r($delIdArray);
    $sqlRequest = "update lignefraishorsforfait"."\n".
                  "set `mois` = "."'".$date."'"."\n".
                  "where `mois` = "."'".$_POST['date']."'"."\n".
                  "AND `id` IN (0";
    if(count($delIdArray)>1){
        foreach($delIdArray as $delKey =>$delId){
            $sqlRequest.= ",".$delKey;
        }
    }
    $sqlRequest .= ")";
    $sqlRequest .= "\nAND `idvisiteur` = "."'".$_POST['idVisiteur']."'";
    echo $sqlRequest;
?>