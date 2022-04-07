<?php
/**
 * Est appelé par init_partie
 * C'est ici qu'on verifie des règles sur la distribution
 * Objets Accessibles:
 *   $paquet_liste : la liste des paquets créer par la distribution
 */

for($i = 0; $i < count($paquet_liste); $i++)
{
    for($j = 0; $j < count($paquet_liste[$i]); $j++)
    {
        if($paquet_liste[$i][$j] == null)
        {
            include("fin_partie.php");
        }
    }

}


?>
