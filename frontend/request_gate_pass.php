<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Gate Pass</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="request-container">
        <h2>Request a Gate Pass</h2>
        <form action="submit_request.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="text" name="class" placeholder="Your Class" required>
            <input type="text" name="branch" placeholder="Your Branch" required>
            <input type="number" name="attendance" placeholder="Attendance %" required>
            <input type="time" name="exit_time" required>
            <input type="text" name="parent_phone" placeholder="Parent's Phone Number" required>
            <button type="submit">Submit Request</button>
        </form>
    </div>
</body>
</html>
