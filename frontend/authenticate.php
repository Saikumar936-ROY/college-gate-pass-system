<?php
session_start();
include("db_connection.php"); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Fetch user from database based on email and role
    $query = "SELECT * FROM users WHERE email='$email' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verify password (assuming passwords are hashed)
        if (password_verify($password, $row['password'])) {
            $_SESSION['student_id'] = $row['id'];  // Set session
            $_SESSION['role'] = $role;  // Store role in session

            // Redirect based on user role
            if ($role == "student") {
                header("Location: frontend/student_dashboard.php");
            } else if ($role == "hod") {
                header("Location: frontend/hod_dashboard.php");
            } else if ($role == "gatekeeper") {
                header("Location: frontend/gatekeeper_dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid Password'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User Not Found'); window.location.href='login.php';</script>";
    }
} else {
    header("Location: login.php");
    exit();
}
?>
