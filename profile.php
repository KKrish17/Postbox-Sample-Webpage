<?php
session_start();
include_once('app/config.php');
include_once ("time.php");

$db= new PDO('mysql:host=127.0.0.1;dbname=postbox','root','root');
$query=$db->prepare("SELECT * from users");
$query->execute();

$id2=array();
if($query->rowCount()>0)
{
	while($fetch=$query->fetch(PDO::FETCH_ASSOC))
	{
		$id2[]=$fetch['ID'];
	}
}
 //################ Logged in user details ###################################

  // Logged in user details.
$user = new User();
$user = $user->getUser($mysqli, (int) $_COOKIE['uid']);

  // Relation of the logged in user
$relation = new Relation($mysqli, $user);

  //################# Profile user details ####################################
$friend_id = (int) $_GET['uid'];
  // Check if the profile is same as the logged in user
if ($friend_id === $user->getUserId()) {
	$profile = $user;
	$profile_relation = $relation;
	$profile_friends = $relation->getFriendsList();
} else {
    // Profile use details
	$profile = (new User())->getUser($mysqli, $friend_id);

    // Relation object for the current profile being showed
	$profile_relation = new Relation($mysqli, $profile);

    // Got the Friends list
	$profile_friends = $profile_relation->getFriendsList();

    // Get the relationship between the current user and the profile user.
	$relationship = $relation->getRelationship($profile);
}
  // Checks if the profile is blocked
include_once('includes/blocked_profile.php');
//Get Friend data
$db = mysqli_connect("localhost","root","root","postbox");
$q=mysqli_query($db,"SELECT * from `users` WHERE ID='$friend_id'");
while($row1=mysqli_fetch_assoc($q))
{
	$prof_id=$row1["ID"];

	$prof_first=$row1["first"];
	$prof_last=$row1["last"];
	$prof_pic=$row1["prof_pic"];			
	$prof_email=$row1["email"];
	$prof_dob=$row1["dob"];
	
}

$query=mysqli_query($db,"SELECT * FROM `post` ORDER BY `post`.`created_at` DESC");
$rowcount=mysqli_num_rows($query);

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Postbox</title>
	<link rel="icon" type="image/x-icon" href="postbox1.png">
	<link rel="stylesheet" href="welcome22.css" type="text/css">
	<link rel="stylesheet" href="includes/font-awesome.css">
	<style>
		.profmodal {
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
	<?php if ($is_blocked === false) { ?>
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
						<a href="#Search"><li class="ri"><input type="searchbox" name="search" placeholder="Enter name..."></li></a>
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
						<img src="uploads/<?php echo $prof_pic;?>" alt="profile" class="profileimg" style="height:170px;width:170px;">
					</div>
					<div align="center">
						<?php // Check if the current user is not the profile user.
						if ($profile->getUserId() !== $user->getUserId()) {
  // Check if user is there in any relationship record
							if ($relationship !== false) {
								switch ($relationship->getStatus()) {
									case 0:
									if ($relationship->getActionUserId() == $user->getUserId()) {
										echo '<a href="user_action.php?action=cancel&friend_id=' . 
										$profile->getUserId() . '">Cancel Request</a>';
									} else {
										echo '<a href="user_action.php?action=accept&friend_id=' . 
										$profile->getUserId() . '">Accept Request</a>';
									}
									break;
									case 1:
									echo '<a href="user_action.php?action=unfriend&friend_id=' . 
									$profile->getUserId() . '">Unfriend </a>';
									echo '<a href="user_action.php?action=block&friend_id=' . 
									$profile->getUserId() . '"> Block</a>';
									break;
									case 2:
									echo '<small>Your request has been declined!</small>';
									break;
								}
							} else if ($relationship === false) {
								echo '<a href="user_action.php?action=add&friend_id=' . 
								$profile->getUserId() . '">Add Friend</a>';
							}
						}
						echo '<hr/>';?>
					</div>
					<div class="profiledata">
						<b style="color:black"><i class="fa fa-user"></i></b> <?php  echo $prof_first." ".$prof_last; ?><br>
						<b style="color:black"><i class="fa fa-envelope"></i></b> <?php  echo $prof_email; ?><br>
						<b style="color:black"><i class="fa fa-birthday-cake"></i></b> <?php  echo $prof_dob; ?><br>
					</div>
				</div>
				<div class="midbar-content">
					<div class="welcome">
						DISCUSSIONS
					</div>
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
									<img src="uploads/<?php echo $row["prof_pi"];?>" style="height:25px; width:25px; border:1px solid blue;border-radius:40%;">
									<a href="#" style="font-family:Cambria Math"><?php echo " ".$nam; ?></a><b style="font-size:15px; float:right; margin-top:-20px; position:relative"><?php echo $when?></b>
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
										<a href="#Like"><li>Like</li></a>
										<a href="#Answer"><li>Answer</li></a>
										<a href="#Share"><li>Share</li></a>
									</ul>
								</div>

							</div>	
							</div><?php }?>
						</div>
						<div class="sidebar-content1">
							<div class="friends">
								FRIENDS
							</div>
							<div class="searchfriend">

							</div>
						</div>
					</div>
					<div class="new_user">
						<div class="new">
							<div class="new_users">
								GROUP MEMBERS
							</div>
							<div class="new_users_list">
								<div class="new_users_name"></div>
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
			<?php } else { ?>
				<p>You can't view this profile. It is either blocked or inactive</p>
			<?php } ?>
		</div>
	</body>
	</html>
