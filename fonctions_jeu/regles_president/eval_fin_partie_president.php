<?php

/**
 * Ce script est exécuté dans le fichier fin_partie.php et indique quelles sont les conditions pour que la partie
 * se termine
 * 
 * VARIABLES ATTENDUES:
 *  -Aucune
 * 
 * VARIABLES ACCESSIBLES:
 *  - Toutes les variables du fichier appelant (au minimum)
 *  - $chemin: le chemin menant au fichier de la partie
 */

include("fonctions_jeu/distribution.php");

if($json_partie["nombre_manche"] > 0) //si il reste des manche on relance la partie
{
    //TODO METTRE UNE OUVERTURE FERMETURE DE FICHIER PROPRE 
    $json_partie = json_decode(file_get_contents($chemin),true);
    
    $json_partie["nombre_partie"] = $json_partie["nombre_partie"] - 1;
    
    if($json_partie["position_generale"] > 3)
    {
        foreach(array_keys($json_partie["joueurs"]) as $joueur)
        {
            if($json_partie["joueurs"][$joueur]["position"] = 0) //si un joueur n'a pas de position ie il lui reste des cartes
            {
                
                while(count ($json_partie["joueurs"][$joueur]["main"]) == 0)
                {
                    $carte = array_pop($json_partie["joueurs"][$joueur]["main"]);
                    array_push($json_partie["pioche"],$carte);
                }
                $json_partie["joueurs"][$joueur]["role"] = $json_partie["position_generale"]; //on met a jour le role du joueur directement
                
            }else{
                $json_partie["joueurs"][$joueur]["role"] = $json_partie["joueurs"][$joueur]["position"]; //on met à jour son rôle
                $json_partie["joueurs"][$joueur]["position"] = 0; //et on remet sa position à 0
            }
        }
        $json_partie["position_generale"] = 1; //on reinit la position générale à 1
        distrib($json_partie,$json_regles,$joueurs["pioche"]);

    }else if(isset($json_partie["joueurs"][$id_joueurs]["position"]))//si le joueur n'as pas de position on lui attribue 
    {
        $json_partie["joueurs"][$id_joueurs]["position"] = $json_partie["position_generale"]; //on lui attribue la position_generale (la carte courante)
        $json_partie["position_generale"] = $json_partie["position_generale"] + 1; //on incrémente la position_generale de 1
    }

    
    return; //on annule la fin de partie

} //dans le cas contraire on termine la partie correctement

?>