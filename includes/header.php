<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <title><?php echo isset($page_title) ? $page_title : 'Dental Clinic'; ?></title>
        <link rel="stylesheet" href="../assets/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        nav { background: #f4f4f4; padding: 10px; margin-bottom: 20px; border-bottom: 2px solid #ddd; }
        nav a { margin-right: 15px; text-decoration: none; color: #333; font-weight: bold; }
        .admin-link { color: #d9534f; }
    </style>
</head>
<body>
    <nav>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="../admin/dashboard.php" class="admin-link">Admin Panel</a>
        <?php else: ?>
            <a href="index.php">Dashboard</a>
            <a href="add.php">Book Appointment</a>
            <a href="search.php">Search Appointments</a>
        <?php endif; ?>
        
        <a href="../public/logout.php">Logout</a>
    </nav>