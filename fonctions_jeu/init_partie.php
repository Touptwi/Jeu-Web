<?php
/**
 * cree le fichier json lié a une partie
 * paramètre attendue:
 * numero_partie: le numero de la partie
 */

$numero_partie = $_GET['numero_partie'];

$json_utilisateurs = json_decode(file_get_contents("../utilisateurs.json"),true);

$json_partie = json_decode(file_get_contents('../partie_' . $numero_partie.'.json'),true);

$json_regles = json_decode(file_get_contents("regles.json"),true);

$json_partie["joueurs"] = $json_utilisateurs;

echo $json_partie["joueurs"];

//la distribution 

$pioche = [];
$carte = array_keys($json_regles["cartes"]);

foreach ($carte as $val)
{
        array_push($pioche, $val);

}
shuffle($pioche);

$regle_distribution = $json_regles["distribution"];
$paquet_liste = [];

for ($nb_paquet = 0; $nb_paquet < $regle_distribution["nb_paquets"] ; $nb_paquet ++)
{
  $paquet = [];
  for ($i = 0; $i < $regle_distribution["nb_cartes"] ; $i++)
  {
    $val = array_pop($pioche); 
    array_push($paquet,$val);
  }
  array_push($paquet_liste,$paquet);
}
////////////////////////////////////////////////////////////

$json_partie['pioche'] = $pioche;

$liste_mains = [];

$nb_joueurs = count($json_partie["joueurs"]);


$json_partie['zone_jeu'] = [];
for($i = 0; $i < $nb_joueurs ;$i++)
{
  $json_partie["joueurs"][$i]["main"] = $paquet_liste[$i];
  $json_partie["joueurs"][$i]["plis"] = [];
  array_push($json_partie['zone_jeu'],0);
}



file_put_contents('../partie_'. $numero_partie.'.json', json_encode($json_partie,JSON_PRETTY_PRINT));

?>
