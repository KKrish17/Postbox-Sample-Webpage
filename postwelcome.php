 <?php
 session_start();	
 define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'postbox');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	if($_SESSION["email"]==true)
	{
	   $email=$_SESSION["email"];
	}
	else
	{
		header("Location:http://localhost/postbox/");
	}
	$q=mysqli_query($db,"SELECT * from `users` WHERE email='$email'");
	$row=mysqli_fetch_assoc($q);
	
	$first=$row["first"];
	$last=$row["last"];
	$email=$row["email"];
	$dob=$row["dob"];
   
?>