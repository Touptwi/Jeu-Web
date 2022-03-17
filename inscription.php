<?php

	$nom = $_GET['nom'];
	$niveau = $_GET['niveau'];

	$id_player = random_int(1,999);
		
	$file = json_decode(file_get_contents("utilisateurs.json"), true);

	if(sizeof($file) == 0) {
		$id_player += 1000;
	}

	setcookie("id_player", $id_player, time() + 2*3600,);

	$file[$id_player] = ['nom' => $nom, 'niveau' => $niveau];
	
	file_put_contents("utilisateurs.json",json_encode($file,JSON_PRETTY_PRINT));

?>