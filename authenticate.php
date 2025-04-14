<?php
session_start();
$conn = new mysqli("localhost", "root", "Saikumar@123", "gate_pass_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]); // Ensure no hidden chars
    $role = $_POST["role"];

    $table = ($role == "student") ? "students" : (($role == "hod") ? "hod" : "gatekeepers");
    $stmt = $conn->prepare("SELECT id, name, password FROM $table WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            error_log("Retrieved password hash: " . $row["password"] . ", Input: " . $password);
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
                $_SESSION["error"] = "Invalid password (Debug: Retrieved hash: " . $row["password"] . ", Input: " . $password . ")";
            }
        } else {
            $_SESSION["error"] = "User not found (num_rows: " . $result->num_rows . ")";
        }
    } else {
        $_SESSION["error"] = "Database error: " . $conn->error;
    }
    header("Location: login.php");
    exit();
}

$conn->close();
?>