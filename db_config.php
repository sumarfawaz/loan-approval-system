<?php
$servername = "127.0.0.1";
$username = "root";
$password = "1234";
$database = "loan_approval_db";

// Create a database connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());  
}
?>
