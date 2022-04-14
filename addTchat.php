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
        if($i[0] == "#") {
			$carte = $regle_json["cartes"][substr($i, 1)]["image"];
			if(isset($carte)) {
				$toInsert = [array_search($i, $message_img) => "<img src ='cartes_png/".$carte."'>"];
            	$message_img = array_replace($message_img, $toInsert);
			}
        }
    }

    array_push($file["tchat"], $user.": ".implode(" ", $message_img));
	
	file_put_contents("partie_".$id_partie.".json",json_encode($file,JSON_PRETTY_PRINT));
?>