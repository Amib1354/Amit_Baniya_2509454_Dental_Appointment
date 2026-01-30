<?php
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

$page_title = "Admin - Search All Appointments";
include '../includes/header.php';
?>

<h2>Global Appointment Search</h2>
<p>Search by Patient Name or Service Type:</p>

<input type="text" onkeyup="adminSearch(this.value)" placeholder="Search names or services..." style="padding: 10px; width: 300px;">

<div id="results-container" style="margin-top: 20px;">
    <table border="1" cellpadding="10" id="admin-results-table" style="width: 100%; display: none;">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
                <th>Service</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="results-body">
            </tbody>
    </table>
</div>

<script>
function adminSearch(str) {
    const table = document.getElementById("admin-results-table");
    const tbody = document.getElementById("results-body");

    if (str.length == 0) {
        table.style.display = "none";
        tbody.innerHTML = "";
        return;
    }
    fetch("ajax_admin_search.php?query=" + encodeURIComponent(str))
        .then(response => response.text())
        .then(data => {
            table.style.display = "table";
            tbody.innerHTML = data;
        });
}
</script>

<?php include '../includes/footer.php'; ?>