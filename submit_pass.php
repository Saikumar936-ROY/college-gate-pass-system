<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "Saikumar@123", "gate_pass_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_SESSION["user_id"];
$exit_time = $_POST["exit_time"];
$attendance = floatval($_POST["attendance"]);
$parent_phone = $_POST["parent_phone"];
$reason = $_POST["reason"];
$is_emergency = isset($_POST["is_emergency"]) && $_POST["is_emergency"] == "1" ? 1 : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($exit_time) && !empty($attendance) && !empty($parent_phone) && !empty($reason)) {
    // Validate attendance
    if ($attendance < 0 || $attendance > 100) {
        die("Attendance must be between 0 and 100.");
    }
    if ($attendance < 75 && !$is_emergency) {
        die("Attendance below 75% requires an emergency request.");
    }

    // Validate parent_phone against students table
    $stmt_check = $conn->prepare("SELECT parent_phone FROM students WHERE id = ?");
    $stmt_check->bind_param("i", $student_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $student = $result_check->fetch_assoc();
    if ($parent_phone !== $student['parent_phone']) {
        die("Error: Parent phone mismatch.");
    }
    $stmt_check->close();

    // Insert pass request
    $stmt = $conn->prepare("INSERT INTO passes (student_id, exit_time, attendance_percentage, parent_phone, reason, is_emergency, notification_status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("issdsi", $student_id, $exit_time, $attendance, $parent_phone, $reason, $is_emergency);

    if ($stmt->execute()) {
        $stmt_email = $conn->prepare("SELECT email FROM students WHERE id = ?");
        $stmt_email->bind_param("i", $student_id);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();
        $student = $result_email->fetch_assoc();
        $student_email = $student['email'];
        $stmt_email->close();

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
            $mail->Subject = 'New Gate Pass Request Submitted';
            $mail->Body = "<h2>Gate Pass Request</h2>
                           <p>Dear " . htmlspecialchars($_SESSION["user_name"]) . ",</p>
                           <p>Your gate pass request has been submitted successfully.</p>
                           <p><strong>Exit Time:</strong> " . htmlspecialchars($exit_time) . "</p>
                           <p><strong>Reason:</strong> " . htmlspecialchars($reason) . "</p>
                           <p><strong>Emergency:</strong> " . ($is_emergency ? 'Yes' : 'No') . "</p>
                           <p><strong>Status:</strong> Pending</p>
                           <p>You will be notified once it is approved or rejected.</p>";

            $mail->send();
            $stmt_update = $conn->prepare("UPDATE passes SET notification_status = 'sent' WHERE id = LAST_INSERT_ID()");
            $stmt_update->execute();
            $stmt_update->close();
        } catch (Exception $e) {
            $stmt_update = $conn->prepare("UPDATE passes SET notification_status = 'failed' WHERE id = LAST_INSERT_ID()");
            $stmt_update->execute();
            $stmt_update->close();
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        header("Location: student_dashboard.php");
        exit();
    } else {
        die("Error inserting pass request: " . $conn->error);
    }
} else {
    die("Invalid request or missing fields.");
}

$stmt->close();
$conn->close();
?>