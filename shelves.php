<?php
include("functions.php");
$con = connect();

$shelves = $con->query("SELECT * from products");

$row=$shelves->fetch();
echo "Please use search box to query and add products to basket <br><br>";
while($row){
    echo "Product name: ".$row["name"]."<br>";
    echo "Description: ".$row["description"]."<br>";
    $row=$shelves->fetch();
};

?>