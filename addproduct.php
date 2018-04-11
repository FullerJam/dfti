<?php

    include("functions.php");
    $con = connect();

    $prodname = $_POST["prodname"];
    $manu = $_POST["manu"];
    $desc = $_POST["desc"];
    $price = $_POST["price"];
    $stocklvl = $_POST["stocklvl"];
    $ageres = $_POST["ageres"];

    $insert=$con->query("INSERT INTO products (name, manufacturer, description, price, stocklevel, agelimit) VALUE ('$prodname', '$manu', '$desc', '$price','$stocklvl','$ageres');");
    $results=$insert->fetch();
    
    if ($insert){
        echo"<h4>Product added to database</h4>";

        $newprod=$con->query("SELECT * FROM products WHERE name='$prodname'");
        $row=$newprod->fetch();

        echo "<p>";
        echo " Product ID: ".$row["ID"]."<br/>";
        echo " Product: ".$row["name"]."<br/> ";
        echo " Manufacturer: ".$row["manufacturer"]."<br/> ";
        echo " Description: ".$row["description"]."<br/> ";
        echo " Price: ".$row["price"]."<br/> ";
        echo " Age restriction: ".$row["agelimit"]."<br/> "; 
        echo "</p>";
        

    }else{
        echo "something went wrong";
        echo $con->errorInfo()[2]; //2	Driver-specific error message. found on php.com
    }

?>