<?php

  session_start();
include("config1.php");

 $email=$_SESSION["email"];
	$q=mysqli_query($db,"SELECT * from `users` WHERE email='$email'");
	$row1=mysqli_fetch_assoc($q);

$id=$row1["ID"];

$first=$row1["first"]." ".$row1["last"];
$pic=$row1["prof_pic"];
$content=$_POST["content"];


mysqli_query($db,"INSERT INTO `post`( `name`, `content`,`user_id`,`prof_pi`) VALUES ('$first','$content','$id','$pic')");
header("location: welcome.php");


?>