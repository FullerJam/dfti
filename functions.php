<?php

function connect(){
    $conn = new PDO ("mysql:host=localhost;dbname=assign011;","root","");
    return $conn;
}

?>