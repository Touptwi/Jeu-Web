<?php

/**
 * cette fonction peut être appeler n'importe quand
 * elle provoque le calcul des scores (selon la methode déclarer dans regles) et supprime la partie en renvoyant les joueurs sur la page welcom.html
 * Objets Accessibles:
 * numero_partie: le numero de la partie a supprimer
 */
        $chemin = "../partie_".$numero_partie.".json";
        echo $chemin;
        
        if (isset($json_regle["eval_fin_partie"]) && $json_regle["eval_fin_partie"] != "")
            include($json_regle["eval_fin_partie"]);
        if(file_exists($chemin))
        {
            unlink($chemin);
        }else{
            echo "merde";
        }
        return null;



 ?>