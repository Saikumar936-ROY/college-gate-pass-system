<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "Saikumar@123", "gate_pass_system");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$student_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT name FROM students WHERE id = ?");
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
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="./frontend/style.css">
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <h3>Menu</h3>
            <ul>
                <li><a href="request_pass.php">Request Pass</a></li>
                <li><a href="pass_history.php">Pass History</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <h2>Welcome, <?php echo htmlspecialchars($student['name']); ?></h2>
            <div class="bento-grid">
                <div class="bento-item">Pending Requests: 2</div>
                <div class="bento-item">Approved: 5</div>
                <div class="bento-item"><a href="request_pass.php" class="btn primary-btn">Quick Request</a></div>
            </div>
        </main>
    </div>
    <script>
        // Mobile sidebar toggle (add button in HTML if needed)
        document.querySelector('.sidebar').addEventListener('click', function() {
            this.classList.toggle('active');
        });
    </script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>