<?php
// List of user friends
$db= new PDO('mysql:host=127.0.0.1;dbname=friend','root','root');
$user_friends = $relation->getFriendsList();

if (!empty($user_friends)) {
  echo '<ul>';
  foreach ($user_friends as $rel) {
    $friend = $relation->getFriend($rel);
    echo '<li><a href="profile.php?uid=' . $friend->getUserId() . '">' . ucfirst($friend->getUsername()) . '</a></li>';
  }
  echo '</ul>';
} else {
  echo '<h6>You don\'t have any friends yet!</h6>';
}


?>