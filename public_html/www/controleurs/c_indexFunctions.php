<?php
    //Liste les fichiers en php
    $phpArray = scandir(".");
    foreach($phpArray as $key =>$array){
        //On supprime tout fichier ne comportant pas l'extension '.php'
        if(stripos($array, '.php') == false){
            $phpArray[$key] = "";
        }
    }
    
    //On inclut tout fichier php
    foreach($phpArray as $array){
        include_once $array;
    }