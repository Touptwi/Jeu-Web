function add(){
	let nickname = document.getElementById('nickname').value;
	let level = document.getElementById('level').value;
      $.ajax({
        method: "GET",
        url: "inscription.php",
        data: {"nom": nickname,
        		"niveau": level}
      }).done(function(e) {
        console.log(nickname+" "+level);
        refresh();
      }).fail(function(e) {
        console.log(e);
        $("#message").html("<span class='ko'> Error: network problem </span>");
      });
}

function refresh(){
      $.ajax({
        method: "GET",
        url: "listplayers.php",
        data: {}
      }).done(function(e) {
      	  console.log("test1");
      	$("#listplayers").empty();
        $("#listplayers").append(e);
        console.log("test2");
      }).fail(function(e) {
        console.log(e);
        $("#message").html("<span class='ko'> Error: network problem </span>");
      });
}