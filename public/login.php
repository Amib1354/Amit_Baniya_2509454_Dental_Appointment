<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Dental Clinic - Login</title></head>
<link rel="stylesheet" href="../assets/style.css">
<body>
    <h2>Login</h2>
    <?php if(isset($_GET['error'])) echo "<p style='color:red'>Invalid email or password.</p>"; ?>
    <form action="login_process.php" method="POST">
        <label>Email:</label><br><input type="email" name="email" required><br>
        <label>Password:</label><br><input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p class="center-text">New patient? <a href="register.php">Register here</a></p>
</body>
</html>