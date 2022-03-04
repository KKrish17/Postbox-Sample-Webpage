<?php
$db= new PDO('mysql:host=127.0.0.1;dbname=postbox','root','root');

$query=$db->prepare("SELECT * from users");
$query->execute();

$user=$_COOKIE['uid'];
if($query->rowCount()>0)
{
	while($fetch=$query->fetch(PDO::FETCH_ASSOC))
	{
		$id=$fetch['ID'];
		$username=$fetch['first']." ".$fetch['last'];
		if($id!=$user)
		{
		?>
		<div>
			<?php echo '<a href="profile.php?uid=' . $id. '">'.$username.'</a>'; }
	}
	?>
	

		<?php }
?>