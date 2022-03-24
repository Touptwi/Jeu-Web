<?php

$gagnant = 0;
$max = 0;

for($i = 0; $i < count($json_partie["zone_jeu"]); $i++) //on cherche parmi les cartes laquelle est la plus forte
{
    $carte = $json_partie["zone_jeu"][$i];
    if($json_regle["cartes"][$carte]["puissance"] > $max)
    {
        $max = $json_regle["cartes"][$carte]["puissance"];
        $gagnant = array_keys($json_partie["joueurs"])[$i]; //on récupère l'identifiant du gagnant du pli
    }
}

    //on transfert les cartes dans sa liste plis
array_push($json_partie["joueurs"][$gagnant]["plis"],$json_partie["zone_jeu"]);

for($i = 0; $i < count($json_partie["zone_jeu"]); $i++)
{
    $json_partie["zone_jeu"][$i] = 0;
}
$json_partie["numero_joueur_actuelle"] = $gagnant;
$jons_partie ["numero_tour"] += 1;

 ?>
