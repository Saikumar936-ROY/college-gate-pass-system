<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "gatekeeper") {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("127.0.0.1:3307", "root", "Saikumar@123", "gate_pass_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["pass_id"])) {
    $pass_id = $_POST["pass_id"];

    // Check if pass exists and is approved
    $stmt_check = $conn->prepare("SELECT s.email, p.student_id, p.exit_time FROM passes p JOIN students s ON p.student_id = s.id WHERE p.id = ? AND p.status = 'approved'");
    $stmt_check->bind_param("i", $pass_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $pass = $result_check->fetch_assoc();
        $student_email = $pass['email'];
        $exit_time = $pass['exit_time'];

        // Update verification status
        $stmt_update = $conn->prepare("UPDATE passes SET verification_status = 'verified' WHERE id = ?");
        $stmt_update->bind_param("i", $pass_id);
        $stmt_update->execute();
        $stmt_update->close();

        // Optional: Send verification confirmation email
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
            $mail->Subject = 'Gate Pass Verified';
            $mail->Body = "<h2>Gate Pass Verification</h2>
                           <p>Dear " . htmlspecialchars($pass['student_id']) . ",</p>
                           <p>Your gate pass for exit at " . htmlspecialchars($exit_time) . " has been verified.</p>
                           <p>Safe travels!</p>";

            $mail->send();
            echo "Pass verified and notification sent.";
        } catch (Exception $e) {
            echo "Pass verified, but notification failed. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Invalid or unapproved pass ID.";
    }

    $stmt_check->close();
}

$conn->close();
header("Location: gatekeeper_dashboard.php");
exit();
?>