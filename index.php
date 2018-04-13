<?php
            session_start();
            // Test that the authentication session variable exists
            if ( !isset ($_SESSION["ssuser"]))
            {
                header( "refresh:5;url=login.html" );
                echo "You're not logged in. Go away!";
            }
            else
            {
                echo "You are logged in as ".$_SESSION["ssuser"]; 
                
              ?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type='text/css'>
        body { 
            font-family: Calibri, DejaVu Sans, sans-serif; 
            }

        #response { 
            background-color: #b2ffaf;
            width:470px;
            padding:10px;
            }
        #basket {
            background-color: #EFFF00;
            width:470px;
            padding:10px;
        }
        #link {
            float:right;
        }
        #search{
            margin:20px 0 20px 0;
            display:block;
            height:30px;
        }
        #shelves{
            margin:5px 0 5px 0;
            background-color: #ff69b4;
            width:470px;
        }
        nav ul{
            list-style-type: none;
            padding: 0;
        }
        nav li {
            float: left;
        }


        nav li a {
            display: block;
            color: black;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #b2ffaf;
        }

        nav li a:hover{
            color: #ff69b4;
            background-color:#EFFF00;
        }

        nav li a:first-of-type {
            padding-left: 5px;
        }

        nav li a:last-of-type {
            padding-right: 5px;            
        }
        
        

        /*intense css

        .rating {
            unicode-bidi: bidi-override;
            float:left;
            direction: rtl;
        }
        .rating > span {
            display: inline-block;
            position: relative;
            width: 1.1em;
        }
        .rating > span:hover,
        .rating > span:hover ~ span {
            color: transparent;
        }
        .rating > span:hover:before,
        .rating > span:hover ~ span:before {
            content: "\2605";
            position: absolute;
            left: 0; 
            color: gold;
        } 

        .rating {
        float:left;
        }
        
        .rating.userrating > span:hover:before,
        .rating.userrating > span:hover ~ span:before {
            color: blue;
        } 
        */

   
        fieldset{
            border:0;
            margin-left:0;
            padding:0;
        }
    </style>
    <script type='text/javascript'>


    function ajaxrequest(){
        // Create the XMLHttpRequest variable.
        var xhr2 = new XMLHttpRequest();
        // This variable represents the AJAX communication between client and
        // server.
            //var xhr2 = new XMLHttpRequest(); -- now declared globally, BIG MISTAKE, MULTIPLIED EVENTLISTENERS.. EVENT LISTERNS
            // SHOULD BE DECLARED LOCALLY 
        // Read the data from the form fields.
        var search = document.getElementById("search").value;
        
        // Specify the CALLBACK function. 
        // When we get a response from the server, the callback function will run
        xhr2.addEventListener ("load", responseReceived);
        // Open the connection to the server
        // We are sending a request to "flights.php" and passing in the 
        // destination and date as a query string. 
        xhr2.open('GET', 'searchresults.php?search='+search);
        
        // Send the request.
        xhr2.send();
    }


  
    function showShelves(){
        document.getElementById("shelves").style.display='block';
        var xhr2 = new XMLHttpRequest();
        xhr2.addEventListener("load", responseShelves);
        xhr2.open('GET', 'shelves.php');
        xhr2.send();
    }
    function hideShelves(){
        document.getElementById("shelves").style.display='none';
    }

    function basketOnLoad(){
        // Create the XMLHttpRequest variable.
        var xhr2 = new XMLHttpRequest();
        // This variable represents the AJAX communication between client and
        // server.
            //var xhr2 = new XMLHttpRequest(); -- now declared globally, BIG MISTAKE, MULTIPLIED EVENTLISTENERS.. EVENT LISTERNS
            // SHOULD BE DECLARED LOCALLY 
        // Read the data from the form fields.
        
        // Specify the CALLBACK function. 
        // When we get a response from the server, the callback function will run
        xhr2.addEventListener ("load", responseAlert);
        // Open the connection to the server
        // We are sending a request to "flights.php" and passing in the 
        // destination and date as a query string. 
        xhr2.open('GET', 'basketonload.php');
        // Send the request.
        xhr2.send();
    }

    
    //add to basket function
    function atb(id){
        var xhr2 = new XMLHttpRequest();
        var qty = document.getElementById('qty'+id).value;
        var agelimit = parseInt(document.getElementById('agelimit'+id).innerHTML);
         //use innerHTML to target values in html
        console.log(agelimit);
        xhr2.open('GET', 'basket.php?ID='+id+'&qty='+qty+'&agelimit='+agelimit);
        //console.log(id,qty); uncomment to see if values are being passed through
        xhr2.addEventListener ("load", responseAlert);
        xhr2.send(); 
    }
  
    //remove from basket function
    function rfb(id){
        //console.log(id);  //uncomment to see if values are being passed through
        var xhr2 = new XMLHttpRequest();
        xhr2.open('GET', 'removefb.php?ID='+id);
        xhr2.addEventListener ("load", responseAlert);
        xhr2.send(); 
    }

  function sendRating(id,rating) {
            console.log(id,rating);
            var xhr2 = new XMLHttpRequest();
            xhr2.addEventListener ("load",responseRecieved);
            xhr2.open('POST', 'ratings.php?rating='+rating+'&id='+id);
            xhr2.send();
        
    }

    // The callback function
    // It simply places the response from the server in the div with the ID
    // of 'response'.
    
    // The parameter "e" contains the original XMLHttpRequest variable as
    // "e.target".
    // We get the actual response from the server as "e.target.responseText"
    function responseReceived(e){
        document.getElementById('response').innerHTML = e.target.responseText;
    }
    function responseAlert(e){
        document.getElementById('basket').innerHTML = e.target.responseText;
        ajaxrequest();
    }
    function responseShelves(e){
        document.getElementById('shelves').innerHTML = e.target.responseText;
    }

    </script>
</head>
<body onload="basketOnLoad()"> <!-- loads content of basket based on user -->
    

    <div class="wrapper">

        <header>
            <h1>SOLENT GENERAL ST0RES</h1>
        </header>

        <nav>
            <ul>
                <li><a href="#" onclick="showShelves()">Show all products</a></li>
                <li><a href="#" onclick="hideShelves()">Hide products</a></li>
                <li><a href="#" onclick="ajaxrequest()">Refresh results</a></li>
                <li><a href='adminportal.php'>Admin portal</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <br><br>
        <input type="text" id="search" name="search" placeholder="Search.." onkeyup="ajaxrequest()"></br>
        <div id="shelves"></div>
        <div id="response"></div>
        <h2>Basket</h2>
        <div id="basket"></div>

    </div> <!-- wrapper end -->




</body>
</html>
<?php
}
?>