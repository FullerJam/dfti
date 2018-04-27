<?php
session_start();
include('functions.php');//include all code from selected file
$id=$_GET["ID"];
$rating=$_GET["rating"];
$u=$_SESSION["ssuser"];

$con = connect(); // function wrtten in functions.php, log as a variable or you access the database an infinite number of times


$results=$con->prepare("SELECT * FROM products WHERE ID=?");
$results->bindParam(1,$id);
$results->execute();

$row=$results->fetch();


$results2=$con->prepare("SELECT * FROM userrating WHERE productID=? AND username=?");
$results2->bindParam(1,$id);
$results2->bindParam(2,$u);
$results2->execute();

$row2=$results2->fetch();
if(!isset($_GET["ID"])){
    echo "<br>";
    echo "<strong>You haven't provided any rated values for a product</strong>";
}
else if($row2 != false){
    
    
   // echo "<p>text to check if statement running</p>  <script type='text/javascript'>console.log('rated already');</script>";
   // echo '<script type="text/javascript">alert("hello!");</script>';

    //echo "product id: ".$row2["productID"]."<br>user: ".$row2["username"]."<br>user rating: ".$row2["userRating"].".";
    
    /*$insrating=$con->prepare("INSERT INTO userrating (username,productID,userRating) VALUES (?,?,?) ON DUPLICATE KEY UPDATE userRating=?");
    $insrating->bindParam(1,$u);
    $insrating->bindParam(2,$id);
    $insrating->bindParam(3,$rating);
    $insrating->bindParam(4,$rating);
    $insrating->execute();
    
   
    $preAv=(($row["av_raters"]*$row["num_raters"])+$rating)/($row["num_raters"]+1);
    
    echo "maths:  ((avgraters ".$row["av_raters"]."* numraters ".$row["num_raters"].")+ current rating ".$rating.")/( num raters".$row["num_raters"].")(- avgraters ".$row["av_raters"].")";
    $averages=$con->prepare("UPDATE products SET av_raters=? WHERE ID=?");
    $averages->bindParam(1,$preAv);
    $averages->bindParam(2,$id);
    $averages->execute();*/
    echo 0;
}else{
    $updateraters=$con->prepare("UPDATE products SET num_raters=num_raters +1 WHERE ID=?");
    $updateraters->bindParam(1,$id);
    $updateraters->execute();
    
    $insrating2=$con->prepare("INSERT INTO userrating (username,productID,userRating) VALUES (?,?,?) ON DUPLICATE KEY UPDATE userRating=?");
    $insrating2->bindParam(1,$u);
    $insrating2->bindParam(2,$id);
    $insrating2->bindParam(3,$rating);
    $insrating2->bindParam(4,$rating);
    $insrating2->execute();

    $av=(($row["av_raters"]*$row["num_raters"])+$rating)/($row["num_raters"]+1);
    echo "maths: ((".$row["av_raters"]."*".$row["num_raters"].")+".$rating.")/(".$row["num_raters"].")+1";
    $averageupdate=$con->prepare("UPDATE products SET av_raters=? WHERE ID=?");
    $averageupdate->bindParam(1,$av);
    $averageupdate->bindParam(2,$id);
    $averageupdate->execute();
}


//print_r($con->errorInfo());


?>