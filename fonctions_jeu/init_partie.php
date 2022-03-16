<?php
/**
 * cree le fichier json lié a une partie
 * paramètre attendue:
 * numero_partie: le numero de la partie
 */

$numero_partie = $_GET['numero_partie'];

$json_partie = json_decode(file_get_contents('../partie_' . $numero_partie.'.json'),true);

//distribution sera ensuite paramétrée par le fichier rules.json

$pioche = [];
for ($i = 100; $i<= 400; $i = $i + 100)
{
    for($j = 0; $j <= 13; $j++)
    {
        array_push($pioche, $i + $j);
    }

}
shuffle($pioche);
////////////////////////////////////////////////////////////

$json_partie['pioche'] = $pioche;

$liste_mains = [];
for($i = 0; $i < count($json_partie["joueurs"]);$i++)
{
  $json_partie["joueurs"][$i]["main"] = [];
  $json_partie["joueurs"][$i]["plis"] = [];
}
$json_partie['zone_jeu'] = [];


file_put_contents('../partie_'. $numero_partie.'.json', json_encode($json_partie,JSON_PRETTY_PRINT));

?>
