<?php
function is_logged_in() {
    return isset($_SESSION['user_id']);
}
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
function format_time($time) {
    return date("h:i A", strtotime($time));
}
function format_date($date) {
    return date("M j, Y", strtotime($date));
}
?>