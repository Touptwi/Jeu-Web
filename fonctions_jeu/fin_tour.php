<?php

  $json_regle = json_decode(file_get_contents("regles.json"),true);

  $path_file = "../partie_".$_GET["numero_partie"].".json";

  $partie = fopen($path_file,"r+");

  

  if (!flock($partie, LOCK_EX)) //on verouille le fichier
     http_response_code(409); // conflict
  $jsonString = fread($partie, filesize($path_file));
  $json_partie = json_decode($jsonString, true);//on recupère le plateau de jeu en associative array

  
  $json_partie["numero_tour"] = ($json_partie["numero_tour"] + 1)%5;//on incrémente de 1 le tour de jeu
  if ($json_partie["numero_tour"] != 0)//si le tour de jeu n'est pas a 0 (le tour du serveur)
  {
    $ids_joueurs = array_keys($json_partie["joueurs"]);//on récupère la liste des indices des joueurs
    if ($json_partie["numero_joueur_actuelle"] == 0) //si le dernier joueur est le serveur
    {
      $json_partie["numero_joueur_actuelle"] = $ids_joueurs[0];//on met le numero_joueur_actuelle à 0
    }else{
      $i = 0;
      $continue = true;
      while($continue&&$i < count($ids_joueurs))//on parcourt la liste des identifiants de joueurs
      {
        if($ids_joueurs[$i] == $json_partie["numero_joueur_actuelle"])//on choisit l'identifiant suivant du joueur actuelle et on arrete la boucle
        {
          $continue = false;
          $json_partie["numero_joueur_actuelle"] = $ids_joueurs[($i+1)%count($ids_joueurs)];
        }
        $i++;
      }

    }
  }else{//si c'est le tour du serveur, le joueur est mis à 0
    $json_partie["numero_joueur_actuelle"] = 0;
    include($json_regle["eval_zone_jeu"]); //on execute l'evaluation du terrain de jeu
  }

  $newJsonString = json_encode($json_partie, JSON_PRETTY_PRINT);//on encode
  ftruncate($partie, 0);
  fseek($partie,0);
  fwrite($partie, $newJsonString);//sauvegarde les changements
  flock($partie, LOCK_UN);//libère le fichier
  fclose($partie);//et on le ferme

 ?>
