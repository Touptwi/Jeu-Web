<?php

/**
 * Ce script est exécuté dans fin_tour.php si il est déclaré comme tour_special dans
 * le fichier règles
 *
 * gère les tours de -5 à -1 et saute le tour 0
 *
 * Si le tour est à -1 il redistribue les cartes en fonction de la position des joueurs
**/

$json_partie["visibilite_zone_jeu"] = false;
$classement = [0,0,0,0];
foreach($id as $joueur)
{
  $classement[$json_partie["joueurs"][$joueur]["role"] - 1] = $joueur;
}

if( $json_partie["numero_partie"] == -1)
{
  for ($i=0; $i <count($json_partie["zone_jeu"]) ; $i++)
  {
    switch ($json_partie["joueurs"][$liste_ids_joueurs[$i]]["role"])
    {
      case 1:
        array_push($json_partie["joueurs"][$classement[3]]["main"],$json_partie["zone_jeu"][$i])
        break;
      case 2:
        array_push($json_partie["joueurs"][$classement[2]]["main"],$json_partie["zone_jeu"][$i])
        break;
      case 3:
        array_push($json_partie["joueurs"][$classement[1]]["main"],$json_partie["zone_jeu"][$i])
        break;
      case 4:
        array_push($json_partie["joueurs"][$classement[0]]["main"],$json_partie["zone_jeu"][$i])
        break;
      default:
        array_push($json_partie["tchat"],"[ARBITRE]: IL semblerait que je me sois emmêlé les pinceaux. Je m'en excuse.")
        break;
      $json_partie["zone_jeu"][$i] = -1;
    }
  }
}
?>
