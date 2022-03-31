function join(){
	let nickname = document.getElementById('nickname').value;
	let level = document.getElementById('level').value;
  let id_partie = document.URL.substring(document.URL.lastIndexOf('=')+1);
      $.ajax({
        method: "GET",
        url: "inscription.php",
        data: { "nom": nickname,
        		    "niveau": level,
                "numero_partie": id_partie}
      }).done(function(e) {
        $("#join_b").attr('value', 'Leave');
        $("#join_b").attr('onclick', 'leave()');
        $("#nickname").attr('disabled', true);
        $("#level").attr('disabled', true);
        if(getCookie("id_player")>1000) {
          $("#start_b").attr('disabled', false);
        }
        refreshPlayer();
      }).fail(function(e) {
        console.log(e);
        $("#message").html("<span class='ko'> Error: network problem </span>");
      });
}

function leave(){
  let id_partie = document.URL.substring(document.URL.lastIndexOf('=')+1);
  $.ajax({
    method: "GET",
    url: "desinscription.php",
    data: {"numero_partie": id_partie}
  }).done(function(e) {
    $("#join_b").attr('value', 'Join');
    $("#join_b").attr('onclick', 'join()');
    $("#nickname").attr('disabled', false);
    $("#level").attr('disabled', false);
    $("#start_b").attr('disabled', true);
    refreshPlayer();
  }).fail(function(e) {
    console.log(e);
    $("#message").html("<span class='ko'> Error: network problem </span>");
  });
}

function checkJoined(){
  setInterval(refreshPlayer,750);
  setInterval(checkStarted,1000);
  let id_player = getCookie("id_player");
  if(id_player!="") {
    $("#join_b").attr('value', 'Leave');
    $("#join_b").attr('onclick', 'leave()');
    $("#nickname").attr('disabled', true);
    $("#level").attr('disabled', true);
    if(id_player>1000) {
      $("#start_b").attr('disabled', false);
    }
  }
  refreshPlayer()
}

function refreshPlayer(){
  let id_partie = document.URL.substring(document.URL.lastIndexOf('=')+1);
  $.ajax({
    method: "GET",
    url: "listplayers.php",
    data: {"numero_partie": id_partie}
  }).done(function(e) {
    $("#listplayers").empty();
    $("#listplayers").append(e);
  }).fail(function(e) {
    console.log(e);
    $("#message").html("<span class='ko'> Error: network problem </span>");
  });
}

function start_(){
  start();
  init_partie();
}

function start(){
  $.ajax({
    method: "GET",
    url: "tapis.php",
    data: {}
  }).done(function(e) {
    $("body").attr('onload','');
    $("body").empty();
    $("body").append(e);
    clearInterval(refreshPlayer);
    clearInterval(checkStarted);
  }).fail(function(e) {
    console.log(e);
    $("#message").html("<span class='ko'> Error: network problem </span>");
  });
}

function checkStarted() {
  let id_partie = document.URL.substring(document.URL.lastIndexOf('=')+1);
  let id_player = getCookie("id_player");
  $.ajax({
    method: "GET",
    url: "checkStarted.php",
    data: {"numero_partie": id_partie,
          "id_joueur": id_player}
  }).done(function(e) {
    if(e=="true") {start();}
  }).fail(function(e) {
    console.log(e);
    $("#message").html("<span class='ko'> Error: network problem </span>");
  });
}




function getCookie(cname) {
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