<?php
session_start();
if (!isset($_SESSION['gatekeeper_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatekeeper Dashboard | Gate Pass System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h2>Gatekeeper Dashboard</h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </header>

        <main>
            <section class="verification-section">
                <h3>Approved Requests for Exit</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Student Name</th>
                            <th>Exit Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Fetch approved requests from the database -->
                        <tr>
                            <td>001</td>
                            <td>John Doe</td>
                            <td>2:00 PM</td>
                            <td><button class="verify-btn">Mark as Exit</button></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
