<?php
            session_start();
            // Test that the authentication session variable exists
            if ( !isset ($_SESSION["ssuser"]))
            {
                header( "refresh:3;url=login.html" );
                echo "<body>You're not logged in. Go away!</body>";
            }
            else
            {
                echo "<body>You are logged in as ".$_SESSION["ssuser"]."</body>"; 
                
              ?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body onload="basketOnLoad()"> <!-- loads content of basket based on user -->
    <div class="backdrop"></div>
    <div class="modal"></div>
    <div class="wrapper">   
        <nav>
            <h1>SOLENT STORES</h1>
            <ul>
                <li><a href="#" onclick="showShelves()">+ProductList</a></li>
                <li><a href="#" onclick="hideShelves()">-ProductList</a></li>
                <li><a href='adminportal.php'>Admin Area</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <br><br>
        <input type="text" id="search" name="search" placeholder="Search.." onkeyup="ajaxrequest()">
        <div id="shelves"></div>
        <div id="response"></div>
        <h2>Basket</h2>
        <div id="basket"></div>
        <!-- <button id="purchase"onclclick="openModal()">Purchase</button> -->
    </div> <!-- wrapper end -->



<script src="main.js"></script>
</body>
</html>
<?php
}
?>