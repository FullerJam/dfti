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
            width:500px;
            padding:10px;
            }
        #basket {
            background-color: #EFFF00;
            width:500px;
            padding:10px;
        }
        #link {
            float:right;
        }
        #purchase{
            float:right;
            padding:10px;
        }
        #search{
            margin:10px;
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
        //console.log(id);// uncomment to see if values are being passed through
        var xhr2 = new XMLHttpRequest();
        xhr2.open('GET', 'removefb.php?ID='+id);
        xhr2.addEventListener ("load", responseAlert);
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
    }

    </script>
</head>
<body onload="basketOnLoad()"> <!-- loads content of basket based on user -->
    

    <div class="wrapper">

        <header>
            <h1>SOLENT GENERAL StORES</h1>
        </header>
        </br>
        <input type="text" id="search" name="search" placeholder="Search.." onkeyup="ajaxrequest()"></br>
        <div id="response"></div>
        <h2>Basket</h2>
        <div id="basket"></div>

    </div> <!-- wrapper end -->


</body>
</html>
<?php
}
?>