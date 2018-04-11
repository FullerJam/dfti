<?php
session_start();
$u = $_SESSION["ssuser"];

include('functions.php');//include all code from selected file
$con = connect(); // function wrtten in functions.php, log as a variable or you access the database an infinite number of times

$totalprice=0;
$qtyprice=0; 

$results=$con->query("SELECT * FROM basket WHERE username='$u'");
        $row = $results->fetch();

        if ($row == false){
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
                echo " Item total: ".$qtyprice."<br/>";
                echo "<a href='#' onclick='rfb(".$row["ID"].");ajaxrequest();'>Remove from basket</a>"; 
                
            
                $row = $results->fetch();
                $row2 =$results2->fetch();
            }
            echo "<h3> Total Price £".$totalprice."</h3>";
            //echo "<a href='#' id='purchase' onclick='purchase.php'><strong>Purchase items</strong></a>";
        }
    
?>