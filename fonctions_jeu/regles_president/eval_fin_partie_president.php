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

$presence_debutant = false

foreach ($json_partie["joueurs"] as $joueur) {
  arra_push($json_partie["tchat"],"[ARBITRE]: classement:");
  arra_push($json_partie["tchat"],$joueur["nom"].": "$joueur["role"]);
  if ($joueur["niveau"] == "D\u00e9butant")
  {
    $presence_debutant = true;
  }
}

if($json_partie["nombre_manche"] > 0) //si il reste des manche on relance la partie
{
    //pas d'ouverture nécessaire car déjà effectuer dans fin_tour ou le script est appelé

    $json_partie["nombre_manche"] = $json_partie["nombre_manche"] - 1;

    array_push($json_partie["tchat"],"[ARBITRE]: tour d'échange de cartes:");
    if($presence_debutant)
    {
      array_push($json_partie["tchat"],"[ARBITRE]: le joueur 1 donne sa pire carte au joueur 4 et 4 donne ça meilleur à 1. De même pour 2 et 3 ");
    }
    if($json_partie["position_generale"] > 3)
    {
        foreach(array_keys($json_partie["joueurs"]) as $joueur)//pour chaque joueur
        {
            if($json_partie["joueurs"][$joueur]["position"] = 0) //si un joueur n'a pas de position ie il lui reste des cartes
            {
                while(count ($json_partie["joueurs"][$joueur]["main"]) != 0)
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
        distrib($json_partie,$json_regles,$joueurs["pioche"]);//on redistribue les cartes
        $json_partie["numero_tour"] = -5; //on lance une série de tour spéciaux
        $json_partie["numero_joueur_actuel"] = array_keys($json_partie["joueurs"])[0]; //en commençant par le joueur 0
    }
    return false; //on annule la fin de partie
} //dans le cas contraire on termine la partie correctement

?>
