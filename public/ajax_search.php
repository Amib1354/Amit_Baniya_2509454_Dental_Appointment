01<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) { exit(); }

if (isset($_GET['query'])) {
    $search = "%" . $_GET['query'] . "%";
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE user_id = ? AND service_type LIKE ?");
    $stmt->execute([$_SESSION['user_id'], $search]);
    $results = $stmt->fetchAll();

    if ($results) {
        foreach ($results as $res) {
            echo "<li>" . htmlspecialchars($res['appointment_date']) . " - " . htmlspecialchars($res['service_type']) . "</li>";
        }
    } else {
        echo "<li>No appointments found.</li>";
    }
}
?>