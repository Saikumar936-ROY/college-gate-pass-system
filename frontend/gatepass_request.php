<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Gate Pass</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Request Gate Pass</h1>
        <form action="submit_gatepass.php" method="POST" class="gatepass-form">
            <label>Name:</label>
            <input type="text" name="name" value="John Doe" readonly>

            <label>Roll Number:</label>
            <input type="text" name="roll_number" value="123456" readonly>

            <label>Class & Branch:</label>
            <input type="text" name="class_branch" value="CSE - III Year" readonly>

            <label>Attendance Percentage:</label>
            <input type="text" name="attendance" value="85%" readonly>

            <label>Reason for Exit:</label>
            <textarea name="reason" required placeholder="Enter your reason..."></textarea>

            <label>Requested Exit Time:</label>
            <input type="time" name="exit_time" required>

            <label>Parent’s Phone Number:</label>
            <input type="text" name="parent_phone" required placeholder="Enter parent’s contact">

            <button type="submit" class="submit-btn">Submit Request</button>
        </form>
    </div>
</body>
</html>
