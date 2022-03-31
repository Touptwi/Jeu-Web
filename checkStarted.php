<?php
	$id_partie = $_GET['numero_partie'];
    $id_player = $_GET['id_joueur'];

	$file = json_decode(file_get_contents('utilisateurs.json'), true);

	if(file_exists("partie_"+$id_partie+".json")) {
		if(isset($file[$id_partie])) {
			$users = array_keys($file[$id_partie]);
			if($users!=NULL) {
				foreach($users as $id) {
					if($id==$id_player) {
echo    	            "true";
        	            return;
        	        }
				}
			}
		}
	}
echo "false";
?>