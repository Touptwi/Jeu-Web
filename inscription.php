<?php

	$nom = $_GET['nom'];
	$niveau = $_GET['niveau'];
	//$numero = $_GET['numero'];
	
	$file = json_decode(file_get_contents("utilisateurs.json"), true);

	$file[] = ['nom' => $nom, 'niveau' => $niveau];
	
	file_put_contents("utilisateurs.json",json_encode($file,JSON_PRETTY_PRINT));
	
	//session_start();
	
	//$_SESSION['numero'] = $numero; 
	
echo		'<input type="Button" value="Leave" onclick="leave()">';
?>
