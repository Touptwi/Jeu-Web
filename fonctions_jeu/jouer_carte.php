<?php
/**
 * déplace une carte de la main du joueur vers la zone de jeu
 * Parametres Attendu:
 * numero_partie: l'indice de la partie
 * id_joueur: l'indice du joueur
 * id_carte: l'indice de la case de la carte a placé dans le tableau main du joueur
 */

$json_regle = json_decode(file_get_contents("regles.json"),true);

$numero_partie = $_GET["numero_partie"];
$id_joueur = $_GET["id_joueur"];
$id_carte = $_GET["id_carte"];
$path_file = "../partie_" . $numero_partie . ".json";


$partie = fopen($path_file, "r+");

if (!flock($partie, LOCK_EX))
   http_response_code(409); // conflict
$jsonString = fread($partie, filesize($path_file));
$json_partie = json_decode($jsonString, true);

// ICI ON MODIFIE LE CONTENU COMME UN TABLEAU ASSOCIATIF

    if($json_partie["numero_joueur_actuelle"] == $id_joueur) //si c'est au tour du joueur
    {
        $joueur = $json_partie["joueurs"][$id_joueur];

        $carte = $joueur["main"][$id_carte];
        if (array_key_exists($json_regle["cartes"][$id_carte]["on_play"])) //si la carte possède des règles particulières a effectuer lorsque elle est joué
        {
            include($json_regle["cartes"][$id_carte]["regles_speciales"]);
        }
        echo $carte;

        unset($json_partie["joueurs"][$id_joueur]["main"][$id_carte]); //retire la carte de la main du joueur
        $json_partie["joueurs"][$id_joueur]["main"] = array_values($json_partie["joueurs"][$id_joueur]["main"]); //reorganise la main

        /*if ($json_partie["zone_jeu"][$id_joueur] != 0)
        {
            array_push($json_partie["joueurs"][$id_joueur]["main"],$json_partie["zone_jeu"][$id_joueur]);
        }*/

        
        $id = 0;
        $liste_joueurs = array_keys($json_partie["joueurs"]); 

        for($i = 0; $i < count($liste_joueurs); $i++)
        {
            if ($liste_joueurs[$i] == $id_joueur)
            {
                if($json_partie["zone_jeu"][$i] != 0)
                {
                    array_push($json_partie["joueurs"][$id_joueur]["main"],$json_partie["zone_jeu"][$i]);//si une carte etait déjà joué, la remet dans la main du joueur avant de mettre la nouvelle
                }
                $json_partie["zone_jeu"][$i] = $carte; //on place la carte dans l'emplacement ayant le même numero que l'ordre d'arrivée des joueurs
            }
        }

    }

$newJsonString = json_encode($json_partie, JSON_PRETTY_PRINT);
ftruncate($partie, 0);
fseek($partie,0);
fwrite($partie, $newJsonString);
flock($partie, LOCK_UN);
fclose($partie);



?>
