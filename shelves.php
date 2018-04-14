<?php
include("functions.php");
$con = connect();

$shelves=$con->query("SELECT * from products");

$row=$shelves->fetch();
echo "<strong>Please use search box to query and add products to basket</strong> <br><br>";
while($row){
    echo "Product ID: ".$row["ID"]."<br>";
    echo "Product name: ".$row["name"]."<br>";
    echo "Description: ".$row["description"]."<br><br>";
    $row=$shelves->fetch();
};

?>