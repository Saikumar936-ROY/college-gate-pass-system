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

// Use prepared statement to prevent SQL injection
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
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></h1>
        <h2>Your Gate Passes</h2>
        <?php if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Request Date</th>
                    <th>Exit Time</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["request_date"]); ?></td>
                        <td><?php echo htmlspecialchars($row["exit_time"] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row["status"]); ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No gate pass requests found.</p>
        <?php } ?>
        <a href="request_pass.php">Request New Pass</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>