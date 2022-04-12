
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

for($i = 0; $i < count($json_partie["zone_jeu"]); $i++) //on cherche parmi les cartes si il y en a 4 identiques
{
    $carte = $json_partie["zone_jeu"][$i];
    if($liste_id_joueurs[$i] == $json_partie["numero_joueur_actuelle"])
    {
        $json_partie["numero_joueur_actuelle"] = $liste_id_joueurs[($i + 1)%4]; //on donne la main au joueur suivant
    }
    if($carte > 0)//on récupère les cartes et on les mets dans la pioche
    {
        array_push($json_partie["pioche"],$carte); 
        $json_partie["zone_jeu"][$i] = -1; //et on remet la zone à -1
    }
}



 ?>