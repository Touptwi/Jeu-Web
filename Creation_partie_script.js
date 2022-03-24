function start()
{
    let numero_partie = 0;

    $.ajax({
        method: "GET",
        url: "generation_partie.php",
    }).done(function(e){
        let lien = "http://ssh1.pgip.universite-paris-saclay.fr/~bsoulla/Jeu-Web/welcom.html?id_partie="+ e;
        $("#interface").append("<td>Votre partie vous attend au lien:<br><a href = "+lien+">"+lien+"</td></a>");
    }).fail(function(e){
        console.log("impossible d'attribuer une partie");
    })

    
}