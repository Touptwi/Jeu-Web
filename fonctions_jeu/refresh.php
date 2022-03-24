<?php

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents("../partie_".$_GET['numero_partie'].".json"),true);

$result = array();

$result["numero_joueur_actuelle"] = $data["numero_joueur_actuelle"];
$result["pioche"] = count($data["pioche"]);
$result["zone_jeu"] = $data["zone_jeu"];
$result["adversaire"] = array();
foreach(array_keys($data["joueurs"]) as $i)
{
  if($i == $_GET["id_joueur"])
  {
    $result["main_joueur"] =  $data["joueurs"][$i]["main"];
  }else{
    $main = $data["joueurs"][$i]["main"];
    if($main == [])
      $result["adversaire"][$i] = 0;
    else
      $result["adversaire"][$i] = count($main);
  }
}
echo json_encode($result);
 ?>
