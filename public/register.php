<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$full_name, $email, $password]);
        header("Location: login.php?msg=Registration successful!");
        exit();
    } catch (PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Dental Clinic - Register</title></head>
<body>
    <h2>Patient Registration</h2>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <label>Full Name:</label><br><input type="text" name="full_name" required><br>
        <label>Email:</label><br><input type="email" name="email" required><br>
        <label>Password:</label><br><input type="password" name="password" required><br><br>
        <button type="submit">Register Account</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>