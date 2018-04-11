<?php
include('functions.php');//include all code from selected file
$search = htmlentities($_GET["search"]);
$con = connect(); // function wrtten in functions.php, log as a variable or you access the database an infinite number of times

if (strlen($search)<=1){ //checks string length is more than or equal to 1
    echo "Please enter more than one character";
}
else {

$results = $con->query("SELECT * FROM products WHERE name LIKE '$search%'"); // delivers all results similar to the string so far using wildcard %
$row = $results->fetch();

// If $row is equal to the value "false", display an error
if ($row == false) 
{
    echo "No matching rows!";
}

else
{
    $i=0;

    while($row != false)
    {
        
        echo "<p>";
        echo "<input type='hidden' name='ID' value=".$row["ID"]."/>";
        echo " Name: ".$row["name"]."<br/> ";
        echo " Manufacturer: ".$row["manufacturer"]."<br/> " ; 
        echo " Description: " .$row["description"]. "<br/>" ; 
        echo " Price ".$row["price"]."<br/>" ; 
        echo " Stock ".$row["stocklevel"]."<br/>" ;
        echo "Age Resitriction <span id='agelimit".$row["ID"]."'>".$row["agelimit"]."</span><br/>";
        echo "</p>";
        echo "<label>Amount </label>";
        echo "<input type='number' value='1' id='qty".$row["ID"]."' min='1' max='200'><br/>";
        echo "<a href='#' onclick='atb(".$row["ID"].");ajaxrequest();'>Add to Basket</a>";  // call ajax request to refresh search results
        /*
        echo "<a href='download.php?songID=".$row["ID"]."'>Download</a><br/>";
        echo "<a href='https://www.youtube.com/results?search_query=".$row["artist"]." ".$row["title"]."'>Listen to the song on Youtube!</a> <br/>";
        echo "<a href='order1.php?songID=".$row["ID"]."'>Order a copy</a>";
        $row = $results->fetch();
        */
        $row = $results->fetch();
        $i++; //increase the variable value by one each time the loop runs
    }
    echo "<h4>Your search returned ".$i." result/results</h4>";
}
}
//print_r($con->errorInfo()); //errorInfo() returns an array with three members
                            //print_r() prints the entire contents of an array

?>
