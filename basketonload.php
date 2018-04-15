<?php
session_start();
$u = $_SESSION["ssuser"];

include('functions.php');//include all code from selected file
$con = connect(); // function wrtten in functions.php, log as a variable or you access the database an infinite number of times

$totalprice=0;
$qtyprice=0; 

$results=$con->prepare("SELECT * FROM basket WHERE username=?");
$results->bindParam(1,$u);
$results->execute();
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
                echo " Item total: ".$qtyprice."<br/><br>";
                echo "<a href='javascript:void(null);' onclick='rfb(".$row["ID"].")'>Remove from basket</a>"; // refreshs search results after 1s, I imagine this is bad practice but it works
                //javascript:void(null); cancels default action for link stopping page from scrolling to top
            
            
                $row = $results->fetch();
                $row2 =$results2->fetch();
            }
            echo "<h3> Total Price £".$totalprice."</h3>";
        }
    
?>