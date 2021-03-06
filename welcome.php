<?php 
session_start();
include("config1.php");
include_once ("time.php");
include_once ("app/User.php");
include_once ("app/Relation.php");
include_once ("app/Relationship.php");
$host = 'localhost';
$username = 'root';
$password = 'root';
$newdb = 'postbox';

// Connect to mysql
$mysqli = new mysqli($host, $username, $password, $newdb);

$email=$_SESSION["email"];
$q=mysqli_query($db,"SELECT * from `users` WHERE email='$email'");
$row1=mysqli_fetch_assoc($q);

$id=$row1["ID"];

$first=$row1["first"];
$last=$row1["last"];

$email=$row1["email"];
$dob=$row1["dob"];

$query=mysqli_query($db,"SELECT * FROM `post` ORDER BY `post`.`created_at` DESC");
$rowcount=mysqli_num_rows($query);

  // Logged in user details.
$user = new User();
$user = $user->getUser($mysqli, (int) $_COOKIE['uid']);

  // Relation of the logged in user
$relation = new Relation($mysqli, $user);

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Postbox</title>
	<link rel="icon" type="image/x-icon" href="postbox1.png">
	<link rel="stylesheet" href="welcome.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		.profmodals {
			display: none; 
			position: fixed; 
			z-index: 1; 
			left: 20%;
			top: 20%;
			width: 50%; 
			height: 50%; 
			overflow: auto; 
			background-color: rgb(0,0,0); 
			background-color: rgba(0,0,0,0.4);
			padding-top: 60px;
		}
	</style>
</head>
<body>
	<section>
		<div>
			<div class="navbar">
				<ul>
					<a href="welcome.php"><li>Home</li></a>
					<a href="#Friends"><li>Friends</li></a>
					<a href="#Message"><li>Messages</li></a>
					<a href="#Discussion"><li>Discussion</li></a>
					<a href="#Groups"><li>Groups</li></a>
					<a href="#Projects"><li>Projects</li></a>
					<a href="#News"><li>News</li></a>
					<a href="logoutuser.php"><li class="ri">Logout</li></a>
					<a href="#Settings"><li class="ri">Settings</li></a>
					<a href="#Search"><li class="ri"><input type="searchbox" name="sear" placeholder="Enter name..."></li></a>
				</ul>
			</div>
		</div>
	</section>
	
	<section id="mid-division">
		<div class="sidebar">
			<div class="sidebar-content">
				<div class="profdata">
					ABOUT
				</div>
				<div class="profile-head">
					<img src="uploads/<?php echo $row1["prof_pic"];?>" alt="profile" class="profileimg" style="height:170px;width:170px;">
					<div class="middle">
						<div class="text"><a href="#" onclick="document.getElementById('id01').style.display='block'" style="width:auto">Update<a></div>
						</div>
					</div>
					<div class="profiledata">
						<b style="color:black"><i class="fa fa-user"></i> </b> <?php  echo $first." ".$last; ?><br>
						<b style="color:black"><i class="fa fa-envelope"></i></b> <?php  echo $email; ?><br>
						<b style="color:black"><i class="fa fa-birthday-cake"></i></b> <?php  echo $dob; ?><br>
					</div>
				</div>
				<div class="midbar-content">
					<div class="welcome">
						DISCUSSIONS
					</div>
					<?php
					$idname="$first $last";
					$q=mysqli_query($db,"SELECT * from `users` WHERE email='$email'");
					$row=mysqli_fetch_assoc($q);
					if(isset($_REQUEST["update"]))
					{
						$content=$_REQUEST["content"];
						mysqli_query($db,"INSERT INTO `post`( `name`, `content`,`user_id`) VALUES ('$idname','$content','$id')");
					}
					?>
					<form method="POST" action="post.php">
						<div class="status">
							<div class="statupdate">
								<textarea rows="3" cols="70" class="update" name="content" placeholder="Enter your question Here...." required></textarea>
							</div>
							<div class="sub">
								<a onclick="uploadpic1()"><i class="upic fa fa-camera-retro"></i>
									<input type="submit" onclick="statupdate()" value="update" name="update" class="update1">
									<input type="reset" value="cancel" name="cancel" class="cancel">
								</div>
							</div>
						</form>
						<?php	
						for($i=$rowcount;$i>=1;$i--)
						{
							$row=mysqli_fetch_array($query);
							$timeAgoObject= new convertToAgo;
							$ts=$row["created_at"];
							$nam=$row["name"];
							$convertedTime=($timeAgoObject->convertTodatetime($ts));
							$when=($timeAgoObject->convertToAgoFormat($convertedTime));?>

							<div class="discussion11">
								<div class="discussion1">
									<div class="discuss">
										<div class="dis"><img src="uploads/<?php echo $row["prof_pic"];?>" style="height:45px; width:45px; border:1px solid blue;border-radius:40%;"></div>
										<div class="dis"><a href="#" style="font-family:Calibri;font-size:23px;" class="disnam"><?php echo " ".$nam; ?></div></a><b style="font-size:15px; float:right; margin-top:-23px; position:relative"><?php echo $when?></b>
									</div>
									<div class="disqs">
										<?php echo $row["content"];
										if($row["images"]==null){
										}
										else{?>
											<img src="uploads/<?php echo $row["images"];?>" style="height:300px; width:300px;margin-left:180px;margin-top:5px;"><?php
										}?>
									</div>
									<div class="dislike">
										<ul>
											<a href="#Like"><li>Like<i class="fa fa-thumbs-up"></i></li></a>
											<a href="#Answer"><li>Answer<i class="fa fa-comment"></i></li></a>
											<a href="#Share"><li>Share<i class="fa fa-share"></i></li></a>
										</ul>
									</div> 

								</div>
								</div><?php }?>
							</div>
							<div class="sidebar-content1">
								<div class="friends">
									FRIENDS
								</div>
								<div align="center">
									<?php
									$_SESSION['user']=$user->getUsername();
									include_once('includes/user_friends.php');
									?>
								</div>
							</div>
						</div>
						<div class="new_user">
							<div class="new">
								<div class="new_users">
									SUGGESTIONS
								</div>
								<div align="center">
									<?php
									include_once('includes/users.php');?>
								</div>
