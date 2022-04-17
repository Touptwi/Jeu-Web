<?php

    /**
     * lance une distribution des cartes selon les règles déclaré dans regles.json
     *
     * regles:
     *  "Distribution"
     *      paquets: int le nombre de paquet à realiser
     *      cartes: int le nombre de cartes par paquets
     *      melange: int indique si le paquet doit être melanger au debut de la distribution
     *                  0 pas de melange
     *                  X melange systematique avant distribution
     *
     * Pour un contrôle plus précis de la distribution il faudra directement modifer le
     * code ci dessous
     */
    function distrib($json_partie, $json_regles, &$pioche)
    {
        if(!isset($json_regles["distribution"]["melange"]) || $json_regles["distribution"]["melange"] != 0)
            {
                shuffle($pioche);
            }

        $paquet_liste = [];

        for ($nb_paquet = 0; $nb_paquet <  $json_regles["distribution"]["nb_paquets"] ; $nb_paquet ++)
        {
        $paquet = [];
        for ($i = 0; $i <  $json_regles["distribution"]["nb_cartes"] ; $i++)
        {

            $val = array_pop($pioche);
            //$pioche = array_values($pioche);
            array_push($paquet,$val);

        }
        array_push($paquet_liste,$paquet);
        }

        include("conditions_distribution.php");

        return $paquet_liste;
    }

?>
