<?php
session_start();
// Test that the authentication session variable exists

if (!isset ($_SESSION["ssuser"])){
    header("refresh:5 url=login.html");
    echo "You're not logged in.";
}
else if (!isset ($_SESSION["isadmin"])){
    header("refresh:5 url=login.html");
    echo "Area restricted, admin access only.";
}
   
else{

?>







<?php
}
?>