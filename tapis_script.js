
function get_cookie_value(cname)
{
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

var nombre_carte_prec = 0; //une variable globale qui indique le nombre de carte présente dans la main du joueur au tour précedent

function refresh()
{
  let id_partie = document.URL.substring(document.URL.lastIndexOf('=')+1);
    $.ajax({
        method: "GET",
        datatype: "json",
        url:"fonctions_jeu/refresh.php",
        data: {"id_joueur":get_cookie_value("id_player"),"numero_partie":id_partie}
    }).done(function(e) {
      //$("#J").empty(); //on vide la zone du joueur
      //$("#J").css("grid-template-columns","repeat(" + e.main_joueur.length +", 1fr)") //on definit la taille du layout
      //console.log("refresh log: nombre de carte précédente = " + nombre_carte_prec); 
      //console.log("refresh log: nb max = " + Math.max(e.main_joueur.length,nombre_carte_prec) );
      for (let i = 0; i < Math.max(e.main_joueur.length,nombre_carte_prec); i++)
      {
        //console.log("refresh log: numero_div = " + i);
        if(i < e.main_joueur.length) //pour toutes les cartes présente dans la main du joueur
        {  
          if($("#J #" + i).length === 0) //si aucune image n'est présente
          {
            $("#J").append("<img class= 'carte' id = '" + i +"' src ='cartes_png/" + e.main_joueur[i] + "' onclick = 'jouer_carte("+i+")'>"); //on les crée
          }else{
            $("#J #"+i).attr('src',"cartes_png/" + e.main_joueur[i]); //sinon on met l'image à jour
          }
        }else{ //si on a des images en trop, on les supprime
          //console.log("suppression d'une div inutile");
          $("#J #"+i).remove();
        }
      }
      nombre_carte_prec = e.main_joueur.length;
      //affichage de la pioche
      if(e.pioche != [])
      {
        $("#pioche").empty();
        $("#pioche").append("<img class= 'carte' src = 'cartes_png/carte_Autres_3.png' onclick = 'piocher()'>");
      }
      else
      {
        $("#pioche").empty();
      }
      //affichage de la zone de jeu
      $("#zone-jeu").empty();
      for (let i = 0; i < e.zone_jeu.length; i++)
      {
        $("#zone-jeu").append("<img class= 'carte' src ='cartes_png/" + e.zone_jeu[i] + "' >");
      }

      //affichage adversaires
      //console.log("refersh log: nombre adversaire " + Object.keys(e.adversaire).length);
      let liste_adversaires = Object.keys(e.adversaire)
      for(let i = 0 ; i < liste_adversaires.length; i++)
      {
        let ad = $("#Ad"+ (i+1));
        let id_adv = liste_adversaires[i];
        //console.log("affichage de " + id_adv);
        ad.empty(); //on vide la zone de l'adversaire
        ad.css("grid-template-columns","repeat(" + e.adversaire[id_adv].nb_cartes +", 0)") //on definit la taille du layout
        for (let j = 0; j < e.adversaire[id_adv].nb_cartes; j++)
        {
          //console.log("affichage de la carte adverse numero " + j)
          ad.append("<img class= 'carte' src ='cartes_png/carte_Autres_3.png' >");
        }
      }

    }).fail(function(e){
      console.log("on a un problème dans refresh" + e);
    })
}

function jouer_carte(carte)
{
  let id_partie = document.URL.substring(document.URL.lastIndexOf('=')+1);
  $.ajax({
    method: "GET",
    url: "fonctions_jeu/jouer_carte.php",
    data:{"id_joueur":get_cookie_value("id_player"),"numero_partie":id_partie,"id_carte":carte}

  }).done(function(e){
    console.log("Jouer_carte log: "+e);
  }).fail(function(e){
    console.log("erreur dans jouer_carte.php");
    console.log("Jouer_carte log: " + e);
  })
  return;
}

function piocher()
{
  let id_partie = document.URL.substring(document.URL.lastIndexOf('=')+1);
  $.ajax({
    method: "GET",
    url: "fonctions_jeu/piocher_carte.php",
    data:{"id_joueur":get_cookie_value("id_player"),"numero_partie":id_partie}

  }).done(function(e){
    console.log("log piocher: tu as pioché " + e );
  }).fail(function(e){
    console.log("log piocher: erreur dans jouer_carte.php");
  })
  return;
}

function init_partie()
{
  console.log("initialisation partie");
  setInterval(refresh, 500);
  let id_partie = document.URL.substring(document.URL.lastIndexOf('=')+1);
  console.log(id_partie);
  $.ajax({
    method: "GET",
    url: "fonctions_jeu/init_partie.php",
    data:{"id_joueur":get_cookie_value("id_player"),"numero_partie":id_partie}

  }).done(function(e){
    $("#J").append("<div onclick = 'fin_tour()'>fin de tour</div>");
    console.log("initialisation de la partie " + id_partie + "reussie: "+ e );
  }).fail(function(e){
    console.log("erreur dans init: " + e);
  })
  return;
}

function fin_tour()
{
  let id_partie = document.URL.substring(document.URL.lastIndexOf('=')+1);
  $.ajax({
    method:"GET",
    url:"fonctions_jeu/fin_tour.php",
    data:{"numero_partie":id_partie}
  }).done(function(e){
    console.log("fin_tour log: fin de tour réussi");
  }).fail(function(e){
    console.log("fin_tour log: erreur lors de la fin du tour de la partie"+ id_partie + " avec comme rendu " + e);
  })
}

function execute_notif(fichier, data)
{

}