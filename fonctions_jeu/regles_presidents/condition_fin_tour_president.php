<?php
/**
 * Ce fichier est lancé dans le fichier fin_tour.php. Il indique les règles a respecter pour autoriser le 
 * joueur à terminer son tour.
 * PARAMETRE ATTENDU:
 *  - Aucun
 * 
 * OBJET ACCESSIBLES:
 *  - $json_regles [lecture seul]: le contenu du fichier regles.json
 *  - $json_partie [lecture/ecriture]: le contenu du fichier partie_XXX.json
 * 
 * Version président:
 * LE joueur ne peut terminer son tour que si il a joué une carte et que celle-ci est supérieur ou égale à l'ensemble
 * des cartes présente dans la zone de jeu. De plus, si le joueur joue un deux et que celui-ci est valide
 * 
 * Si un joueur n'a plus de carte à la fin de son tour, on passe met a jour son classemement
 * une fois ce classement mis à jour il n'est plus modifié jusqu'à la fin de la partie
 */

if(!isset($json_partie["carte_max"]))
{
    $json_partie["carte_max"] = -1;
}

$id = 0;
$liste_id_joueurs = array_keys($json_partie["joueurs"]);
while($json_partie["numero_joueur_actuelle"] != $liste_id_joueurs[$id])
{
    $id++;
}


if( $json_partie["zone_jeu"][$id] >= 1) //si le joueur a joué une carte 
{
    $carte_jouée = $json_regles["cartes"][$json_partie["zone_jeu"][$i]]["puissance"]; //on récupère la puissance de la carte jouée

    if( $json_partie["identique"] >= 2 && $carte_jouée != $json_partie["carte_max"])//si les 2 cartes précedentes étaient identique et que le joueur n'a pas joué la même
    {
        return;//on ne termine pas le tour
    }

    if($carte_jouée < $json_partie["carte_max"])//si la carte que l'on a joué est plus faible que la carte_max
    {
        return; //on ne termine pas le tour

    }else{
        $json_partie["carte_max"] = $carte_jouée;//sinon on met la carte_max à jour
        if($carte_jouée == $json_partie["carte_max"])//si la carte est la même que le joueur précédent
        {
            $json_partie["identique"]++; 
        }else{
            $json_partie["identique"] = 1;
        }
    }
}

if($json_regles["cartes"][$json_partie["zone_jeu"][$id]][puissance] == 2) //si le joueur a joué un 2
{
    $json_partie["identique"] = 0;//on remet à zéro le compte de cartes identiques
    $json_tour["numero_tour"] = 4; //on passe le tour à celui du dernier joueur
}

?>