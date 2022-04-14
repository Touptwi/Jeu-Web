<?php

	$message = $_GET['message'];
	$id_player = $_GET['id_joueur'];
	$id_partie = $_GET['numero_partie'];
		
	$file = json_decode(file_get_contents("partie_".$id_partie.".json"), true);
    $users = json_decode(file_get_contents("utilisateurs.json"), true);
	$regle_json = json_decode(file_get_contents("fonctions_jeu/regles.json"),true);

    $user = $users[$id_partie][$id_player]["nom"];

	$message_img = explode(" ", strip_tags($message));

	foreach($message_img as $i) {
        if($i[0] == "\u00a7") {
			$carte = $regle_json[substr($i, 1)]["image"];
            $i = "<img src ='cartes_png/".$carte."'>";
        }
    }

    array_push($file["tchat"], $user.": ".implode(" ", $message_img));
	
	file_put_contents("partie_".$id_partie.".json",json_encode($file,JSON_PRETTY_PRINT));
?>