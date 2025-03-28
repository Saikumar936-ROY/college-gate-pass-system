$_SESSION['student_id'] = $student_id;
header("Location: student_dashboard.php");

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate Pass System - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gate Pass System</h1>

        <div class="login-cards">
            <!-- Student Login -->
            <div class="login-card">
                <img src="icons/student-icon.png" alt="Student Icon">
                <h2>Student Login</h2>
                <form action="authenticate.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="hidden" name="role" value="student">
                    <button type="submit">Login</button>
                </form>
            </div>

            <!-- HOD Login -->
            <div class="login-card">
                <img src="icons/hod-icon.png" alt="HOD Icon">
                <h2>HOD Login</h2>
                <form action="authenticate.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="hidden" name="role" value="hod">
                    <button type="submit">Login</button>
                </form>
            </div>

            <!-- Gatekeeper Login -->
            <div class="login-card">
                <img src="icons/gatekeeper-icon.png" alt="Gatekeeper Icon">
                <h2>Gatekeeper Login</h2>
                <form action="authenticate.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="hidden" name="role" value="gatekeeper">
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
