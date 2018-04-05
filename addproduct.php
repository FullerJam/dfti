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
        echo"Product added to database";
    }else{
        echo "something went wrong";
        echo $con->errorInfo()[2]; //2	Driver-specific error message. found on php.com
    }

?>