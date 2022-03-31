<?php
	$id_partie = $_GET['numero_partie'];

	$file = json_decode(file_get_contents('utilisateurs.json'), true);

	$users = $file[$id_partie];
	
echo		"<tbody>";
		foreach($users as $i) {
			$nom = $i['nom'];
			$niveau = $i['niveau'];
echo		"<td>$nom</td><td>$niveau</td><tr>";
		}
echo 	"</tbody>";
?>