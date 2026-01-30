<?php
session_start();
require_once '../config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized access.");
}

$id = $_GET['id'] ?? null;
$status = $_GET['status'] ?? null;
$allowed_statuses = ['scheduled', 'completed', 'cancelled'];

if ($id && in_array($status, $allowed_statuses)) {
    $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}

header("Location: dashboard.php");
exit();