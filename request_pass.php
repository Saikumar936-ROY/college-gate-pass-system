<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "Saikumar@123", "gate_pass_system");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$student_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT name, branch FROM students WHERE id = ?");
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script>
        function restrictAttendance() {
            var attendanceInput = document.getElementById("attendance");
            var value = attendanceInput.value.replace(/[^0-9]/g, '');
            if (value.length > 3) {
                value = value.slice(0, 3);
            }
            if (parseInt(value) > 100) {
                value = "100";
            }
            attendanceInput.value = value;
        }

        function validateAttendance(event) {
            var attendance = document.getElementById("attendance").value;
            console.log("Validating attendance: " + attendance);
            if (attendance === "" || isNaN(attendance) || attendance < 0 || attendance > 100 || attendance.length > 3) {
                alert("Attendance must be a number between 0 and 100 (max 3 digits)!");
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <header class="header">
        <h1 class="logo">College Gate Pass</h1>
        <a href="logout.php" class="logout-btn">Logout <span class="material-icons">logout</span></a>
    </header>
    <div class="container">
        <section class="hero">
            <video autoplay muted loop class="hero-video">
                <source src="path/to/gate-video.mp4" type="video/mp4">
            </video>
            <h1>Request Your Gate Pass</h1>
        </section>
        <div class="glass-card">
            <h2>Request a Gate Pass</h2>
            <form action="submit_pass.php" method="POST" onsubmit="return validateAttendance(event)">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" readonly>
                </div>
                <div class="input-group">
                    <label for="branch">Branch</label>
                    <input type="text" id="branch" name="branch" value="<?php echo htmlspecialchars($student['branch']); ?>" readonly>
                </div>
                <div class="input-group">
                    <label for="attendance">Attendance %</label>
                    <input type="number" id="attendance" name="attendance" min="0" max="100" step="1" placeholder="Enter Attendance %" required oninput="restrictAttendance()">
                </div>
                <div class="input-group">
                    <label for="parent_phone">Parent's Phone</label>
                    <input type="tel" id="parent_phone" name="parent_phone" placeholder="Enter Parent's Phone" required>
                </div>
                <div class="input-group">
                    <label for="reason">Reason for Leaving</label>
                    <input type="text" id="reason" name="reason" placeholder="Enter reason for leaving" required>
                </div>
                <div class="input-group">
                    <label for="exit_time">Exit Time</label>
                    <input type="datetime-local" id="exit_time" name="exit_time" required>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn primary-btn">Submit</button>
                    <a href="student_dashboard.php" class="btn secondary-btn">Back</a>
                </div>
            </form>
        </div>
    </div>
    <div class="loading">Submitting...</div>
    <script>
        function showLoading() {
            document.querySelector('.loading').classList.add('show');
        }
        document.querySelector('form').addEventListener('submit', function(event) {
            if (!validateAttendance(event)) {
                event.preventDefault();
            } else {
                showLoading();
            }
        });
    </script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>