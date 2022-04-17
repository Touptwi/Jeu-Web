<?php

$id_joueur = $_GET["id_joueur"];
$numero_partie = $_GET["numero_partie"];
$path_file = "../partie_".$numero_partie.".json";

$json_partie_file = fopen($path_file,"r+");

if (!flock($json_partie_file, LOCK_EX)) //on verouille le fichier
    http_response_code(409); // conflict

$jsonString = fread($json_partie_file, filesize($path_file));
$json_partie = json_decode($jsonString, true);//on recupère le plateau de jeu en associative array

if($id_joueur == $json_partie["numero_joueur_actuel"])
{
    $liste_ids_joueurs = array_keys($json_partie["joueurs"]);
    $stop = false;
    $i = 0;
    while( !$stop && $i < count($liste_ids_joueurs))
    {
        if($liste_ids_joueurs[$i] == $id_joueur)
        {
            $stop = true;
        }else{
            $i++;
        }
    }
    if($json_partie["zone_jeu"][$i] >= 0)
    {
        array_push($json_partie["joueurs"][$id_joueur]["main"],$json_partie["zone_jeu"][$i]);
        $json_partie["zone_jeu"][$i] = -1;
    }
}

$newJsonString = json_encode($json_partie, JSON_PRETTY_PRINT);//on encode
ftruncate($json_partie_file, 0);//on vide
fseek($json_partie_file,0);//on se place au début
fwrite($json_partie_file, $newJsonString);//sauvegarde les changements
flock($json_partie_file, LOCK_UN);//libère le fichier
fclose($json_partie_file);//et on le ferme

?>
