<?php

	$id_party = $_GET['numero_partie'];

	$file = json_decode(file_get_contents("utilisateurs.json"), true);
	
	unset($file[$id_party][$_COOKIE["id_player"]]);

	if($_COOKIE["id_player"] > 1000) {
		unset($file[$id_party]);
	}

	setcookie("id_player", "", time() - 3600);

	file_put_contents("utilisateurs.json",json_encode($file,JSON_PRETTY_PRINT));

?>