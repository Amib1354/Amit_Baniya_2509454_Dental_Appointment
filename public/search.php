<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Live Appointment Search</title>
    <script>
        function liveSearch(str) {
            if (str.length == 0) {
                document.getElementById("results-list").innerHTML = "";
                return;
            }
            fetch("ajax_search.php?query=" + str)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("results-list").innerHTML = data;
                });
        }
    </script>
</head>
<body>
    <h2>Search Your Appointments</h2>
    <p>Type below to search by service type (e.g., "Cleaning") in real time.</p>
    
    <input type="text" onkeyup="liveSearch(this.value)" placeholder="Start typing...">

    <div id="results-container">
        <ul id="results-list">
            </ul>
    </div>

    <br>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>