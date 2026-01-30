<?php
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}
$stmt = $pdo->query("SELECT appointments.*, users.full_name 
                     FROM appointments 
                     JOIN users ON appointments.user_id = users.id 
                     ORDER BY appointment_date ASC, appointment_time ASC");
$all_apts = $stmt->fetchAll();

$page_title = "Admin Dashboard"; 
include '../includes/header.php';
?>

<h1>Dental Clinic Administration</h1>
<p>Welcome, Admin <?php echo htmlspecialchars($_SESSION['full_name']); ?></p>

<div style="margin-bottom: 20px; background: #f9f9f9; padding: 15px; border-radius: 5px;">
    <h3>Global Search</h3>
    <input type="text" id="adminSearchInput" onkeyup="adminSearch(this.value)" 
           placeholder="Search by Patient Name or Service..." 
           style="padding: 10px; width: 350px; border: 1px solid #ccc; border-radius: 4px;">
</div>

<div id="mainTableContainer">
    <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
        <thead style="background-color: #eee;">
            <tr>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Service</th>
                <th>Current Status</th>
                <th>Change Status</th>
            </tr>
        </thead>
        <tbody id="dashboardBody">
            <?php foreach ($all_apts as $apt): ?>
            <tr>
                <td><?php echo htmlspecialchars($apt['full_name']); ?></td>
                <td><?php echo format_date($apt['appointment_date']); ?></td>
                <td><?php echo format_time($apt['appointment_time']); ?></td>
                <td><?php echo htmlspecialchars($apt['service_type']); ?></td>
                <td><strong><?php echo strtoupper($apt['status']); ?></strong></td>
                <td>
                    <a href="update_status.php?id=<?php echo $apt['id']; ?>&status=scheduled">Approve</a> | 
                    <a href="update_status.php?id=<?php echo $apt['id']; ?>&status=cancelled">Decline</a> | 
                    <a href="update_status.php?id=<?php echo $apt['id']; ?>&status=completed">Finish</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function adminSearch(str) {
    const tbody = document.getElementById("dashboardBody");
    let query = str.trim();
    
    fetch("ajax_admin_search.php?query=" + encodeURIComponent(query))
        .then(response => response.text())
        .then(data => {
            if(data.trim() === "" && query !== "") {
                tbody.innerHTML = "<tr><td colspan='6' style='text-align:center;'>No matching records found.</td></tr>";
            } else {
                tbody.innerHTML = data;
            }
        });
}
</script>

<?php include '../includes/footer.php'; ?>