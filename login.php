<?php
session_start(); // Start session at the beginning
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate Pass System - Login</title>
    <link rel="stylesheet" href="frontend\style.css"> <!-- Relative path -->
</head>
<body>
    <div class="container">
        <h1>Gate Pass System</h1>
        <?php if (isset($_SESSION["error"])) { ?>
            <p style="color: red;"><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></p>
        <?php } ?>

        <div class="login-wrapper">
            <!-- Student Login -->
            <div class="login-card">
                <img src="./icons/student-icon.png" alt="Student Icon" class="login-icon">
                <h2>Student Login</h2>
                <form action="authenticate.php" method="POST">
                    <label for="student-email">Email:</label>
                    <input type="email" id="student-email" name="email" placeholder="Enter Email" required>
                    <label for="student-password">Password:</label>
                    <input type="password" id="student-password" name="password" placeholder="Enter Password" required>
                    <input type="hidden" name="role" value="student">
                    <button type="submit" class="login-btn">Login</button>
                </form>
            </div>

            <!-- HOD Login -->
            <div class="login-card">
                <img src="./icons/hod-icon.png" alt="HOD Icon" class="login-icon">
                <h2>HOD Login</h2>
                <form action="authenticate.php" method="POST">
                    <label for="hod-email">Email:</label>
                    <input type="email" id="hod-email" name="email" placeholder="Enter Email" required>
                    <label for="hod-password">Password:</label>
                    <input type="password" id="hod-password" name="password" placeholder="Enter Password" required>
                    <input type="hidden" name="role" value="hod">
                    <button type="submit" class="login-btn">Login</button>
                </form>
            </div>

            <!-- Gatekeeper Login -->
            <div class="login-card">
                <img src="./icons/gatekeeper-icon.png" alt="Gatekeeper Icon" class="login-icon">
                <h2>Gatekeeper Login</h2>
                <form action="authenticate.php" method="POST">
                    <label for="gatekeeper-email">Email:</label>
                    <input type="email" id="gatekeeper-email" name="email" placeholder="Enter Email" required>
                    <label for="gatekeeper-password">Password:</label>
                    <input type="password" id="gatekeeper-password" name="password" placeholder="Enter Password" required>
                    <input type="hidden" name="role" value="gatekeeper">
                    <button type="submit" class="login-btn">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>