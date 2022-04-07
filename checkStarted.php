<?php
	$id_partie = $_GET['numero_partie'];
    $id_player = $_GET['id_joueur'];

	$file = json_decode(file_get_contents('utilisateurs.json'), true);

	if(file_exists("partie_".$id_partie.".json")) {
echo	"true";
    	return;
	}
echo "false";
?>