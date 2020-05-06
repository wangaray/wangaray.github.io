console.log("%c¡Es calidad BaI!", "font-size: 50px; font-weight: bold;");

function set_stylesheet(styletitle) {
  opcs.style = styletitle;
  parse();
  var links = document.getElementsByTagName("link");
  var found = false;
  for (var i = 0; i < links.length; i++) {
    var rel = links[i].getAttribute("rel");
    var title = links[i].getAttribute("title");
    if (rel.indexOf("style") != -1 && title) {
      links[i].disabled = true; // IE needs this to work. IE needs to die.
      if (styletitle == title) {
        links[i].disabled = false;
        found = true;
      }
    }
  }
}

function get_active_stylesheet() {
  var links = document.getElementsByTagName("link");
  for (var i = 0; i < links.length; i++) {
    var rel = links[i].getAttribute("rel");
    var title = links[i].getAttribute("title");
    if (rel.indexOf("style") != -1 && title && !links[i].disabled) return title;
  }
  return null;
}

function check_news() {
  var last_t = opcs.last;
  var items = document.getElementsByClassName("ni");
  var dates = document.getElementsByClassName("ni-d");
  for (var i = 0; i < items.length; i++)
    if (parseInt(items[i].dataset.t) > last_t) {
      items[i].className += " urgent";
      dates[i].innerHTML =
        '<img src="/new.gif" style="width:18px;height:7px;"><br />' +
        dates[i].innerHTML;
    }
  opcs.last = (Date.now() / 1000) | 0;
  parse();
}

var lastTime = 0;
var refreshInterval;
var refreshMaxTime = 30;
var refreshTime;
var unread = {};
var last_threads = 0;
var last_serverTime = 0;
var http_request = new XMLHttpRequest();

function loadJSON() {
  stopCounter("...");
  var data_file =
    "/cgi/api/lastage?time=" +
    lastTime +
    "&limit=" +
    document.getElementById("limit").value;
  http_request.open("GET", data_file, true);
  http_request.send();
}

function setRead(threadId) {
  if (threadId in unread) {
    unread[threadId] = false;
    updatePostList(last_threads, last_serverTime);
  }
}

function updatePostList(threads, serverTime) {
  if (refreshMaxTime <= 120) refreshMaxTime += 5;
  var arrayLength = threads.length;
  if (!arrayLength) return;

  html = "";
  last_threads = threads;
  last_serverTime = serverTime;

  var newposts = 0;
  var newTitle = "Bienvenido a Internet BBS/IB";
  var new_unread = false;
  var news = [];

  for (var i = 0; i < arrayLength; i++) {
    thread = threads[i];
    if (thread.bumped >= lastTime) {
      unread[thread.id] = true;
      news.push("- " + thread.board_fulln + ": " + thread.content);
      new_unread = true;
    }
    if (unread[thread.id]) html += '<span class="new">';
    html +=
      '<a href="' +
      thread.url +
      '" class="thread" data-brd="' +
      thread.board_fulln +
      '" data-unix="' +
      thread.timestamp +
      '" data-last="' +
      thread.bumped +
      '" data-img="' +
      thread.thumb +
      '"><span class="brd">[' +
      thread.board_name +
      ']</span> <span class="cont">' +
      thread.content +
      '</span> <span class="rep">(' +
      thread.length +
      ")</span></a>";
    if (unread[thread.id]) {
      html += "</span>";
      newposts++;
    }
  }
  if (newposts) newTitle = "(" + newposts + ") " + newTitle;
  if (new_unread) {
    document.getElementById("newposts").style = "color:red";
    notif(
      "Bienvenido a Internet BBS/IB",
      "Hay nuevos mensajes:\n" + news.join("\n")
    );
    refreshMaxTime = 10;
    if (document.getElementById("autosound").checked) {
      document.getElementById("machina").volume = 0.6;
      document.getElementById("machina").play();
    }
  }
  window.parent.document.title = newTitle;
  document.title = newTitle;
  document.getElementById("postlist").innerHTML = html;
}

function notif(title, msg) {
  var n = new Notification(title, { body: msg });
  setTimeout(n.close.bind(n), 10000);
}

function counter() {
  if (refreshTime < 1) loadJSON();
  else {
    refreshTime--;
    document.getElementById("counter").innerHTML = "– " + (refreshTime + 1);
  }
}

function startCounter() {
  refreshTime = refreshMaxTime;
  counter();
  refreshInterval = setInterval(counter, 1000);
}

function stopCounter(str) {
  clearInterval(refreshInterval);
  document.getElementById("counter").innerHTML = str;
}

function autoRefresh(e) {
  if (chk.checked) {
    if (chk_snd) chk_snd.disabled = false;
    Notification.requestPermission();
    lastTime = Math.floor(Date.now() / 1000);
    refreshTime = refreshMaxTime;
    startCounter();
  } else {
    if (chk_snd) chk_snd.disabled = true;
    stopCounter("");
  }
}

http_request.onreadystatechange = function() {
  if (http_request.readyState == 4) {
    var jsonObj = JSON.parse(http_request.responseText);
    if (jsonObj.state == "success") {
      updatePostList(jsonObj.threads, jsonObj.time);
      lastTime = jsonObj.time;
      if (chk.checked) startCounter();
    }
  }
};

function parse() {
  localStorage.setItem("home", JSON.stringify(opcs));
}

document.addEventListener("DOMContentLoaded", function() {
  window.parent.document.title = document.getElementsByTagName(
    "title"
  )[0].textContent;

  if (localStorage.hasOwnProperty("home"))
    opcs = JSON.parse(localStorage.getItem("home"));
  else {
    opcs = { style: "IB", auto: false, sound: false, last: 0 };
    parse();
  }
  set_stylesheet(opcs.style);

  var css = document.getElementById("change_style").getElementsByTagName("a");
  for (var j = 0; j < css.length; j++) {
    css[j].addEventListener("click", function(e) {
      e.preventDefault();
      set_stylesheet(this.textContent);
    });
  }
  document.getElementById("autorefresh").addEventListener("click", function(e) {
    opcs.auto = !opcs.auto;
    autoRefresh();
    parse();
  });
  document.getElementById("autosound").addEventListener("click", function(e) {
    opcs.sound = !opcs.sound;
    parse();
  });
  check_news();

  chk = document.getElementById("autorefresh");
  chk_snd = document.getElementById("autosound");
  if (opcs.auto) {
    chk.checked = true;
    autoRefresh();
  } else chk.checked = false;
  if (opcs.sound) chk_snd.checked = true;
  else chk_snd.checked = false;
});
