
function refresh()
{
    $.ajax({
        method: "GET",
        url:"/fonctions_jeu/refresh.php",
        data: {}
    })
}