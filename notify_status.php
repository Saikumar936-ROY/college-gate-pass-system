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

if (isset($_POST["pass_id"]) && isset($_POST["status"])) {
    $pass_id = $_POST["pass_id"];
    $status = $_POST["status"]; // 'approved' or 'rejected'

    // Fetch student email and pass details
    $stmt_email = $conn->prepare("SELECT s.email, p.student_id, p.exit_time FROM students s JOIN passes p ON s.id = p.student_id WHERE p.id = ?");
    $stmt_email->bind_param("i", $pass_id);
    $stmt_email->execute();
    $result_email = $stmt_email->get_result();
    $pass = $result_email->fetch_assoc();
    $student_email = $pass['email'];
    $exit_time = $pass['exit_time'];

    // Send notification
    require_once 'PHPMailer/PHPMailer.php';
    require_once 'PHPMailer/SMTP.php';
    require_once 'PHPMailer/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'saikumarlingaraju@gmail.com'; // Replace with your Gmail
        $mail->Password = 'qzzi exqp ryru xgmx';     // Replace with your App Password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your.email@gmail.com', 'College Gate Pass');
        $mail->addAddress($student_email);
        $mail->isHTML(true);
        $mail->Subject = 'Gate Pass Status Update';
        $mail->Body = "<h2>Gate Pass Status</h2>
                       <p>Dear Student,</p>
                       <p>Your gate pass request has been {$status}.</p>
                       <p><strong>Exit Time:</strong> " . htmlspecialchars($exit_time) . "</p>
                       <p>Please contact the gatekeeper for verification if approved.</p>";

        $mail->send();
        // Update notification status
        $stmt_update = $conn->prepare("UPDATE passes SET notification_status = 'sent', status = ? WHERE id = ?");
        $stmt_update->bind_param("si", $status, $pass_id);
        $stmt_update->execute();
        $stmt_update->close();
        // Redirect to dashboard with success message
        header("Location: hod_dashboard.php?success=Notification sent successfully.");
        exit();
    } catch (Exception $e) {
        $stmt_update = $conn->prepare("UPDATE passes SET notification_status = 'failed' WHERE id = ?");
        $stmt_update->bind_param("i", $pass_id);
        $stmt_update->execute();
        $stmt_update->close();
        header("Location: hod_dashboard.php?error=Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        exit();
    }
}

$conn->close();
header("Location: hod_dashboard.php?error=Invalid request.");
exit();
?>