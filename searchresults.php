<?php
include('functions.php');//include all code from selected file
$search = htmlentities($_GET["search"]);
$con = connect(); // function wrtten in functions.php, log as a variable or you access the database an infinite number of times

if (strlen($search)<=1){ //checks string length is more than or equal to 1
    echo "Please enter more than one character";
}
else {
$searchbp="%$search%";//converts varibale for use in bind param
$results = $con->prepare("SELECT * FROM products WHERE name LIKE ?"); // delivers all results similar to the string so far using wildcard %
$results->bindParam(1,$searchbp);
$results->execute();
$row = $results->fetch();

// If $row is equal to the value "false", display an error
if ($row == false) 
{
    echo "No matching rows!";
}

else
{
   
    
    $i=0; // no# of search results feedback query 
    
    while($row != false)
    {
        $results2=$con->prepare("SELECT * FROM products WHERE id=?");
        $results2->bindParam(1,$row["ID"]);
        $results2->execute();
        
        $row2=$results2->fetch();
        
        $av=$row2["av_raters"];
        if ($av<1){
            $stars="No current rating";
        }
        else if($av>=1 && $av <=1.99){
            $stars="★";
        }
        else if($av>=2 && $av <=2.99){
            $stars="★★";
        }
        else if($av>=3 && $av <=3.99){
            $stars="★★★";
        }
        else if($av>=4 && $av <=4.99){
            $stars="★★★★";
        }
        else if($av>=5){
            $stars="★★★★★";
        }

        $i++; //increase the variable value by one each time the loop runs, for search result query and form
        echo "<p>";
        echo "<input type='hidden' name='ID' value=".$row["ID"]."/>";
        echo " Name: ".$row["name"]."<br/> ";
        echo " Manufacturer: ".$row["manufacturer"]."<br/> "; 
        echo " Description: " .$row["description"]. "<br/>"; 
        echo " Price: ".$row["price"]."<br/>"; 
        echo " Stock: ".$row["stocklevel"]."<br/>";
        echo " Avg Rating: <span id='stars'>".$stars."</span><br>";//add rating
        echo "Age Resitriction <span id='agelimit".$row["ID"]."'>".$row["agelimit"]."</span><br/>";
        echo "</p>";
        echo "<form>";
        echo "<fieldset class='rating'>
              <legend>Rate this product</legend>
              <input type='hidden' value=".$row["ID"]."> 
              <input type='radio' name='radAnswer' onclick='sendRating(".$row["ID"].",1)'/><label>1☆</label> 
              <input type='radio' name='radAnswer' onclick='sendRating(".$row["ID"].",2)'/><label>2☆</label>
              <input type='radio' name='radAnswer' onclick='sendRating(".$row["ID"].",3)'/><label>3☆</label>
              <input type='radio' name='radAnswer' onclick='sendRating(".$row["ID"].",4)'/><label>4☆</label>
              <input type='radio' name='radAnswer' onclick='sendRating(".$row["ID"].",5)'/><label>5☆</label>
              </fieldset>";// scrapped refresh setTimeout(function() {ajaxrequest()}, 1000); called ajaxrequest in responseRecieved
        echo "</form>";        
        echo "<label>Amount </label>";
        echo "<input type='number' value='1' id='qty".$row["ID"]."' min='1' max='200'><br/><br>";
        echo "<a href='javascript:void(null);' onclick='atb(".$row["ID"].")'> Add to Basket</a><br>"; 
        echo "-------------------"; 
        //javascript:void(null); cancels default action for link stopping page from scrolling to top
        //'showproduct("variable1","variable2")'
        $row = $results->fetch();
       
    }
    echo "<h4>Your search returned ".$i." result/results</h4>"; // feedback information from variable
}
}
//print_r($con->errorInfo()); //errorInfo() returns an array
//print_r() //prints the entire contents of an array

//https://dev.mysql.com/doc/refman/5.7/en/insert-on-duplicate.html

//$con->query()("INSERT INTO userratings (username,productID,userRating) VALUES (1,2,3) ON DUPLICATE KEY UPDATE userRating"); 

?>
