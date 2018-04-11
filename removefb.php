<?php
session_start();
$id = $_GET["ID"] ;
$u = $_SESSION["ssuser"]; 
$totalprice=0;
$qtyprice=0;

include("functions.php");
$con = connect();
$qtyArray=$con->query("SELECT * FROM basket WHERE ID='$id'");
$qtyRow=$qtyArray->fetch();
$qty=$qtyRow["qty"];
$productID=$qtyRow["productID"]; //for basket update, add a product
//cannot be delete * FROM, has to be DELETE FROM
$con->query("DELETE FROM basket WHERE ID='$id'");

//refresh basket for user
$results=$con->query("SELECT * FROM basket WHERE username='$u'");
$row = $results->fetch();


//have to link qty to 
$con->query("UPDATE products SET stocklevel=stocklevel+'$qty' WHERE ID='$productID'");

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

        $qtyprice = $row2["price"] * $row["qty"];
        $totalprice += $qtyprice;

        echo "<p>";
        echo " Order ID: ".$row["ID"]."<br/>";
        echo " Product ID: ".$row["productID"]."<br/> ";
        echo " Product: ".$row2["name"]."<br/> ";
        echo " Price: ".$row2["price"]."<br/> ";
        echo " Age restriction: ".$row2["agelimit"]."<br/> "; 
        echo " Quantity: " .$row["qty"]. "<br/>" ;  
        echo " Item total: ".$qtyprice.".<br/>";
        echo "<a href='#' onclick='rfb(".$row["ID"].")'>Remove from basket</a>"; 
        
    
        $row = $results->fetch();
        $row2 =$results2->fetch();
    }
    echo "<h3> Total Price £".$totalprice."</h3>";
    //echo "<a href='#' id='purchase' onclick='purchase.php'><strong>Purchase items</strong></a>";
}

?>