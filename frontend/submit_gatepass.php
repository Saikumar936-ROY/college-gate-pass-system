<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "college_gatepass");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch form data
$name = $_POST['name'];
$roll_number = $_POST['roll_number'];
$class_branch = $_POST['class_branch'];
$attendance = $_POST['attendance'];
$reason = $_POST['reason'];
$exit_time = $_POST['exit_time'];
$parent_phone = $_POST['parent_phone'];

// Insert into database
$sql = "INSERT INTO gatepass_requests (name, roll_number, class_branch, attendance, reason, exit_time, parent_phone, status) 
        VALUES ('$name', '$roll_number', '$class_branch', '$attendance', '$reason', '$exit_time', '$parent_phone', 'Pending')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Gate Pass Request Submitted Successfully!'); window.location.href='gatepass_request.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
