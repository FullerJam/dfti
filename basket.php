<?php
// If anything in while loop is changed, it may need to be changed
// in removefb.php & basketonload.php aswell.
session_start();
$id = $_GET["ID"];
$qty = $_GET["qty"];
$agelimit = $_GET["agelimit"];
$u = $_SESSION["ssuser"]; 
$totalprice=0;
$qtyprice=0;

include("functions.php");
$con = connect();


if ($agelimit>0){

    $results0=$con->query("SELECT dayofbirth, monthofbirth ,yearofbirth FROM users WHERE username='$u'");
    //$results0=$con->query("SELECT (CURDATE()-(dayofbirth, monthofbirth ,yearofbirth)) FROM users WHERE username='$u'");
    $row0=$results0->fetch();


    $day=$row0["dayofbirth"];
    $month=$row0["monthofbirth"];
    $year=$row0["yearofbirth"];

    $birthday = mktime(0,0,0,$month,$day,$year); // converts date to seconds
    $difference = time() - $birthday; // different inbetween current time/date stamp and $birthday 
    $age = floor($difference / 31556926); // calculates age of difference value by dividing by number of seconds in a year, floor removes decimal places
    
    if($age < $agelimit){
        echo "You are below the required age to purchase this product";
       // DIDNT WORK -- echo "<script type='text/javascript'>alert('You are below the required age to purchase this product')</script>"
    }else{

        //access stocklevel from database and store in var
        $stocklevel=$con->query("SELECT stocklevel FROM products WHERE ID='$id'");
        $row=$stocklevel->fetch();

        if ($qty>$row["stocklevel"]){
            echo "Not enough stock to satisfy your order, ".$row["stocklevel"]." items left in stock.";
        }else{
            //minus qty requested from stock
            $con->query("UPDATE products SET stocklevel=stocklevel-'$qty' WHERE ID='$id'");
            //insert order to basket    
            $con->query("INSERT INTO basket (productID, username, qty) VALUE ('$id','$u','$qty')");
            
            //select contents of basket
            $results=$con->query("SELECT * FROM basket WHERE username='$u'");
            //fetch results from array
            $row = $results->fetch();

            if ($row == false){
                echo "No items in basket!";
            }else{

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
                    echo "<a href='#' onclick='rfb(".$row["ID"].");ajaxrequest();'>Remove from basket</a>"; //onclick="doSomething();doSomethingElse();"
                    
                
                    $row = $results->fetch();
                    $row2 =$results2->fetch();
                }
                echo "<h3> Total Price £".$totalprice."</h3>";
                //echo "<a href='#' id='purchase' onclick='purchase.php'><strong>Purchase items</strong></a>";
            }
        }
    }
}
if ($agelimit == 0){
        $stocklevel=$con->query("SELECT stocklevel FROM products WHERE ID='$id'");
        $row=$stocklevel->fetch();

        if ($qty>$row["stocklevel"]){
            echo "Not enough stock to satisfy your order, ".$row["stocklevel"]." items left in stock.";
        }else{
            //minus qty requested from stock
            $con->query("UPDATE products SET stocklevel=stocklevel-'$qty' WHERE ID='$id'");
            //insert order to basket                   
            $con->query("INSERT INTO basket (productID, username, qty) VALUE ('$id','$u','$qty')");

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
                    echo " Quantity: " .$row["qty"]. "<br/>";  
                    echo " Item total: ".$qtyprice."<br/>";
                    echo "<a href='#' onclick='rfb(".$row["ID"].");setTimeout(function() {ajaxrequest()}, 1000);'>Remove from basket</a>"; // refreshs search results after 1s, I imagine this is bad practice but it works
                    
                
                    $row = $results->fetch();
                    $row2 =$results2->fetch();
                }
                echo "<h3> Total Price £".$totalprice."</h3>";
                //echo "<a href='#' id='purchase' onclick='purchase.php'><strong>Purchase items</strong></a>";
            }
        }
    }

?>