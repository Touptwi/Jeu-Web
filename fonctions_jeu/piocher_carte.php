<?php

$regle = json_decode(file_get_contents("regles.json"),true);

$numero_partie = $_GET["numero_partie"];
$id_joueur = $_GET["id_joueur"];
$path_file = "../partie_" . $numero_partie . ".json";


$partie = fopen($path_file, "r+");

if (!flock($partie, LOCK_EX))
   http_response_code(409); // conflict
$jsonString = fread($partie, filesize($path_file));
$json_partie = json_decode($jsonString, true);

// ICI ON MODIFIE LE CONTENU COMME UN TABLEAU ASSOCIATIF

    if($json_partie["numero_joueur_actuelle"] == $id_joueur) //si c'est au tour du joueur
    {
        array_push($json_partie["joueurs"][$id_joueur]["main"],array_pop($json_partie["pioche"]));
    }

$newJsonString = json_encode($json_partie, JSON_PRETTY_PRINT);
ftruncate($partie, 0);
fseek($partie,0);
fwrite($partie, $newJsonString);
flock($partie, LOCK_UN);
fclose($partie);

?>