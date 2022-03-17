
setInterval(refresh, 1000);

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
        $("#J").append("<div>" + e.main_joueur[i] + "</div>");
      }
      if(e.pioche != [])
      {
        $("#pioche").empty();
        $("#pioche").append("pioche:<br>true");
      }
      else
      {
        $("#pioche").empty();
        $("#pioche").append("pioche:<br>false");
      }

    }).fail(function(e){
      console.log("on a un problème dans refresh");
    })
}
