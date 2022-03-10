function join(){
	let nickname = document.getElementById('nickname').value;
	let level = document.getElementById('level').value;
      $.ajax({
        method: "GET",
        url: "inscription.php",
        data: {"nom": nickname,
        		"niveau": level}
      }).done(function(e) {
        joined();
        refresh();
      }).fail(function(e) {
        console.log(e);
        $("#message").html("<span class='ko'> Error: network problem </span>");
      });
}

function joined(){
  $.ajax({
    method: "GET",
    url: "joined.php",
    data: {}
  }).done(function(e) {
    $("#join_b").empty();
    $("#join_b").append(e);
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
        leaved();
        refresh();
      }).fail(function(e) {
        console.log(e);
        $("#message").html("<span class='ko'> Error: network problem </span>");
      });
}

function leaved(){
  $.ajax({
    method: "GET",
    url: "leaved.php",
    data: {}
  }).done(function(e) {
    $("#join_b").empty();
    $("#join_b").append(e);
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