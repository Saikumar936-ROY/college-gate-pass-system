<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "Saikumar@123", "gate_pass_system");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$student_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT * FROM passes WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
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
    <div class="header">
        <h1>College Gate Pass System</h1>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></h1>
        <h2>Your Gate Passes</h2>
        <?php if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Request Date</th>
                    <th>Exit Time</th>
                    <th>Attendance %</th>
                    <th>Parent Phone</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["request_date"]); ?></td>
                        <td><?php echo htmlspecialchars($row["exit_time"] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row["attendance_percentage"] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row["parent_phone"] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row["status"]); ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No gate pass requests found.</p>
        <?php } ?>
        <a href="request_pass.php" class="btn btn-secondary">Request New Pass</a>
    </div>
    <div class="loading">Loading...</div>
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>