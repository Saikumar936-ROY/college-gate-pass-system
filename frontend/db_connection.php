<?php
$host = "127.0.0.1";  // Use IP instead of "localhost"
$username = "root";
$password = "Saikumar@123";
$database = "college_gate_pass";
$port = 3307; // Your MySQL port

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
