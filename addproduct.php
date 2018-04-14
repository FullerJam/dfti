<?php

    include("functions.php");
    $con = connect();

    $prodname = htmlentities($_POST["prodname"]); //$variable=htmlentities($_GET[""]);
    $manu = htmlentities($_POST["manu"]);
    $desc = htmlentities($_POST["desc"]);
    $price = htmlentities($_POST["price"]);
    $stocklvl = htmlentities($_POST["stocklvl"]);
    $ageres = htmlentities($_POST["ageres"]);

    $insert=$con->prepare("INSERT INTO products (name, manufacturer, description, price, stocklevel, agelimit) VALUE (?, ?, ?, ?, ?, ?);");
    $insert->bindParam(1,$prodname);
    $insert->bindParam(2,$manu);
    $insert->bindParam(3,$desc);
    $insert->bindParam(4,$price);
    $insert->bindParam(5,$stocklvl);
    $insert->bindParam(6,$ageres);
    $insert->execute();
    $results=$insert->fetch();
    
    if ($insert){
        echo"<h4>Product added to database</h4>";

        $newprod=$con->prepare("SELECT * FROM products WHERE name=?");
        $newprod->bindParam(1,$prodname);
        $newprod->execute();
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