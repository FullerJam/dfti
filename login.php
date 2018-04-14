<?php
session_start();
include("functions.php");

// Login script
// You must NOT modify this in any way, except to set your database details.

$username = htmlentities($_POST["username"]); //// $variable=htmlentities($_GET[""]); /  $variable=htmlentities($_POST[""]); protects against xsite scripts
$password = htmlentities($_POST["password"]);

// Edit this to connect to your database with your username and password
$con = connect();


$result=$con->prepare("SELECT * FROM users WHERE username=? AND password=?");
$result->bindParam(1,$username);
$result->bindParam(2,$password);
$result->execute();
$row=$result->fetch();

if($row==false)
{
	echo "Incorrect username/password!";
	
}
else
{	
	$_SESSION["ssuser"] = $username;
	
	// Save admin status from database in a session variable

	$_SESSION["isadmin"] = $row["isadmin"];
	
	
	// Redirect to index.php
	header("Location: index.php");
}
?>