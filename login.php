<?php
session_start();
include("functions.php");

// Login script
// You must NOT modify this in any way, except to set your database details.

$username = $_POST["username"];
$password = $_POST["password"];

// Edit this to connect to your database with your username and password
$con = connect();


$result=$con->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
$row=$result->fetch();
if($row==false)
{
	echo "Incorrect username/password!";
	
}
else
{	
	$_SESSION["ssuser"] = $username;
	
	// Save admin status from database in a session variable

	$_SESSION["isadmin"] = $row["admin"];
	
	
	// Redirect to index.php
	header("Location: index.php");
}
?>