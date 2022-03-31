<?php
	$id_partie = $_GET['numero_partie'];
    $id_player = $_GET['id_player'];

	$file = json_decode(file_get_contents('utilisateurs.json'), true);

	if(isset($file[$id_partie])) {
		$users = array_keys($file[$id_partie]);
		if($users!=NULL) {
			foreach($users as $i) {
				if($i==$id_player) {
echo                "true";
                    return;
                }
			}
echo        "false";
		}
	}
?>