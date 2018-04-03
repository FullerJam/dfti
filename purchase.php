<?php
session_start();
$u = $_SESSION["ssuser"]; 
$totalprice=0;
$qtyprice=0;

include("functions.php");
$con = connect();

$results=$con->query("SELECT * FROM basket WHERE username='$u'");
$row = $results->fetch();

if ($row == false) 
{
    echo "No items in basket!";
}

else
{

    while($row != false)
    {
        $results2=$con->query("SELECT * FROM products WHERE ID='".$row["productID"]."'");
        $row2 = $results2->fetch();
        $results3=$con-.query("SELECT * FROM users where username='$u'");
        $row3=$results3->fetch();

        echo "<p>";
        echo "Your date of birth: ".$row3["dayofbirth"]."/".$row3["monthofbirth"]."/".$row3["yearofbirth"]."";
        echo " Order ID: ".$row["ID"]."<br/>";
        echo " Product ID: ".$row["productID"]."<br/> ";
        echo " Product: ".$row2["name"]."<br/> ";
        echo " Price: ".$row2["price"]."<br/> ";
        echo " username: ".$row["username"]."<br/> " ;
        echo " Age restriction: ".$row2["agelimit"]."<br/> "; 
        echo " Quantity: " .$row["qty"]. "<br/>" ;  
        echo "<a href='#' onclick='rfb(".$row["ID"].")'>Remove from basket</a>"; 
        $qtyprice = $row2["price"] * $row["qty"];
        $totalprice += $qtyprice;
      
        $row = $results->fetch();
        $row2 =$results2->fetch();
    }
    echo "<h3> Total Price £".$totalprice."</h3>";
    echo "<a href='#' id='purchase' onclick='purchase.php'><strong>Purchase items</strong></a>";
}