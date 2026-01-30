<?php
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Unauthorized");
}

if (isset($_GET['query'])) {
    $search = "%" . $_GET['query'] . "%";
    $stmt = $pdo->prepare("SELECT appointments.*, users.full_name 
                           FROM appointments 
                           JOIN users ON appointments.user_id = users.id 
                           WHERE users.full_name LIKE ? OR appointments.service_type LIKE ?
                           ORDER BY appointment_date DESC");
    $stmt->execute([$search, $search]);
    $results = $stmt->fetchAll();

    if ($results) {
        foreach ($results as $res) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($res['full_name']) . "</td>";
            echo "<td>" . format_date($res['appointment_date']) . "</td>";
            echo "<td>" . format_time($res['appointment_time']) . "</td>";
            echo "<td>" . htmlspecialchars($res['service_type']) . "</td>";
            echo "<td><strong>" . strtoupper($res['status']) . "</strong></td>";
            echo "<td>
                    <a href='update_status.php?id=" . $res['id'] . "&status=scheduled'>Approve</a> | 
                    <a href='update_status.php?id=" . $res['id'] . "&status=cancelled'>Decline</a> | 
                    <a href='update_status.php?id=" . $res['id'] . "&status=completed'>Finish</a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6' style='text-align:center;'>No matching appointments found.</td></tr>";
    }
}
?>