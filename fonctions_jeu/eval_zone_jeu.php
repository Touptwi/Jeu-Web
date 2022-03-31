
<?php
/**
 * ce code doit être executé dans fin de tour lors du tour du serveur
 * Il doit lire le contenu de la zone de jeu est décidé quoi faire en fonction des cartes présente
 * 
 * ici, le code verifie quelle joueur a posé la carte la plus forte d'après la puissance des cartes et
 * transfert le contenu de zone de jeu dans les plis du vainqueur
 * 
 * PAS DE GESTION DES EGALITE
**/

$gagnant = 0;
$max = 0;

for($i = 0; $i < count($json_partie["zone_jeu"]); $i++) //on cherche parmi les cartes laquelle est la plus forte
{
    $carte = $json_partie["zone_jeu"][$i];
    if($json_regle["cartes"][$carte]["puissance"] > $max)
    {
        $max = $json_regle["cartes"][$carte]["puissance"];
        $gagnant = array_keys($json_partie["joueurs"])[$i]; //on récupère l'identifiant du gagnant du pli
    }
}

    //on transfert les cartes dans sa liste plis
array_push($json_partie["joueurs"][$gagnant]["plis"],$json_partie["zone_jeu"]);

for($i = 0; $i < count($json_partie["zone_jeu"]); $i++) //on remet la zone de jeu à zero
{
    $json_partie["zone_jeu"][$i] = 0;
}
$json_partie["numero_joueur_actuelle"] = $gagnant; //le gagnant est le premier joueur a jouer au prochain tour
$jons_partie ["numero_tour"] += 1;

 ?>
