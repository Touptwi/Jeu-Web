function join(){
	let nickname = document.getElementById('nickname').value;
	let level = document.getElementById('level').value;
      $.ajax({
        method: "GET",
        url: "inscription.php",
        data: {"nom": nickname,
        		"niveau": level}
      }).done(function(e) {
        $("#join_b").empty();
        $("#join_b").append(e);
        refresh();
      }).fail(function(e) {
        console.log(e);
        $("#message").html("<span class='ko'> Error: network problem </span>");
      });
}

function leave(){
  let nickname = document.getElementById('nickname').value;
      $.ajax({
        method: "GET",
        url: "desinscription.php",
        data: {"nom": nickname}
      }).done(function(e) {
        $("#join_b").empty();
        $("#join_b").append(e);
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
    $("#listplayers").empty();
    $("#listplayers").append(e);
  }).fail(function(e) {
    console.log(e);
    $("#message").html("<span class='ko'> Error: network problem </span>");
  });
}

function start(){
  $.ajax({
    method: "GET",
    url: "tapis.php",
    data: {}
  }).done(function(e) {
    $("body").empty();
    $("body").append(e);
  }).fail(function(e) {
    console.log(e);
    $("#message").html("<span class='ko'> Error: network problem </span>");
  });
}