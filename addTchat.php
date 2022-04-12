<?php

	$message = $_GET['message'];
	$id_player = $_GET['id_joueur'];
	$id_partie = $_GET['numero_partie'];
		
	$file = json_decode(file_get_contents("partie_".$id_partie.".json"), true);
    $users = json_decode(file_get_contents("utilisateurs.json"), true);

    $user = $users[$id_partie][$id_player]["nom"];

    array_push($file["tchat"], $user.": ".strip_tags($message));
	
	file_put_contents("partie_".$id_partie.".json",json_encode($file,JSON_PRETTY_PRINT));
?>