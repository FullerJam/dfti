<?php
session_start();
// Test that the authentication session variable exists

if ($_SESSION["isadmin"] = 0){
    header("refresh:5 url=login.html");
    echo "Area restricted, admin access only.";
}
   
else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #wrapper{
            width:100%;
            line-height:1.6;
            padding:1em;
            font-family: "helvetica";
        }
        #response { 
            background-color: #b2ffaf;
            width:500px;
            padding:10px;
        }

    </style>
    <script>
         function ajaxrequest(){
        // Create the XMLHttpRequest variable.
        var xhr2 = new XMLHttpRequest();
        // This variable represents the AJAX communication between client and
        // server.
        //var xhr2 = new XMLHttpRequest(); -- now declared globally, BIG MISTAKE, MULTIPLIED EVENTLISTENERS.. EVENT LISTERNS
        // SHOULD BE DECLARED LOCALLY 
        
        // Specify the CALLBACK function. 
        // When we get a response from the server, the callback function will run
        xhr2.addEventListener ("load", responseReceived);
        // Open the connection to the server
        // We are sending a request to "flights.php" and passing in the 
        // destination and date as a query string. 
        xhr2.open('POST', 'addproduct.php');
        // Send the request.
        xhr2.send();
    }

    function responseReceived(e){
        document.getElementById('response').innerHTML = e.target.responseText;
    }
    </script>
</head>
<body>
    
    <div id="wrapper">
        <h1>Welcome to the admin portal</h1>
        
        <title>Add new product</title>
        <div class="container">
            <div class="info">
                <h3>Add a product</h3>
            </div>
            <div class="form-container">
                <form method="post" onsubmit="ajaxrequest()">
                    <label>Product name</label>
                    <br/>
                    <input type="text" name="prodname">
                    <br/>
                    <label>Manufacturer</label>
                    <br/>
                    <input type="text" name="manu">
                    <br/>
                    <label>Description</label>
                    <br/>
                    <input type="text" name="desc">
                    <br/>
                    <label>Price</label>
                    <br/>
                    <input type="number" name="price" step="any"><!-- step attribute 'any' allows decimal places -->
                    <br/>
                    <label>Stock level</label>
                    <br/>
                    <input type="number" name="stocklvl">
                    <br/>
                    <label>Age Restriction</label>
                    <select name="ageres" id="ageres">
                        <option value="0">0</option>
                        <option value="12">12</option>
                        <option value="15">15</option>
                        <option value="18">18</option>
                    </select>
                    <br/>
                    <input type="submit" value="submit">
                </form>
            </div> <!-- form-container end -->
        </div> <!-- container end -->
    </div> <!-- wrapper end -->

<div id="response"></div>

</body>
</html>

<?php
}
?>