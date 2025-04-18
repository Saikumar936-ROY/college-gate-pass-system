<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "Saikumar@123", "gate_pass_system");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$student_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT name, branch, parent_phone FROM students WHERE id = ?");
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
    <style>
        .error {
            color: red;
            font-size: 0.8em;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>College Gate Pass System</h1>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h1>Request a Gate Pass</h1>
        <form action="submit_pass.php" method="POST" onsubmit="return validateForm()">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" readonly>
            <label for="branch">Branch:</label>
            <input type="text" id="branch" name="branch" value="<?php echo htmlspecialchars($student['branch']); ?>" readonly>
            <label for="parent_phone">Parent's Phone:</label>
            <input type="text" id="parent_phone" name="parent_phone" value="<?php echo htmlspecialchars($student['parent_phone']); ?>" readonly>
            <label for="attendance">Attendance %:</label>
            <input type="number" id="attendance" name="attendance" min="0" max="100" step="0.1" placeholder="Enter Attendance %" required>
            <span id="attendance-error" class="error"></span>
            <label for="is_emergency">Emergency Request:</label>
            <input type="checkbox" id="is_emergency" name="is_emergency" value="1">
            <span style="font-size: 0.9em; color: #555;">Check if this is an emergency (allows submission below 75% attendance)</span>
            <label for="reason">Reason for Leaving:</label>
            <input type="text" id="reason" name="reason" placeholder="Enter reason for leaving" required>
            <label for="exit_time">Exit Time:</label>
            <input type="datetime-local" id="exit_time" name="exit_time" required>
            <button type="submit" class="btn">Submit Request</button>
        </form>
        <a href="student_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    <div class="loading">Submitting...</div>
    <script>
        function validateForm() {
            let isValid = true;
            // Attendance validation
            const attendance = document.getElementById('attendance').value;
            const isEmergency = document.getElementById('is_emergency').checked;
            const attendanceError = document.getElementById('attendance-error');
            if (attendance < 0 || attendance > 100 || isNaN(attendance)) {
                attendanceError.textContent = 'Attendance must be between 0 and 100%';
                isValid = false;
            } else if (attendance < 75 && !isEmergency) {
                attendanceError.textContent = 'Attendance below 75% requires an emergency request';
                isValid = false;
            } else {
                attendanceError.textContent = '';
            }
            // Show loading only if valid
            if (isValid) {
                document.querySelector('.loading').classList.add('show');
            }
            return isValid;
        }
    </script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>