<?php

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents("../partie_".$_GET['numero_partie'].".json"),true);

$result = array();


$result["pioche"] = count($data["pioche"]);
$result["zone_jeu"] = $data["zone_jeu"];
$result["adversaire"] = array();
for($i = 0; $i < count($data["joueurs"]); $i++)
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
