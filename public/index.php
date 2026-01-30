<?php
session_start();
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
}
require_once '../config/db.php';
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$appointments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>My Dental Appointments</title></head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?></h2>
    <nav>
        <a href="add.php">Book Appointment</a> | 
        <a href="search.php">Search Appointments</a> | 
        <a href="logout.php">Logout</a>
    </nav>
    <hr>
    <h3>Your Scheduled Visits</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Service Type</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($appointments as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
            <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
            <td><?php echo htmlspecialchars($row['service_type']); ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                <a href="delete.php?id=<?php echo $row['id']; ?>" 
                   onclick="return confirm('Are you sure you want to cancel this appointment?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>