# college-gate-pass-system
# College Gate Pass System

## Setup Instructions
1. Install XAMPP and start Apache & MySQL.
2. Create a database named `gate_pass_system`.
3. Import the schema from `database/gate_pass_system.sql`.
4. Update connection strings in `authenticate.php`, `student_dashboard.php`, `request_pass.php`, `submit_pass.php`, and `notify_status.php` to your local MySQL settings (e.g., `localhost:3306`, `root`, no password unless changed).
5. Download PHPMailer and place the `PHPMailer` folder in the project root.
6. Configure Gmail credentials in `submit_pass.php` and `notify_status.php`.
7. Run the project at `http://localhost/Projects/college-gate-pass-system/login.php`.

## Team Roles
- Person 1 & 2: Completed (Login, Dashboard, Pass Request, Notifications).

- Person 3: Implement HOD Approval (integrate with `notify_status.php`).
- Person 4: Implement Gatekeeper Verification.