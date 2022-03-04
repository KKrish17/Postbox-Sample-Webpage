<?php
	include("config1.php");
	$target="uploads/".basename($_FILES['image']['name']);
	$image=$_FILES['image']['name'];
	
	mysqli_query($db,"INSERT INTO `post`( `name`, `images`,`user_id`) VALUES ('krishna','$image','2')");
	
	if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
		echo "image upload successful";
	}else{
		echo "There was a problem uploading image";
	}
?>