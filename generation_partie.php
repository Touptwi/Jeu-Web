<?php

$path_file = "utilisateurs.json";

$utilisateur = fopen($path_file, "r+");

if (!flock($utilisateur, LOCK_EX))
   http_response_code(409); // conflict
$jsonString = fread($utilisateur, filesize($path_file));
$json_utilisateur = json_decode($jsonString, true);

// ICI ON MODIFIE LE CONTENU COMME UN TABLEAU ASSOCIATIF
$i = 0;
$numero_partie = random_int(0,999); //on donne un indice aleatoire à la partie
if(count($json_utilisateur) > 0)
{
    $liste_id_partie = array_keys($json_utilisateur); //on récupère les indices des parties déjà créées
    while($i < count($liste_id_partie)) //on s'assure que l'indice est unique
    {
        if($numero_partie == $liste_id_partie[$i])
        {
            $numero_partie = random_int(0,999);
            $i = -1;
        }
        $i++;
    }
}
$json_utilisateur[$numero_partie] = array(); //on déclare un champs lié a la partie dans utilisateur pour permettre aux autres
                                             //joueurs de rejoindre

$newJsonString = json_encode($json_utilisateur, JSON_PRETTY_PRINT); //on sauvegarde le tout
ftruncate($utilisateur, 0);
fseek($utilisateur,0);
fwrite($utilisateur, $newJsonString);
flock($utilisateur, LOCK_UN);
fclose($utilisateur);

echo $numero_partie;

?>