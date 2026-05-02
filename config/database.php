<?php 
// config/database.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "laundry_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper untuk URL Absolut agar asset tidak rusak saat di folder dalam
function base_url($path = '') {
    // Sesuaikan ini jika path web berbeda di XAMPP/server (misal: /laundry_app/)
    return "/laundry_app/" . $path;
}
?>
