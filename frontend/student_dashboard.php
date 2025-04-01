<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | Gate Pass System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <h2>Gate Pass System</h2>
            <ul>
                <li><a href="#" class="active">Dashboard</a></li>
                <li><a href="#">Request Gate Pass</a></li>
                <li><a href="#">Request History</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="dashboard-main">
            <header>
                <h2>Welcome, Student</h2>
                <a href="logout.php" class="logout-btn">Logout</a>
            </header>

            <!-- Request Gate Pass -->
            <section class="request-section">
                <h3>Request Gate Pass</h3>
                <form action="submit_request.php" method="POST">
                    <label for="reason">Reason for Leaving:</label>
                    <input type="text" name="reason" required>

                    <label for="exit_time">Requested Exit Time:</label>
                    <input type="time" name="exit_time" required>

                    <button type="submit" class="request-btn">Submit Request</button>
                </form>
            </section>

            <!-- Request History -->
            <section class="status-section">
                <h3>Your Requests</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Reason</th>
                            <th>Exit Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data from database -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>

</body>
</html>
