<?php
// app.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// koneksi DB
include 'C:\xampp\htdocs\ekskul2025\admin\config\connect.php';
// controller
include 'controller.php';
?>
