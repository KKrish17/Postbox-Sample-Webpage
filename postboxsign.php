<?php
 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "postbox";
 
 $ui=rand(123000000,123456789);
 
 $con= new mysqli("localhost", "root", "root", "postbox");
 
	$first=$_POST["first"];
	$last=$_POST["last"];
	$password=$_POST["password"];
	$email=$_POST["email"];
	$mobile=$_POST["mobile"];
	$day=$_POST["day"];
	$month=$_POST["month"];
	$year=$_POST["year"];
	$gender=$_POST["gender"];
	
	$dob = "$year-$month-$day";

	 
$mysqli_result=mysqli_query($con,"SELECT * FROM users");

while($row=mysqli_fetch_array($mysqli_result))
{
	if($row['mobile']==$mobile)
	{
		echo "<script>window.alert('Mobile Number ALready Exists')
           window.location.href='http://localhost/postbox/postboxsign1.html'</script>";
		   return false;
	}
	elseif($row['email']==$email)
	{
		echo "<script>window.alert('Email ALready Exists')
           window.location.href='http://localhost/postbox/postboxsign1.html'</script>";
		   return false;
	}
	else{
	
		$sql = "INSERT INTO `users` ( `ID`,`first`, `last`, `email`, `password`, `dob`, `gender`, `mobile`) VALUES ('$ui','$first','$last','$email','$password','$dob','$gender','$mobile')";
	
	}
}
	
if ($con->query($sql) === TRUE) {
    echo "<script>alert('You Are Regisrtered Succesfully')
	 window.location.href='http://localhost/postbox/'</script>";
} 
else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
$con->close();



?>