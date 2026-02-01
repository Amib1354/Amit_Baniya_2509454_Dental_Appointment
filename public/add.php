<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
require_once '../config/db.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    $date = $_POST['date'];
    $time = $_POST['time'];
    $service = $_POST['service'];

    $hour = (int)date('H', strtotime($time));
    if ($hour < 9 || $hour >= 17) {
        $error = "Please schedule between 09:00 AM and 05:00 PM.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO appointments (user_id, appointment_date, appointment_time, service_type, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->execute([$_SESSION['user_id'], $date, $time, $service]);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Schedule Appointment</title></head>
<link rel="stylesheet" href="../assets/style.css">
<body>
    <h2>Schedule New Appointment</h2>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        Date: <input type="date" name="date" required><br>
        Time: <input type="time" name="time" required><br>
        Service: 
        <select name="service">
            <option value="Cleaning">Cleaning</option>
            <option value="Root Canal">Root Canal</option>
            <option value="General Checkup">General Checkup</option>
        </select><br><br>
        <button type="submit">Confirm Appointment</button>
    </form>
    <p class="center-text"><a href="index.php">Back to Dashboard</a></p>
</body>
</html>