
<?php
/**
 * NECESSAIRE AU FONCTIONNEMENT DE LA PARTIE
 * ce code est executé dans fin_tour.php lors du tour du serveur
 * Il doit lire le contenu de la zone de jeu est décidé quoi faire en fonction des cartes présente
 * Parametres:
 *  AUCUN
 * Objets Accessibles:
 *  $json_regles (lecture uniquement): un tableau associatif contenant l'ensemble des données de regles.json
 *  $json_partie (lecture/ecriture): tableau associatif contenant l'etat du plateau de jeu
 *
 * ici, le code vérifie si une carte est présente en 3 exemplaire. SI c'est le cas alors on remet la carte différente
 * dans la main du joueur.
 *
 *
 *
 *
 *
 * PAS DE GESTION DES EGALITE
**/

$liste_id_joueurs = array_keys($json_partie["joueurs"]);
$compte_vide = 0;
for($i = 0; $i < count($json_partie["zone_jeu"]); $i++)//on parcourts les cases de la zone de jeu
{
    $carte = $json_partie["zone_jeu"][$i];
    if($liste_id_joueurs[$i] == $json_partie["numero_joueur_actuel"])//si
    {
        $json_partie["numero_joueur_actuel"] = $liste_id_joueurs[($i + 1)%4]; //on donne la main au joueur suivant
    }
    if($carte >= 0)//on récupère les cartes et on les mets dans la pioche
    {
        array_push($json_partie["pioche"],$carte);
        $json_partie["zone_jeu"][$i] = -1; //et on remet la zone à -1
    }else{
      $compte_vide ++;
    }
}
if($compte_vide >= 4)
{
    $json_partie["tchat"] = array_push($json_partie["tchat"],"[ARBITRE]: personne n'a pu jouer vous pouvez donc recommencer une série");
    $json_partie["carte_max"] = 0;
}



 ?>
