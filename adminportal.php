<?php
session_start();
// Test that the authentication session variable exists

if ($_SESSION["isadmin"] == 0){ //had to be == not sure why, research.
    header("refresh:4 url=index.html");
    echo "Area restricted, admin access only.";
    echo "<h5><a href='index.php'>Back to store</a></h5>";
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
    //https://developer.mozilla.org/en-US/docs/Learn/HTML/Forms/Sending_forms_through_JavaScript
        window.addEventListener("load", function () {

            function ajaxrequest(){
                // Create the XMLHttpRequest variable.
                var xhr2 = new XMLHttpRequest();
                // This variable represents the AJAX communication between client and
                // server.
                
                //var xhr2 = new XMLHttpRequest(); -- now declared globally, BIG MISTAKE, MULTIPLIED EVENTLISTENERS.. 
            
                var FD = new FormData(form);

                // Specify the CALLBACK function. 
                // When we get a response from the server, the callback function will run
                xhr2.addEventListener("load", responseReceived);

                xhr2.addEventListener("error", function(event){
                alert('Something went wrong');
                });

                // Open the connection to the server
                xhr2.open('POST', 'addproduct.php');
                // Send the request.
                xhr2.send(FD);
            }
            //access form element
            var form = document.getElementById("prodform");

            //prevent submits default action
            form.addEventListener("submit", function(event){
                event.preventDefault();
            
                ajaxrequest();
            });
        });
        
        function responseReceived(e){
            document.getElementById('response').innerHTML = e.target.responseText;
        }
    </script>
</head>
<body>
    
    <div id="wrapper">
        <h1>ADMIN PORTAL</h1>
        
        <title>Add new product</title>
        <div class="container">
            <div class="info">
                <h3>Add a product</h3>
            </div>
            <div class="form-container">
                <form id="prodform">
                    <label>Product name</label>
                    <br/>
                    <input type="text" name="prodname" required>
                    <br/>
                    <label>Manufacturer</label>
                    <br/>
                    <input type="text" name="manu" required>
                    <br/>
                    <label>Description</label>
                    <br/>
                    <input type="text" name="desc" required>
                    <br/>
                    <label>Price</label>
                    <br/>
                    <input type="number" name="price" step="any" required><!-- step attribute 'any' allows decimal places -->
                    <br/>
                    <label>Stock level</label>
                    <br/>
                    <input type="number" name="stocklvl" required>
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
        <div id="response"></div> <!-- where ajax response will be shown -->
        <h5><a href="index.php">Back to store</a></h5>
    </div> <!-- wrapper end -->



</body>
</html>

<?php
}
?>