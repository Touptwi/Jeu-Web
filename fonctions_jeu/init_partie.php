<?php
  include("distribution.php");
/**
 * cree le fichier json lié a une partie
 * paramètre attendue:
 * numero_partie: le numero de la partie
 */

$numero_partie = $_GET['numero_partie'];
$id_joueur = $_GET['id_joueur'];

if($id_joueur <= 1000)
{
  return;
}

$json_utilisateurs_liste = json_decode(file_get_contents("../utilisateurs.json"),true);//on récupère les utilisateurs
$json_utilisateurs = $json_utilisateurs_liste[$numero_partie];
//echo json_encode($json_utilisateurs,JSON_PRETTY_PRINT);
if (file_exists('../partie_' .$numero_partie.'.json')) //si la partie existe déjà on écrasera le fichier existant
{
  $json_partie = json_decode(file_get_contents('../partie_' .$numero_partie.'.json'),true);
}else{
  $json_partie = array();
}

$json_regles = json_decode(file_get_contents("regles.json"),true);

$json_partie["joueurs"] = $json_utilisateurs; //on récupère la liste des utilisateurs

$json_partie["numero_joueur_actuelle"] = $id_joueur;
$json_partie["numero_tour"] = 1;

//la distribution

$pioche = [];


foreach (array_keys($json_regles["cartes"]) as $val) //on génère les cartes d'après le fichier de règles
{
  if($val > 0)
  array_push($pioche, $val);
}
shuffle($pioche);

$paquet_liste = distrib($json_partie,$json_regles,$pioche); //appel a la fonction de distribution du fichier distribution.php

////////////////////////////////////////////////////////////

$json_partie['pioche'] = $pioche;

$json_partie['zone_jeu'] = [];
$numero_paquet = 0;

foreach (array_keys($json_partie["joueurs"]) as $i ) { //on distribue les paquets créer lors de la distribution aux joueurs
  $json_partie["joueurs"][$i]["main"] = $paquet_liste[$numero_paquet];
  $json_partie["joueurs"][$i]["plis"] = [];
  array_push($json_partie['zone_jeu'],-1); //on génère une zone de jeu pour chaque joueur

  $numero_paquet++;
}


$json_partie["notification"] = [];


file_put_contents('../partie_'. $numero_partie.'.json', json_encode($json_partie,JSON_PRETTY_PRINT));
echo "Init log: ecriture du fichier reussi";
//DEBUG

chmod('../partie_' . $numero_partie.'.json',0777); //permet la modification du fichier partie à la main

?>
