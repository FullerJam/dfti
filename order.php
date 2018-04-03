<?php
    include('functions.php');
    $con = connect();
    $id=$_GET["ID"];
    $results = $con->query("SELECT stocklevel FROM products WHERE ID='$id'");
    $row = $results->fetch();
    
    
    // If the form was posted, process it...
    // If statement stops php running until qty value has been input
    if (isset($_POST["qty"]))
    {
        $qty=$_POST["qty"];
        $id=$_POST["ID"];
        $resultsUpdate = $con->query("UPDATE products SET stocklevel=stocklevel-'$qty' WHERE ID='$id'");

        $orderQuantity=$con->query("SELECT stocklevel From products where ID='$id'");
        $row2=$orderQuantity->fetch(); //added another database connection to fetch new quantity value
        echo "Order sucessfull, '$qty' order has been added to basket";
        echo "<p>".$row2['stocklevel']." products remaining</p>";
        echo "<a href='index.php' class='center'>Back to search</a>";
    }
    // otherwise, read the ID from the query string and put the ID
    // in the hidden field in the form...
    else 
    {
    
    $id= $_GET["ID"];
    
    echo   "<head><link rel='stylesheet' type='text/css' href='styles.css'></head>
            <form method='post' action='order.php?ID=".$id."'>
                <input type='hidden' name='ID' value='$id'/> 
                <label>Enter order quantity</label><br/>
                <input type='number' name='qty'>
                <input type='submit' value='Order'>
            </form>";
            echo "<p class='center'>".$row['stocklevel']." items left in stock</p>";
           // 'download.php?songID=".$row["ID"]."'>Download</a><br/>"
    }
    //added a query string to form action so that number of copies can be updated on 
    //final load, didnt work consult nick
    ?>
    
