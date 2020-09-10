<?php

$server = $_SERVER['SERVER_ADDR'];
$username = 'root';
$password = '';
dbname = 'images';
$charset = 'utf8';
connection = new mysqli($server, $username, $password, $dbname);

if($connection->connect_error){
	die("ijifrjifir".$connection->connect_error);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Пример веб-страницы</title>
  <style>
  header {
	  
	  text-align: center;
  }
  </style>
 </head>
 <body>
  <h1>Заголовок</h1>
  <!-- Комментарий -->
  <p>Первый абзац.</p>
  <p>Второй абзац.</p>
 
 </body>
</html>