<?php
session_start();
include('functions.php');//include all code from selected file
$id=$_GET["ID"];
$rating=$_GET["rating"];
$u=$_SESSION["ssuser"];

$con = connect(); // function wrtten in functions.php, log as a variable or you access the database an infinite number of times

$con->query("INSERT INTO userrating (username,productID,userRating) VALUES ('$u','$id','$rating') ON DUPLICATE KEY UPDATE userRating='$rating'");


//print_r($con->errorInfo());
//print_r();