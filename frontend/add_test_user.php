<?php
include("db_connection.php");

$email = "student@example.com";
$password = password_hash("student123", PASSWORD_DEFAULT); // Encrypt password
$role = "student";

$query = "INSERT INTO users (email, password, role) VALUES ('$email', '$password', '$role')";
mysqli_query($conn, $query);

echo "Test user added successfully!";
?>
