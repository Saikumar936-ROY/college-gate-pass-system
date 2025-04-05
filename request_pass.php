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

// Fetch student details
$stmt = $conn->prepare("SELECT name, class, branch, attendance_percentage, parent_phone FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Gate Pass</title>
    <link rel="stylesheet" href="./frontend/style.css">
</head>
<body>
    <div class="container">
        <h1>Request a Gate Pass</h1>
        <form action="submit_pass.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" readonly>

            <label for="class">Class:</label>
            <input type="text" id="class" name="class" value="<?php echo htmlspecialchars($student['class']); ?>" readonly>

            <label for="branch">Branch:</label>
            <input type="text" id="branch" name="branch" value="<?php echo htmlspecialchars($student['branch']); ?>" readonly>

            <label for="attendance">Attendance %:</label>
            <input type="number" id="attendance" name="attendance" value="<?php echo htmlspecialchars($student['attendance_percentage']); ?>" readonly>

            <label for="parent_phone">Parent's Phone:</label>
            <input type="tel" id="parent_phone" name="parent_phone" value="<?php echo htmlspecialchars($student['parent_phone']); ?>" readonly>

            <label for="exit_time">Exit Time:</label>
            <input type="datetime-local" id="exit_time" name="exit_time" required>

            <button type="submit" class="login-btn">Submit Request</button>
        </form>
        <a href="student_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>