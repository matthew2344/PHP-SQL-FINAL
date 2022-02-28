<?php
    define("LOCALHOST","localhost");
    define("USERNAME","root");
    define("PASSWORD","");
    define("DATABASE","");

    // Create connection
    $conn = new mysqli(LOCALHOST, USERNAME, PASSWORD, DATABASE);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
        
    } 


?>