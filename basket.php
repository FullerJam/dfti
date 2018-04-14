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

    $results0=$con->prepare("SELECT dayofbirth, monthofbirth ,yearofbirth FROM users WHERE username=?");
    //$results0=$con->query("SELECT (CURDATE()-(dayofbirth, monthofbirth ,yearofbirth)) FROM users WHERE username='$u'");
    $results0->bindParam(1,$u);
    $results->execute();

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
        $stocklevel=$con->prepare("SELECT stocklevel FROM products WHERE ID=?");
        $stocklevel->bindParam(1,$id);
        $stocklevel->execute();

        $row=$stocklevel->fetch();

        if ($qty>$row["stocklevel"]){
            echo "Not enough stock to satisfy your order, ".$row["stocklevel"]." items left in stock.";
        }else{
            //minus qty requested from stock
            $minusq=$con->prepare("UPDATE products SET stocklevel=stocklevel-? WHERE ID=?");
            $minusq->bindParam(1,$qty);
            $minusq->bindParam(2,$id);
            $minusq->execute();
            //insert order to basket    
            $insorder=$con->prepare("INSERT INTO basket (productID, username, qty) VALUE (?,?,?)");
            $insorder->bindParam(1,$id);
            $insorder->bindParam(2,$u);
            $insorder->bindParam(3,$qty);
            $insorder->execute();
            //select contents of basket
            $results=$con->prepare("SELECT * FROM basket WHERE username=?");
            $results->bindParam(1,$u);
            $results->execute();
            
            //fetch results from array
            $row = $results->fetch();

            if ($row == false){
                echo "No items in basket!";
            }else{

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
                    echo " Item total: ".$qtyprice."<br/>";
                    echo "<a href='#' onclick='rfb(".$row["ID"].")'>Remove from basket</a>"; //onclick="doSomething();doSomethingElse();"
                    
                
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
        $stocklevel=$con->prepare("SELECT stocklevel FROM products WHERE ID=?");
        $stocklevel->bindParam(1,$id);
        $stocklevel->execute();

        $row=$stocklevel->fetch();

        if ($qty>$row["stocklevel"]){
            echo "Not enough stock to satisfy your order, ".$row["stocklevel"]." items left in stock.";
        }else{
            //minus qty requested from stock
            $minusqty2=$con->prepare("UPDATE products SET stocklevel=stocklevel-? WHERE ID=?");
            $minusqty2->bindParam(1,$qty);
            $minusqty2->bindParam(2,$id);
            $minusqty2->execute();
            //insert order to basket                   
            $insorder2=$con->prepare("INSERT INTO basket (productID, username, qty) VALUE (?,?,?)");
            $insorder2->bindParam(1,$id);
            $insorder2->bindParam(2,$u);
            $insorder2->bindParam(3,$qty);
            $insorder2->execute();

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