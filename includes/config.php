<?php
$toyyibpay_secret_key = 'fwoq2opp-a1gt-675j-1eb1-x9sqc6gsy6rd';
$category_code = '5wd5ufyw';
$base_url = 'http://localhost/Azliyana/';

$host = "localhost";
$user = "root";
$password = "";
$database = "db_homestay";

// Correct the variable name to $conn
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
