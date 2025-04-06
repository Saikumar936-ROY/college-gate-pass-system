<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "gatekeeper") {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("127.0.0.1:3307", "root", "Saikumar@123", "gate_pass_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch approved passes
$stmt = $conn->prepare("SELECT p.id, s.name, s.branch, p.exit_time, p.attendance_percentage, p.parent_phone, p.status FROM passes p JOIN students s ON p.student_id = s.id WHERE p.status = 'approved' AND (p.verification_status IS NULL OR p.verification_status != 'verified')");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatekeeper Dashboard</title>
    <link rel="stylesheet" href="./frontend/style.css">
</head>
<body>
    <div class="header">
        <h1>College Gate Pass System</h1>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></h1>
        <h2>Approved Gate Pass Verifications</h2>
        <?php if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Branch</th>
                    <th>Exit Time</th>
                    <th>Attendance %</th>
                    <th>Parent Phone</th>
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
                        <td>
                            <form action="verify_pass.php" method="POST" style="display:inline;">
                                <input type="hidden" name="pass_id" value="<?php echo htmlspecialchars($row["id"]); ?>">
                                <button type="submit" class="btn btn-secondary">Verify</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No approved passes to verify.</p>
        <?php } ?>
        <h3>Manual Verification</h3>
        <form action="verify_pass.php" method="POST">
            <label for="pass_id">Enter Pass ID:</label>
            <input type="number" id="pass_id" name="pass_id" required placeholder="Enter Pass ID">
            <button type="submit" class="btn">Verify Manually</button>
        </form>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>