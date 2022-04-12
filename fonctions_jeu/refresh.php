<?php

header('Content-Type: application/json; charset=utf-8');

$id_joueur = $_GET["id_joueur"];
$numero_partie = $_GET["numero_partie"];

$data = json_decode(file_get_contents("../partie_".$numero_partie.".json"),true);
$regle_json = json_decode(file_get_contents("regles.json"),true);



$result = array();

/*Système de notification: */
/*
  Lorsque un element du jeu lance une notification au joueur, celui ci l'indique dans un champs spécial du json. Il indique alors
  - la liste des joueurs concernés
  - le fichier de code a executé pour ces joueurs
  - Le fichier de code produisant le message par defaut pour les autres joueurs
*/

if(isset($data["notification"]) && $data["notification"] != []) //si la partie a généré un champ notification dans le json alors on regarde la notification sur le dessus de la pile
{
  if(in_array($id_joueur,$data["notification"][0]["cible"])) //si le joueur est mentionné dans les cibles alors on envoie le contenu à celui-ci
  {
    $result["notification"] = $data["notification"][0]["contenu"];
  }else{
    $result["notification"] = $data["notification"][0]["defaut"]; //sinon on affiche un message par defaut.
  }
}

$result["numero_joueur_actuelle"] = $data["numero_joueur_actuelle"];
$result["pioche"] = count($data["pioche"]);
$result["zone_jeu"] = [];

foreach($data["zone_jeu"] as $carte)
{
  if($carte >= 0)
    array_push($result["zone_jeu"],$regle_json["cartes"][$carte]["image"]);
}

$result["adversaire"] = array();
foreach(array_keys($data["joueurs"]) as $i)
{
  if($i == $id_joueur)
  {
    //$result["main_joueur"] =  $data["joueurs"][$i]["main"];
    $result["main_joueur"] = [];
    foreach($data["joueurs"][$i]["main"] as $carte)
    {
      array_push($result["main_joueur"],$regle_json["cartes"][$carte]["image"]);
    }
  }else{
    $main = $data["joueurs"][$i]["main"];
    $result["adversaire"][$i]["nom"] = $data["joueurs"][$i]["nom"];
    if($main == [])
      $result["adversaire"][$i]["nb_cartes"] = 0;
    else
      $result["adversaire"][$i]["nb_cartes"] = count($main);
  }
}

$result["tchat"] = $data["tchat"];

echo json_encode($result);
 ?>
