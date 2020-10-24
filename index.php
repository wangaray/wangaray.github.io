
<?php
  // Create database connection
  $db = mysqli_connect("durvbryvdw2sjcm5.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "nknzycgijdr0z2ab", "i4ia5z9al7xklchy", "pxhikunxbwhckhm9");
  //"durvbryvdw2sjcm5.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "nknzycgijdr0z2ab", "i4ia5z9al7xklchy", "pxhikunxbwhckhm9"

  // Initialize message variable
  $msg = "";

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
  	// Get text
  	$image_text = mysqli_real_escape_string($db, $_POST['image_text']);
	
	$text2 = mysqli_real_escape_string($db, $_POST['text2']);

  	// image file directory
  	$target = "images/".basename($image);

  	$sql = "INSERT INTO images (image, image_text, text2) VALUES ('$image', '$image_text', '$text2')";
  	// execute query
  	mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $result = mysqli_query($db, "SELECT * FROM images ORDER BY -ID");
?>
<!DOCTYPE html>
<html>
<head>
<title>Image Upload</title>
<main>
  <div class="emojis">
    <div class="emoji">😀</div>
    <div class="emoji">😍</div>
    <div class="emoji">😲</div>
    <div class="emoji">😡</div>
    <div class="emoji">💘</div>
  </div>
</main>
<style type="text/css">
button.learn-more {
@import url("https://fonts.googleapis.com/css?family=Rubik:700&display=swap");

   
    box-sizing: border-box; }
}


button {
  position: relative;
  display: inline-block;
  cursor: pointer;
  outline: none;
  border: 0;
  vertical-align: middle;
  text-decoration: none;
  font-size: inherit;
  font-family: inherit; }
  button.learn-more {
    font-weight: 600;
    color: #382b22;
    text-transform: uppercase;
    padding: 1.25em 2em;
    background: #fff0f0;
    border: 2px solid #b18597;
    border-radius: 0.75em;
    transform-style: preserve-3d;
    transition: transform 150ms cubic-bezier(0, 0, 0.58, 1), background 150ms cubic-bezier(0, 0, 0.58, 1); }
    button.learn-more::before {
      position: absolute;
      content: '';
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: #f9c4d2;
      border-radius: inherit;
      box-shadow: 0 0 0 2px #b18597, 0 0.625em 0 0 #ffe3e2;
      transform: translate3d(0, 0.75em, -1em);
      transition: transform 150ms cubic-bezier(0, 0, 0.58, 1), box-shadow 150ms cubic-bezier(0, 0, 0.58, 1); }
    button.learn-more:hover {
      background: #ffe9e9;
      transform: translate(0, 0.25em); }
      button.learn-more:hover::before {
        box-shadow: 0 0 0 2px #b18597, 0 0.5em 0 0 #ffe3e2;
        transform: translate3d(0, 0.5em, -1em); }
    button.learn-more:active {
      background: #ffe9e9;
      transform: translate(0em, 0.75em); }
      button.learn-more:active::before {
        box-shadow: 0 0 0 2px #b18597, 0 0 #ffe3e2;
        transform: translate3d(0, 0, -1em); }
}


   #content{
   	width: 50%;
   	margin: 20px auto;
   	border: 1px solid #fff;
   }
   form{
   	width: 50%;
   	margin: 20px auto;
   }
   form div{
   	margin-top: 5px;
   }
   #img_div{
   	width: 80%;
   	padding: 20px;
   	margin: 40px auto;
   	border: 4px solid #333;
	border-radius: 30px;
	background-position: center;
	background-size: contain;
   }
   #img_div:after{
   	content: "";
   	display: block;
   	clear: both;
   }
   img{
   	width: 50%;
	margin: 2px auto;
height:200px;
min-height:600px;
max-height:750px;
background-size: contain;
background-position: center;
border-radius: inherit;
   }
   h2{
	font-size: 20px
	color: #dfebe7;
	font-style: Times;
	}		
   body{
    background-color: #fff/* Цвет фона веб-страницы */
   }
   p {
    font: 26px sans-serif;

	color: #2e2e2e;

   }
    button.new {
	background-color: #000;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00BBD6', endColorstr='#EBFFFF');
    padding: 24px 80px;
    color: #333;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    border: 0px solid #666;
	border-radius: 12px;
    color: white;
   }
   input.but {
	background-color: #000;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00BBD6', endColorstr='#EBFFFF');
    padding: 16px 30px;
    color: #333;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    border: 0px solid #666;
	border-radius: 12px;
    color: white;
   }
   body {
  height: 100%; }

body {
  margin: 0;
  background-color: #ededed; }

main {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center; }

.emojis {
  display: flex;
  flex-direction: row;
  background-color: #ffffff;
  align-items: center;
  padding: 0.5rem 1.5rem 1rem 1.5rem;
  border-radius: 4rem;
  box-shadow: 0 2px 12px 2px rgba(0, 0, 0, 0.1); }
  .emojis .emoji {
    cursor: pointer;
    user-select: none;
    font-size: 2rem;
    margin: 0 0.5rem;
    transition: all 0.3s; }
    .emojis .emoji.active {
      animation-name: emoji;
      animation-duration: 0.6s;
      animation-direction: forwards;
      animation-timing-function: ease-out;
      animation-iteration-count: 1; }
    .emojis .emoji:hover {
      transform: scale(1.5); }

@keyframes emoji {
  5% {
    transform: translateY(1rem); }
  10% {
    transform: translateY(0) scale(1);
    opacity: 1; }
  50% {
    transform: translateY(-4rem) scale(1.5) rotateY(90deg); }
  80% {
    opacity: 0; }
  100% {
    transform: translateY(-8rem) scale(2) rotateY(180deg);
    opacity: 0; } }
}
</style>
</head>
<body>
<form method="POST" action="index.php" enctype="multipart/form-data">
  	<input class="cloq" type="hidden" name="size" value="1000000">
  	<div>
  	  <input class="but" type="file" name="image">
  	</div>
  	<div>
      <textarea 
      	id="text" 
      	cols="40" 
      	rows="4" 
      	name="image_text" 
      	placeholder="Create your post"></textarea>
  	</div>
	<div>
      <textarea 
      	id="text2" 
      	cols="20" 
      	rows="2" 
      	name="text2" 
      	placeholder="Number people"></textarea>
  	</div>
  	<div>
  		<button   class="new "type="submit" name="upload" color="primary">POST</button>
		<button class="learn-more">Learn More</button>
  	</div>
	<form method="POST" action="index.php" enctype="multipart/form-data">
  </form>

<div id="content">
  <?php
    while ($row = mysqli_fetch_array($result)) {
      echo "<div id='img_div'>";
      	echo "<img src='images/".$row['image']."' >";
      	echo "<p>".$row['image_text']."</p>";
		echo "<p>".$row['text2']."</p>";
      echo "</div>";
    }
  ?>
</div>
</body>
</html>