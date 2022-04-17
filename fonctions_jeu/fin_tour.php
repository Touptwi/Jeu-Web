<?php

  /**
   * Parametre attendu:
   *  numero_partie: le numero de la json_partie
   *
   * Système de tour:
   * LE fichier json_partie contient deux champs (numero_joueur_actuelle et numero_tour) seul le joueur dont l'indice
   * est indiqué dans le champ numero_joueur_actuelle a le droit de joueur des cartes ou de terminer un tour
   *
   * lorsque fin de tour est appelé, elle incremente le numero de tour de 1 et passe au joueurs suivant dans la liste
   * les des joueurs.
   *
   * Les numero de tour normaux sont compris entre 1 et 4, le tour 0 est le tour du serveur. C'est durant ce tour
   * que le plateau de jeu est évalue et qu'il
   *
   * Les champs eval_zone_jeu et condition_fin_tour indique les codes a exécuter respectivement lors du tour du serveur
   * et lorsqu'un joueur indique la fin de son tour.
   * /!\ SI UN DE CES SCRIPTS APPELLE RETURN LA FIN DE TOUR NE TERMINE ET LA MAIN N'EST PAS PASSE AU JOUEUR SUIVANT
   *
   *
   * numero_tour est toujours compris entre 0 et 4, 0 indiquant un tour serveur
   */

  $json_regle = json_decode(file_get_contents("regles.json"),true);

  $path_file = "../partie_".$_GET["numero_partie"].".json";

  $json_partie = fopen($path_file,"r+");



  if (!flock($json_partie, LOCK_EX)) //on verouille le fichier
     http_response_code(409); // conflict
  $jsonString = fread($json_partie, filesize($path_file));
  $json_partie = json_decode($jsonString, true);//on recupère le plateau de jeu en associative array

  //lors d'un tour classique (serveur ou joueur)
  //si definit, appel le fichier indiquant les conditions pour pouvoir finir son tour
  //si aucun fichier n'est defini dans regles.json alors le joueur peut finir son tour sans avoir joué
  if($json_partie["numero_tour"] >= 0 && isset($json_regle["condition_fin_tour"]) && $json_regle["condition_fin_tour"] != "")
  {
    include($json_regle["condition_fin_tour"]);
  }


  $json_partie["numero_tour"] = ($json_partie["numero_tour"] + 1)%5;//on incrémente de 1 le tour de jeu
  if ($json_partie["numero_tour"] > 0)//si le tour de jeu n'est pas a 0 (le tour du serveur) ni un tour special (< 0)
  {
    $ids_joueurs = array_keys($json_partie["joueurs"]);//on récupère la liste des indices des joueurs
    if ($json_partie["numero_joueur_actuelle"] == 0) //si le dernier joueur est le serveur
    {
      $json_partie["numero_joueur_actuelle"] = $ids_joueurs[0];//on met le numero_joueur_actuelle sur le premier joueur
    }else{
      $i = 0;
      $continue = true;
      while($continue&&$i < count($ids_joueurs))//on parcourt la liste des identifiants de joueurs
      {
        if($ids_joueurs[$i] == $json_partie["numero_joueur_actuelle"])//on choisit l'identifiant suivant du joueur actuelle et on arrete la boucle
        {
          $continue = false;
          $json_partie["numero_joueur_actuelle"] = $ids_joueurs[($i+1)%count($ids_joueurs)];//on donne la main au joueur suivant
        }
        $i++;
      }

    }
  }else if ($json_partie["numero_tour"] == 0){//si c'est le tour du serveur
    include($json_regle["eval_zone_jeu"]); //on execute l'evaluation du terrain de jeu

    for($i = 0; $i < count($json_partie["zone_jeu"]); $i++) //on remet la zone de jeu à zero
    {
      $json_partie["zone_jeu"][$i] = -1;
    }

    $jons_partie ["numero_tour"] += 1;
  }else{
    if(isset($json_regle["tour_special"]) && $json_regle["tour_special"] != "")
    {
      include($json_regle["tour_special"])
    }
    $jons_partie ["numero_tour"] += 1;
  }

  $newJsonString = json_encode($json_partie, JSON_PRETTY_PRINT);//on encode
  ftruncate($json_partie, 0);
  fseek($json_partie,0);
  fwrite($json_partie, $newJsonString);//sauvegarde les changements
  flock($json_partie, LOCK_UN);//libère le fichier
  fclose($json_partie);//et on le ferme

 ?>
