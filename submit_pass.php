<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("127.0.0.1:3307", "root", "Saikumar@123", "gate_pass_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_SESSION["user_id"];
$exit_time = $_POST["exit_time"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($exit_time)) {
    // Use prepared statement to insert data
    $stmt = $conn->prepare("INSERT INTO passes (student_id, exit_time) VALUES (?, ?)");
    $stmt->bind_param("is", $student_id, $exit_time);

    if ($stmt->execute()) {
        header("Location: student_dashboard.php");
        exit();
    } else {
        die("Error inserting pass request: " . $conn->error);
    }
} else {
    die("Invalid request or missing exit time.");
}

$stmt->close();
$conn->close();
?>