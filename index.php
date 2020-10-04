<?php
  // Create database connection
  $db = mysqli_connect("durvbryvdw2sjcm5.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "nknzycgijdr0z2ab", "i4ia5z9al7xklchy", "pxhikunxbwhckhm9");

  // Initialize message variable
  $msg = "";

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
  	// Get text
  	$image_text = mysqli_real_escape_string($db, $_POST['image_text']);

  	// image file directory
  	$target = "images/".basename($image);

  	$sql = "INSERT INTO images (image, image_text) VALUES ('$image', '$image_text')";
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
<style type="text/css">
   #content{
   	width: 50%;
   	margin: 20px auto;
   	border: 1px solid #fff;
   }
   form{
   	width: 30%;
   	margin: 20px auto;
   }
   form div{
   	margin-top: 5px;
   }
   #img_div{
   	width: 80%;
   	padding: 20px;
   	margin: 15px auto;
   	border: 4px solid #333;
	border-radius: 30px;
   }
   #img_div:after{
   	content: "";
   	display: block;
   	clear: both;
   }
   img{
   	float: left;
   	margin: 5px;
   	width: 100%;
   	height: auto;
	border-radius: 25px;
   }
   h2{
	font-size: 25px
	color: #dfebe7;
	font-style: Times;
	}		
   body{
    background-color: #fff/* Цвет фона веб-страницы */
   }
   p {
    font: 20px Verdana;

	color: #2e2e2e;

   }
</style>
</head>
<body>
<form method="POST" action="index.php" enctype="multipart/form-data">
  	<input type="hidden" name="size" value="1000000">
  	<div>
  	  <input type="file" name="image">
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
  		<button type="submit" name="upload">POST</button>
  	</div>
	<form method="POST" action="index.php" enctype="multipart/form-data">
  </form>

<div id="content">
  <?php
    while ($row = mysqli_fetch_array($result)) {
      echo "<div id='img_div'>";
      	echo "<img src='images/".$row['image']."' >";
      	echo "<p>".$row['image_text']."</p>";
      echo "</div>";
    }
  ?>
</div>
</body>
</html>