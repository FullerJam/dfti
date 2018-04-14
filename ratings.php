<?php
session_start();
include('functions.php');//include all code from selected file
$id=$_GET["ID"];
$rating=$_GET["rating"];
$u=$_SESSION["ssuser"];

$con = connect(); // function wrtten in functions.php, log as a variable or you access the database an infinite number of times


$results=$con->query("SELECT * FROM products WHERE ID='$id'");
$results2=$con->query("SELECT * FROM userrating WHERE productID='$id'AND username='$u'");
$row=$results->fetch();
$row2=$results2->fetch();

if($row2 != false){
    //echo "You've already rated this item <br>"; //previously used for debugging
    //echo "product id: ".$row2["productID"]."<br>user: ".$row2["username"]."<br>user rating: ".$row2["userRating"].".";
    $con->query("INSERT INTO userrating (username,productID,userRating) VALUES ('$u','$id','$rating') ON DUPLICATE KEY UPDATE userRating='$rating'");
    

    $av=(($row["av_raters"]*$row["num_raters"])+$rating)/($row["num_raters"]+1); // removed +1 due to no new vote being cast // readded cannot divide by zero, result imperfect but close
    echo $av;
    $con->query("UPDATE products SET av_raters='$av' WHERE ID='$id'");
}
else{
    $con->query("UPDATE products SET num_raters=num_raters +1 WHERE ID='$id'");
    $con->query("INSERT INTO userrating (username,productID,userRating) VALUES ('$u','$id','$rating') ON DUPLICATE KEY UPDATE userRating='$rating'");
     
    $av=(($row["av_raters"]*$row["num_raters"])+$rating)/($row["num_raters"]+1);
    echo $av;
    $con->query("UPDATE products SET av_raters='$av' WHERE ID='$id'");
}


//print_r($con->errorInfo());


?>