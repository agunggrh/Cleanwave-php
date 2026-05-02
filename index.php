<?php 
require_once 'config/database.php';

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
} else {
    header("Location: auth/login.php");
}
exit;
?>
