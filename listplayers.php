<?php
	$id_partie = $_GET['numero_partie'];

	$file = json_decode(file_get_contents('utilisateurs.json'), true);

echo		"<tbody>";

	if(!isset($file[$id_partie])) {
echo	"<td>PARTIE INEXISTANTE</td><tr>";
	} else {
		$users = $file[$id_partie];
		if($users!=NULL) {
			foreach($users as $i) {
				$nom = $i['nom'];
				$niveau = $i['niveau'];
echo			"<td>$nom</td><td>$niveau</td><tr>";
			}
		} else {
echo		"<td>PARTIE VIDE</td><tr>";
		}
	}

echo 	"</tbody>";
?>