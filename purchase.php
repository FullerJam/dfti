<?php
session_start();
$u = $_SESSION["ssuser"];

include('functions.php');//include all code from selected file
$con = connect(); // function wrtten in functions.php, log as a variable or you access the database an infinite number of times

$results=$con->prepare("SELECT * FROM basket WHERE username=?");
$results->bindParam(1,$u);
$results->execute();
$row = $results->fetch();