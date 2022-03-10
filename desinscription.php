<?php

	$nom = $_GET['nom'];
	
	$element = array('nom' => $nom);
	
	$file = json_decode(file_get_contents("utilisateurs.json"), true);
	
	foreach ($file as $key => $value) {
		if ($value['nom'] == $nom) {
           	unset($file[$key]);
        }
    }
	
	file_put_contents("utilisateurs.json",json_encode($file,JSON_PRETTY_PRINT));
?>
