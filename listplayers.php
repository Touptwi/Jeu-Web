<?php
	$users = json_decode(file_get_contents('utilisateurs.json'));
echo		"<tbody>";
	
		foreach($users as $i) {
			$nom = $i -> nom;
			$niveau = $i -> niveau;
echo		"<td>$nom</td><td>$niveau</td><tr>";
		}
echo 	"</tbody>";
?>