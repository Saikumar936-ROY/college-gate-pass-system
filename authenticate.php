<?php
session_start();
$conn = new mysqli("127.0.0.1:3307", "root", "Saikumar@123", "gate_pass_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Determine the correct table based on role
    $table = ($role == "student") ? "students" : (($role == "hod") ? "hod" : "gatekeepers");
    $stmt = $conn->prepare("SELECT id, name, password FROM $table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"];
            $_SESSION["role"] = $role;
            if ($role == "student") {
                header("Location: student_dashboard.php");
            } elseif ($role == "hod") {
                header("Location: hod_dashboard.php");
            } else {
                header("Location: gatekeeper_dashboard.php");
            }
            exit();
        } else {
            $_SESSION["error"] = "Invalid password";
        }
    } else {
        $_SESSION["error"] = "User not found";
    }
    header("Location: login.php");
    exit();
}
$conn->close();
?>