<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO appointments (user_id, appointment_date, appointment_time, service_type) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $_POST['date'], $_POST['time'], $_POST['service']]);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Schedule New Appointment</h2>
    <form method="POST">
        Date: <input type="date" name="date" required><br>
        Time: <input type="time" name="time" required><br>
        Service: 
        <select name="service">
            <option>Cleaning</option>
            <option>Root Canal</option>
            <option>General Checkup</option>
        </select><br><br>
        <button type="submit">Confirm Appointment</button>
    </form>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>