<?php
 $server = "localhost";  // mysql
 $user = "ruslan";
 $password = "0000";
 $db = "test_db";
 
 $conn = new mysqli($server, $user, $password, $db);

// check if the connection was successful
// if (mysqli_connect_errno()) {    
//     die("Failed to connect to MySQL: " . mysqli_connect_error());
// } else { echo "Connection successful!"; }
?>
