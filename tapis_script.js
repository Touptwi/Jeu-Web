
setInterval(refresh, 500);

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
    $.ajax({
        method: "GET",
        datatype: "json",
        url:"fonctions_jeu/refresh.php",
        data: {"id_joueur":1,"numero_partie":1}
    }).done(function(e) {
      $("#J").empty();
      //console.log (e);
      $("#J").css("grid-template-columns","repeat(" + e.main_joueur.length +", 1fr)")
      for (let i = 0; i < e.main_joueur.length; i++)
      {
        $("#J").append("<div onclick = 'jouer_carte("+i+")'>" + e.main_joueur[i]);
      }
      if(e.pioche != [])
      {
        $("#pioche").empty();
        $("#pioche").append("pioche:<br>true");
        $("#pioche").attr("onclick","piocher()");
      }
      else
      {
        $("#pioche").empty();
        $("#pioche").append("pioche:<br>false");
      }

      $("#zone-jeu").empty();
      for (let i = 0; i < e.zone_jeu.length; i++)
      {
        $("#zone-jeu").append("<div>" + e.zone_jeu[i] + "</div>");
      }

    }).fail(function(e){
      console.log("on a un problème dans refresh" + e);
    })
}

function jouer_carte(carte)
{
  $.ajax({
    method: "GET",
    url: "fonctions_jeu/jouer_carte.php",
    data:{"id_joueur":1,"numero_partie":1,"id_carte":carte}

  }).done(function(e){
  }).fail(function(e){
    console.log("erreur dans jouer_carte.php");
  })
  return;
}

function piocher()
{
  $.ajax({
    method: "GET",
    url: "fonctions_jeu/piocher_carte.php",
    data:{"id_joueur":1,"numero_partie":1}

  }).done(function(e){
    console.log("tu as pioché");
  }).fail(function(e){
    console.log("erreur dans jouer_carte.php");
  })
  return;
}
