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
}
else{
    $con->query("UPDATE products SET num_raters=num_raters +1 WHERE ID='$id'");
    
    $results3=$con->query("SELECT * FROM products WHERE ID='$id'");
    $row3=$results3->fetch();
    $results4=$con->query("SELECT * FROM userrating WHERE productID='$id'AND username='$u'");
    $row4=$results4->fetch();

    
    $av=(($row["av_raters"]*$row3["num_raters"])+$row4["userRating"])/($row3["num_raters"]); // removed +1 due to new db connection
    echo $av;
    $con->query("UPDATE products SET av_raters='$av' WHERE ID='$id'");
}


print_r($con->errorInfo());


?>