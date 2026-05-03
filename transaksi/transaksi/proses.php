<?php 
require_once '../config/database.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $conn->query("UPDATE transaksi SET status='Selesai' WHERE id=$id");
    
    $_SESSION['swal_success'] = "Status transaksi berhasil diperbarui menjadi Selesai!";
}

header("Location: status.php");
exit;
?>
