<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "hod") {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "Saikumar@123", "gate_pass_system");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$stmt = $conn->prepare("SELECT p.id, s.name, s.branch, p.exit_time, p.attendance_percentage, p.parent_phone, p.reason, p.status FROM passes p JOIN students s ON p.student_id = s.id WHERE p.status = 'pending'");
$stmt->execute();
$result = $stmt->get_result();

// Handle success/error message from redirect
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashboard</title>
    <link rel="stylesheet" href="./frontend/style.css">
</head>
<body>
    <div class="header">
        <h1>College Gate Pass System</h1>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></h1>
        <?php if ($success): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php elseif ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <h2>Pending Gate Pass Requests</h2>
        <?php if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Branch</th>
                    <th>Exit Time</th>
                    <th>Attendance %</th>
                    <th>Parent Phone</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["branch"]); ?></td>
                        <td><?php echo htmlspecialchars($row["exit_time"] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row["attendance_percentage"] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row["parent_phone"] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row["reason"] ?? 'N/A'); ?></td>
                        <td>
                            <form action="notify_status.php" method="POST" style="display:inline;">
                                <input type="hidden" name="pass_id" value="<?php echo htmlspecialchars($row["id"]); ?>">
                                <button type="submit" name="status" value="approved" class="btn btn-secondary" style="margin-right: 10px;">Approve</button>
                                <button type="submit" name="status" value="rejected" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No pending requests found.</p>
        <?php } ?>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>