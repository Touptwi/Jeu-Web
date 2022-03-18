<?php

	$file = json_decode(file_get_contents("utilisateurs.json"), true);
	
	unset($file[$_COOKIE["id_player"]]);

	setcookie("id_player", "", time() - 3600);

	file_put_contents("utilisateurs.json",json_encode($file,JSON_PRETTY_PRINT));

?>