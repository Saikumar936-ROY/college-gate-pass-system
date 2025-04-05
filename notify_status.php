<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "hod") {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("127.0.0.1:3307", "root", "Saikumar@123", "gate_pass_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Placeholder: This will be called by the HOD approval system
if (isset($_POST["pass_id"]) && isset($_POST["status"])) {
    $pass_id = $_POST["pass_id"];
    $status = $_POST["status"]; // Expected: 'approved' or 'rejected'

    // Fetch student email
    $stmt_email = $conn->prepare("SELECT s.email, p.student_id FROM students s JOIN passes p ON s.id = p.student_id WHERE p.id = ?");
    $stmt_email->bind_param("i", $pass_id);
    $stmt_email->execute();
    $result_email = $stmt_email->get_result();
    $student = $result_email->fetch_assoc();
    $student_email = $student['email'];

    // Send notification (using PHPMailer)
    require_once 'PHPMailer/PHPMailer.php';
    require_once 'PHPMailer/SMTP.php';
    require_once 'PHPMailer/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your.email@gmail.com'; // Replace with your Gmail
        $mail->Password = 'your_app_password';     // Replace with your App Password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your.email@gmail.com', 'College Gate Pass');
        $mail->addAddress($student_email);
        $mail->isHTML(true);
        $mail->Subject = 'Gate Pass Status Update';
        $mail->Body = "<h2>Gate Pass Status</h2>
                       <p>Dear Student,</p>
                       <p>Your gate pass request has been {$status}.</p>
                       <p>Please contact the gatekeeper for verification if approved.</p>";

        $mail->send();
        // Update notification status
        $stmt_update = $conn->prepare("UPDATE passes SET notification_status = 'sent', status = ? WHERE id = ?");
        $stmt_update->bind_param("si", $status, $pass_id);
        $stmt_update->execute();
        $stmt_update->close();
        echo "Notification sent successfully.";
    } catch (Exception $e) {
        $stmt_update = $conn->prepare("UPDATE passes SET notification_status = 'failed' WHERE id = ?");
        $stmt_update->bind_param("i", $pass_id);
        $stmt_update->execute();
        $stmt_update->close();
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$conn->close();
?>