<!-- 					<?php 
//					 $db = mysqli_connect("localhost","root","root","postbox");
//
//						$q=mysqli_query($db,"SELECT * from `users`");
//							
//						while($row1=mysqli_fetch_assoc($q))
//						{
//							$name=$row1['first'];
//							$id1=$row1['ID'];
//							$_SESSION["uid1"]=$id1;
//							if($id1!=$id){
//					?>
//					<div class="new_users_list">
						<?php  // echo '<a href="profile.php?uid=' . $id1. '">'?>
						<img src="uploads/<?php // echo $row1["prof_pic"];?>" style="height:80px; width:80px; border:1px solid blue;border-radius:40%;"></a> 
						<div class="new_users_name"><?php // echo '<a href="profile.php?uid=' . $id1. '">'.$name.'</a>'; ?></div>
					</div><?php 
//					}
//				}?> -->
</div>
</div>
<div class="new_user">
	<div class="new">
		<div class="sent_request">
			FRIEND REQUESTS
		</div>
		<div align="center">
			<?php
			include_once('includes/user_friend_requests.php');?>
		</div>
	</div>
</div>
<div class="new_user">
	<div class="new">
		<div class="sent_request">
			SENT FRIEND REQUESTS
		</div>
		<div align="center">
			<?php
			include_once('includes/sent_friend_requests.php');?>
		</div>
	</div>
</div>
<div class="new_user">
	<div class="new">
		<div class="sent_request">
			BLOCKED FRIENDS
		</div>
		<div align="center">
			<?php
			include_once('includes/blocked_friends.php');?>
		</div>
	</div>
</div>
</section>
<section>
	<div>
		<div class="footer">
			All rights reserved &copy Postbox 2018 , Designed by <i><b>Krishnagopal Kar</b></i> , Computer Science Department , Cooch Behar Government Engineering College 
		</div>
	</div>
</section>
<script>
	var profmodal = document.getElementById('id01');

	window.onclick = function(event) {
		if (event.target == profmodal) {
			profmodal.style.display = "none";
		}
	}
</script>
</body>
</html>