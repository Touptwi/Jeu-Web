<?php
/**
 * Recupère la première carte de la pioche et la place dans la main du joueur
 * Parametres:
 * numero_partie; l'indice de la partie
 * id_joueur: l'indice du joueur
 *
 * /!\ Il n'y a aucune limite sur cette fonctionalité. Un joueur peut donc piocher tant qu'il reste des cartes dans la pioche
 */

$json_regle = json_decode(file_get_contents("regles.json"),true);

$numero_partie = $_GET["numero_partie"];
$id_joueur = $_GET["id_joueur"];
$path_file = "../partie_" . $numero_partie . ".json";


$partie = fopen($path_file, "r+");

if (!flock($partie, LOCK_EX))
   http_response_code(409); // conflict
$jsonString = fread($partie, filesize($path_file));
$json_partie = json_decode($jsonString, true);

// ICI ON MODIFIE LE CONTENU COMME UN TABLEAU ASSOCIATIF

    if($json_partie["numero_joueur_actuel"] == $id_joueur) //si c'est au tour du joueur
    {
        if(count($json_partie["pioche"]) > 0)
            array_push($json_partie["joueurs"][$id_joueur]["main"],array_pop($json_partie["pioche"]));

    }

$newJsonString = json_encode($json_partie, JSON_PRETTY_PRINT);
ftruncate($partie, 0);
fseek($partie,0);
fwrite($partie, $newJsonString);
flock($partie, LOCK_UN);
fclose($partie);
?>
