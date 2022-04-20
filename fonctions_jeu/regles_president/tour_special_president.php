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
$i = 0;
foreach($id as $joueur)
{
  if($joueur == $id_joueur && $json_partie["zone_jeu"][$i] == -1)//si le joueur n'a pas joué de cartes;
  {
    return false;
  }
  $classement[$json_partie["joueurs"][$joueur]["role"] - 1] = $joueur;
  $i++;
}

$json_partie["numero_tour"]++; //on incrémente le tour de jeu

if( $json_partie["numero_partie"] == -1)//si tous les joue
{
  for ($i=0; $i <count($json_partie["zone_jeu"]) ; $i++)
  {
    switch ($json_partie["joueurs"][$liste_ids_joueurs[$i]]["role"])
    {
      case 1:
        array_push($json_partie["joueurs"][$classement[3]]["main"],$json_partie["zone_jeu"][$i]);
        break;
      case 2:
        array_push($json_partie["joueurs"][$classement[2]]["main"],$json_partie["zone_jeu"][$i]);
        break;
      case 3:
        array_push($json_partie["joueurs"][$classement[1]]["main"],$json_partie["zone_jeu"][$i]);
        break;
      case 4:
        array_push($json_partie["joueurs"][$classement[0]]["main"],$json_partie["zone_jeu"][$i]);
        break;
      default:
        array_push($json_partie["tchat"],"[ARBITRE]: IL semblerait que je me sois emmêlé les pinceaux. Je m'en excuse.");
        break;
    }
    $json_partie["zone_jeu"][$i] = -1;
  }
  $json_partie["numero_tour"] = 1;
}else{//dans les autres cas
  //on retrouve l'id du joueur actuel
  $i = 0;
  while($id[$i] != $id_joueur)
  {
    $i++;
  }
  //on donne la main au suivant
  $json_partie["numero_joueur_actuel"] = $id[$i+1%4];
}
?>
