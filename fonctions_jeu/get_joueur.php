<?php
/**
 * va récupérer un numero de joueur et rendre la lliste des noms des joueurs
 * paramètres attendu:
 * numero_partie: le numero de partie
 * nom joueur/numero de joueur:
 */

 $numero_partie = $_GET['numero_partie'];

 $json_partie = json_decode(file_get_contents('partie_'.$numero_partie));

 $result = array();

 $liste_joueurs = array_keys($j->joueurs); 
 foreach( $liste_joueurs as $joueurs )
 {
     array_push($result, $joueurs);
 }

 echo $result;

?>