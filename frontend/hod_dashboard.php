<?php
session_start();
if (!isset($_SESSION['hod_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashboard | Gate Pass System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h2>HOD Dashboard</h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </header>

        <main>
            <section class="approval-section">
                <h3>Pending Gate Pass Requests</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Student Name</th>
                            <th>Reason</th>
                            <th>Exit Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Fetch pending requests from the database -->
                        <tr>
                            <td>001</td>
                            <td>John Doe</td>
                            <td>Medical Emergency</td>
                            <td>2:00 PM</td>
                            <td>
                                <button class="approve-btn">Approve</button>
                                <button class="reject-btn">Reject</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
