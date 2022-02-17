<?php


	$nombre_type = $_GET['nb_type']; // le nombre de type

	$res = [];

	$carte = [];
	
	for ($i = 100; $i <= $nombre_type * 100; $i = $i + 100)
	{
		for($j = 1; $j <= 13 ; $j++)
		{
			$res = $i + $j;
			array_push($carte, $i + $j);
			echo "<div> $res </div>";
		}
	}



	$nombre_joueur = $_GET['nb_joueur'];
	$taille_paquet = $_GET['taille_paquet'];  
	
	shuffle($carte);
	
	for ($i = 1; $i <= $nombre_joueur; $i++)
	{
		$obj = [];
		for($j = 0; $j < $taille_paquet; $j++)
		{
			array_push($obj, array_pop($carte));
		}
		$res->$i = $obj;
	}
	
	echo json_encode(res);
	

?>
