<?php
session_start();
$id = $_GET["ID"];
$u = $_SESSION["ssuser"]; 
$totalprice=0;
$qtyprice=0;

include("functions.php");
$con = connect();
$qtyArray=$con->prepare("SELECT * FROM basket WHERE ID=?");
$qtyArray->bindParam(1,$id);
$qtyArray->execute();

$qtyRow=$qtyArray->fetch();
$qty=$qtyRow["qty"];
$productID=$qtyRow["productID"]; //for basket update, add a product

//cannot be delete * FROM, has to be DELETE FROM
$rfb=$con->prepare("DELETE FROM basket WHERE ID=?");
$rfb->bindParam(1,$id);
$rfb->execute();
//refresh basket for user
$results=$con->prepare("SELECT * FROM basket WHERE username=?");
$results->bindParam(1,$u);
$results->execute();
$row = $results->fetch();


//update stocklevels when removed from basket 
$updatestock=$con->prepare("UPDATE products SET stocklevel=stocklevel+? WHERE ID=?");
$updatestock->bindParam(1,$qty);
$updatestock->bindParam(2,$productID);
$updatestock->execute();

if ($row == false) 
{
    echo "No items in basket!";
}

else
{

    while($row != false)
    {
            
        $results2=$con->prepare("SELECT * FROM products WHERE ID=?");
        $results2->bindParam(1,$row["productID"]);
        $results2->execute();
        
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
        echo "<a href='#' onclick='rfb(".$row["ID"].");ajaxrequest();'>Remove from basket</a>"; 
        
    
        $row = $results->fetch();
        $row2 =$results2->fetch();
    }
    echo "<h3> Total Price £".$totalprice."</h3>";
    //echo "<a href='#' id='purchase' onclick='purchase.php'><strong>Purchase items</strong></a>";
}

?>