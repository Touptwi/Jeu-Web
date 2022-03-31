<?php

	$id_party = $_GET['numero_partie'];
	$id_player = $_COOKIE["id_player"];

	$file = json_decode(file_get_contents("utilisateurs.json"), true);
	
	unset($file[$id_party][$id_player]);

	if($id_player > 1000 && isset($file[$id_party][$id_player])) {
		unset($file[$id_party]);
	}

	setcookie("id_player", "", time() - 3600);

	file_put_contents("utilisateurs.json",json_encode($file,JSON_PRETTY_PRINT));

?>