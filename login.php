<?php
session_start();
if (isset($_SESSION["user_id"])) {
    header("Location: student_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./frontend/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="glass-card">
            <h2 class="title">Welcome to Gate Pass System</h2>
            <form action="authenticate.php" method="POST">
                <div class="input-group">
                    <label for="email">Username</label>
                    <input type="text" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="student">Student</option>
                        <option value="hod">HOD</option>
                        <option value="gatekeeper">Gatekeeper</option>
                    </select>
                </div>
                <button type="submit" class="btn primary-btn">Login</button>
            </form>
        </div>
    </div>
</body>
</html>