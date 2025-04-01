<?php
$host = "localhost"; 
$username = "root";  
$password = "";  // Default password for XAMPP is empty
$database = "college_gate_pass";  // Change this to your actual database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
