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

//si un joueur n'a plus de cartes à la fin de son tour et qu'il ne reste plus qu'un joueur en lice
if(count($json_partie["joueurs"][$json_partie["numero_joueur_actuel"]]["main"]) == 0 && $json_partie["position_generale"] >= 4)
{
    if(!include("fonctions_jeu/fin_partie.php"))//on essaie de fermer la partie ou de la relancer
    {
      return false;
    }
}

if(!isset($json_partie["carte_max"])) //en cas de problème dans l'initialisation on redéclare ce champ
{
    $json_partie["carte_max"] = -1;
}

//on récupère la case associé au joueur actuelle dans la zone de jeu
$id = 0;
$liste_id_joueurs = array_keys($json_partie["joueurs"]);
while($json_partie["numero_joueur_actuel"] != $liste_id_joueurs[$id])
{
    $id++;
}


if( $json_partie["zone_jeu"][$id] >= 1) //si le joueur a joué une carte
{
    $carte_jouée = $json_regle["cartes"][$json_partie["zone_jeu"][$id]]["puissance"]; //on récupère la puissance de la carte jouée

    if( $json_partie["identique"] >= 2 && $carte_jouée != $json_partie["carte_max"])//si les 2 cartes précedentes étaient identique et que le joueur n'a pas joué la même
    {
      array_push($json_partie["tchat"],"[ARBITRE]: Quand 2 cartes identiques sont jouées à la suite vous devez jouer une carte identique ou ne rien jouer");
      return false;
    }

    if($carte_jouée < $json_partie["carte_max"])//si la carte que l'on a joué est plus faible que la carte_max
    {
        array_push($json_partie["tchat"],"[ARBITRE]: ".$json_partie["joueurs"][$json_partie["numero_joueur_actuel"]]["nom"]." vous devez absolument jouer une carte supérieure ou égale à la précédente");
        echo "arrêt";
        return false; //on ne termine pas le tour

    }else{
        if($carte_jouée == $json_partie["carte_max"])//si la carte est la même que le joueur précédent
        {
            $json_partie["identique"]++;
        }else{
            $json_partie["identique"] = 1; //sinon on le réinitialise
        }
        $json_partie["carte_max"] = $carte_jouée;//sinon on met la carte_max à jour
    }

    if($json_regle["cartes"][$json_partie["zone_jeu"][$id]]["puissance"] == 14) //si le joueur a joué un 2
    {
        echo "2 posé";
        $json_partie["identique"] = 0;//on remet à zéro le compte de cartes identiques
        $json_partie["carte_max"] = 0;
        $json_partie["numero_tour"] = 4; //on passe le tour à celui du dernier joueur
        $json_partie["numero_joueur_actuel"] = $liste_id_joueurs[abs(($id-1)%4)];
    }

    if(count($json_partie["joueurs"][$id_joueur]["main"]) == 0)
    {
      $json_partie["joueurs"][$id_joueur]["position"] = $json_partie["position_generale"];
      $json_partie["position_generale"] = $json_partie["position_generale"] + 1;
    }
}else{
  $json_partie["identique"] = 0;
}
?>
