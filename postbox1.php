<?php
session_start();
   include("config1.php");
   
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $email = $_REQUEST["email"];
      $password = $_REQUEST["password"];
	  
      $sql = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

      
      $count = mysqli_num_rows($result);
		
      if($count == 1) {
		  $_SESSION["email"]=$email;
         setcookie('uid', $row['ID'], time() + (86400 * 30), '/');
			header ("location:welcome.php");
      }
	  else {
         echo "<script>window.alert('Your Email or Password is invalid')
		 window.location.href='http://localhost/postbox/'</script>";
      }
   }
?>