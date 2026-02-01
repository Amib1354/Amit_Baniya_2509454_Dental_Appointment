<?php
session_start();
require_once '../config/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$apt = $stmt->fetch();

if (!$apt) {
    die("Appointment not found or access denied.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update = $pdo->prepare("UPDATE appointments SET appointment_date = ?, appointment_time = ?, service_type = ? WHERE id = ? AND user_id = ?");
    $update->execute([
        $_POST['date'], 
        $_POST['time'], 
        $_POST['service'], 
        $id, 
        $_SESSION['user_id']
    ]);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="../assets/style.css">
<body>
    <h2>Edit Appointment</h2>
    <form method="POST">
        <label>Date:</label>
        <input type="date" name="date" value="<?php echo $apt['appointment_date']; ?>" required><br>
        
        <label>Time:</label>
        <input type="time" name="time" value="<?php echo $apt['appointment_time']; ?>" required><br>
        
        <label>Service:</label>
        <input type="text" name="service" value="<?php echo htmlspecialchars($apt['service_type']); ?>" required><br><br>
        
        <button type="submit">Update Appointment</button>
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>