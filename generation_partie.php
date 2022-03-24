<?php

$path_file = "utilisateurs.json";

$utilisateur = fopen($path_file, "r+");

if (!flock($utilisateur, LOCK_EX))
   http_response_code(409); // conflict
$jsonString = fread($utilisateur, filesize($path_file));
$json_utilisateur = json_decode($jsonString, true);

// ICI ON MODIFIE LE CONTENU COMME UN TABLEAU ASSOCIATIF
$i = 0;
$numero_partie = random_int(0,999);
$liste_id_partie = array_keys($json_utilisateur);
while($i < count($liste_id_partie))
{
    if($numero_partie == $liste_id_partie[$i])
    {
        $numero_partie = random_int(0,999);
        $i = -1;
    }
    $i++;
}
$json_utilisateur[$numero_partie] = array();

$newJsonString = json_encode($json_utilisateur, JSON_PRETTY_PRINT);
ftruncate($utilisateur, 0);
fseek($utilisateur,0);
fwrite($utilisateur, $newJsonString);
flock($utilisateur, LOCK_UN);
fclose($utilisateur);

echo $numero_partie;

?>