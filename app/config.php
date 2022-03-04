<?php
include_once('app/User.php');
include_once('app/Relationship.php');
include_once('app/Relation.php');

// Mysql credentials and details
$host = 'localhost';
$username = 'root';
$password = 'root';
$db = 'postbox';

// Connect to mysql
$mysqli = new mysqli($host, $username, $password, $db);

// Check if there is any error in creating db connection.
if ($mysqli->connect_error) {
  die('Connect Error: Could not connect to database');
}