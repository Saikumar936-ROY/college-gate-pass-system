<?php session_start(); if (isset($_SESSION["user_id"])) header("Location: student_dashboard.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./frontend/style.css">
</head>
<body>
    <div class="header">
        <h1>College Gate Pass System</h1>
        <?php if (isset($_SESSION["error"])) { echo "<p style='color: #E74C3C;'>".htmlspecialchars($_SESSION["error"])."</p>"; unset($_SESSION["error"]); } ?>
    </div>
    <div class="container">
        <h1>Login</h1>
        <div class="login-wrapper">
            <div class="login-card">
                <i class="fas fa-user-graduate login-icon"></i>
                <h2>Student Login</h2>
                <form action="authenticate.php" method="POST">
                    <input type="hidden" name="role" value="student">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Enter Email">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required placeholder="Enter Password">
                    <button type="submit" class="btn">Login</button>
                </form>
            </div>
            <div class="login-card">
                <i class="fas fa-chalkboard-teacher login-icon"></i>
                <h2>HOD Login</h2>
                <form action="authenticate.php" method="POST">
                    <input type="hidden" name="role" value="hod">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Enter Email">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required placeholder="Enter Password">
                    <button type="submit" class="btn">Login</button>
                </form>
            </div>
            <div class="login-card">
                <i class="fas fa-shield-alt login-icon"></i>
                <h2>Gatekeeper Login</h2>
                <form action="authenticate.php" method="POST">
                    <input type="hidden" name="role" value="gatekeeper">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Enter Email">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required placeholder="Enter Password">
                    <button type="submit" class="btn">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>