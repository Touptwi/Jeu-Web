<?php

	$nom = $_GET['nom'];
	$niveau = $_GET['niveau'];
	$id_partie = $_GET['numero_partie'];

	$id_player = random_int(1,999);
		
	$file = json_decode(file_get_contents("utilisateurs.json"), true);

	if($file[$id_partie] == []) {
		$id_player += 1000;
	}

	setcookie("id_player", $id_player, time() + 2*3600);

	$file[$id_partie][$id_player] = ['nom' => strip_tags($nom), 'niveau' => strip_tags($niveau)];
	
	file_put_contents("utilisateurs.json",json_encode($file,JSON_PRETTY_PRINT));

?>