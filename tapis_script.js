
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

function refresh()
{
  let id_partie = document.URL.substring(document.URL.lastIndexOf('=')+1);
    $.ajax({
        method: "GET",
        datatype: "json",
        url:"fonctions_jeu/refresh.php",
        data: {"id_joueur":get_cookie_value("id_player"),"numero_partie":id_partie}
    }).done(function(e) {
      $("#J").empty(); //on vide la zone du joueur
      $("#J").css("grid-template-columns","repeat(" + e.main_joueur.length +", 1fr)") //on definit la taille du layout
      for (let i = 0; i < e.main_joueur.length; i++)
      {
        $("#J").append("<div onclick = 'jouer_carte("+i+")'> <img id= 'carte' src ='cartes_png/" + e.main_joueur[i] + "' ></div>");
      }
      if(e.pioche != [])
      {
        $("#pioche").empty();
        $("#pioche").append("<img id = 'carte' src = 'cartes_png/carte_Autres_3.png'>");
        $("#pioche").attr("onclick","piocher()");
      }
      else
      {
        $("#pioche").empty();
        //$("#pioche").append("pioche:<br>false");
      }

      $("#zone-jeu").empty();
      for (let i = 0; i < e.zone_jeu.length; i++)
      {
        $("#zone-jeu").append("<div><img id= 'carte' src ='cartes_png/" + e.zone_jeu[i] + "' ></div>");
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
    console.log("initialisation de la partie " + id_partie + "reussie: "+ e );
  }).fail(function(e){
    console.log("erreur dans init: " + e);
  })
  return;
}


function execute_notif(fichier, data)
{

}