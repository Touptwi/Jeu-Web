<?php

	$nom = $_GET['nom'];
	$niveau = $_GET['niveau'];
	//$numero = $_GET['numero'];
	
	$element = array('nom' => $nom, 'niveau' => $niveau);
	
	$file = json_decode(file_get_contents("utilisateurs.json"));
	
	array_push($file,$element);
	
	file_put_contents("utilisateurs.json",json_encode($file,JSON_PRETTY_PRINT));
	
	//session_start();
	
	//$_SESSION['numero'] = $numero; 
	

?>
