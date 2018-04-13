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
    
    $a=1;
    $b=2;
    $c=3;
    $d=4;
    $e=5;
    while($row != false)
    {
        $i++; //increase the variable value by one each time the loop runs, for search result query and form
        echo "<p>";
        echo "<input type='hidden' name='ID' value=".$row["ID"]."/>";
        echo " Name: ".$row["name"]."<br/> ";
        echo " Manufacturer: ".$row["manufacturer"]."<br/> " ; 
        echo " Description: " .$row["description"]. "<br/>" ; 
        echo " Price ".$row["price"]."<br/>" ; 
        echo " Stock ".$row["stocklevel"]."<br/>" ;
        echo " Avg Rating <br>";//add rating
        echo "Age Resitriction <span id='agelimit".$row["ID"]."'>".$row["agelimit"]."</span><br/>";
        echo "</p>";
        echo "<form>";
        echo "<fieldset class='rating'>
              <legend>Rate this product</legend>
              <input type='hidden' value=".$row["ID"].">
              <input type='radio' name='radAnswer'id='rating' onclick='sendRating(".$row["ID"].")'value='1'/><label>1☆</label>
              <input type='radio' name='radAnswer'id='rating' onclick='sendRating(".$row["ID"].")'value='2'/><label>2☆</label>
              <input type='radio' name='radAnswer'id='rating' onclick='sendRating(".$row["ID"].")'value='3'/><label>3☆</label>
              <input type='radio' name='radAnswer'id='rating' onclick='sendRating(".$row["ID"].")'value='3'/><label>4☆</label>
              <input type='radio' name='radAnswer'id='rating' onclick='sendRating(".$row["ID"].")'value='5'/><label>5☆</label>
              </fieldset>";
        echo "</form>";        
        echo "<label>Amount </label>";
        echo "<input type='number' value='1' id='qty".$row["ID"]."' min='1' max='200'><br/>";
        echo "<a href='#' onclick='atb(".$row["ID"].")'>Add to Basket</a><br>";  // refreshs searchresults after 1s, I imagine this is bad practice but it works
        
        //'showproduct("variable1","variable2")'
        $row = $results->fetch();
       
    }
    echo "<h4>Your search returned ".$i." result/results</h4>"; // feedback information from variable
}
}
//print_r($con->errorInfo()); //errorInfo() returns an array with three members
//print_r() prints the entire contents of an array

//https://dev.mysql.com/doc/refman/5.7/en/insert-on-duplicate.html

//$con->query()("INSERT INTO userratings (username,productID,userRating) VALUES (1,2,3) ON DUPLICATE KEY UPDATE userRating"); 

?>
