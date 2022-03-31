function start()
{
    let numero_partie = 0;

    $.ajax({
        method: "GET",
        url: "generation_partie.php",
    }).done(function(e){
        let url = window.location.href;
        let lien = url.substring(0,url.lastIndexOf('/') + 1)+"welcom.html?numero_partie=" + e;
        $("#interface").append("<td>Votre partie vous attend au lien:<br><a href = "+lien+">"+lien+"</td></a>");
    }).fail(function(e){
        console.log("impossible d'attribuer une partie");
    })

    
}