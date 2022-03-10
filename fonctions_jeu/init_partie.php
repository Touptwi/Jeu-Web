<?php
/**
 * cree le fichier json lié a une partie
 * paramètre attendue:
 * numero_partie: le numero de la partie
 */

$numero_partie = $_GET['numero_partie'];

$json_partie = json_decode(file_get_contents('../partie_' . $numero_partie.'.json'),true);

$pioche = [];
for ($i = 100; $i<= 400; $i = $i + 100)
{
    for($j = 0; $j <= 13; $j++)
    {
        array_push($pioche, $i + $j);
    }
    
}
shuffle($pioche);

foreach($pioche as $i)
    echo $i;
$json_partie['pioche'] = $pioche;

foreach($json_partie['joueurs'] as $j)
{
    array_push($json_partie['main_joueur'],[]);
}
$json_partie['zone_jeu'] = [];


file_put_contents('../partie_'. $numero_partie.'.json', json_encode($json_partie,JSON_PRETTY_PRINT));  

?>