<?php
require_once '../config/database.php';

// Hancurkan semua session
session_unset();
session_destroy();

// Mulai session baru hanya untuk pesan notifikasi (opsional, jika ingin flash message setelah logout)
session_start();
$_SESSION['swal_logout'] = "Anda telah berhasil keluar dari sistem.";

header("Location: login.php");
exit;
?>
