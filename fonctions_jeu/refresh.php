<?php

header('Content-Type: application/json; charset=utf-8');

$id_joueur = $_GET["id_joueur"];
$numero_partie = $_GET["numero_partie"];

$data = json_decode(file_get_contents("../partie_".$numero_partie.".json"),true);
$regle_json = json_decode(file_get_contents("regles.json"),true);



$result = array();


$result["numero_joueur_actuel"] = $data["numero_joueur_actuel"];
$result["nom_joueur"] = $data["joueurs"][$id_joueur]["nom"];
$result["pioche"] = count($data["pioche"]);
$result["zone_jeu"] = [];

foreach($data["zone_jeu"] as $carte)
{
  if($carte >= 0 && ($data["visibilite_zone_jeu"] == true || !isset($data["visibilite_zone_jeu"]) )) //si rien n'est indiqué ou que le plateau est marqué visible
    array_push($result["zone_jeu"],$regle_json["cartes"][$carte]["image"]); // on transmet les cartes au joueur
  else
    array_push($result["zone_jeu"],$regle_json["cartes"][0]["image"]);//sinon on ne transmet que des dos de cartes
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
