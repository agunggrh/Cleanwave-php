<?php 
require_once '../config/database.php'; 

if (isset($_SESSION['login'])) {
    header("Location: ../dashboard.php");
    exit;
}

$msg = '';
$msg_type = '';

if (isset($_POST['register'])) {
    $user = $conn->real_escape_string($_POST['username']);
    $pass = $_POST['password'];
    $konfirmasi_pass = $_POST['konfirmasi_password'];
    
    // Cek apakah username sudah ada
    $cek = $conn->query("SELECT * FROM users WHERE username='$user'");
    if ($cek && $cek->num_rows > 0) {
        $msg = "Username sudah digunakan!";
        $msg_type = "error";
    } elseif ($pass !== $konfirmasi_pass) {
        $msg = "Password dan Konfirmasi Password tidak cocok!";
        $msg_type = "warning";
    } else {
        $pass_hash = md5($pass);
        $q = $conn->query("INSERT INTO users (username, password) VALUES ('$user', '$pass_hash')");
        
        if ($q) {
            $_SESSION['swal_register_success'] = "Akun berhasil dibuat! Silakan login.";
            header("Location: login.php");
            exit;
        } else {
            $msg = "Gagal membuat akun!";
            $msg_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Laundry</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="text-center mb-4">
                <i class="fa-solid fa-water fa-3x mb-3" style="color: #2563eb;"></i>
                <h2 class="brand-text mb-1">Daftar Akun</h2>
                <p class="text-muted">Buat akun untuk akses CleanWave</p>
            </div>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label text-muted fw-semibold">Username Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                        <input type="text" name="username" class="form-control bg-light" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control bg-light" placeholder="Buat password" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted fw-semibold">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-key text-muted"></i></span>
                        <input type="password" name="konfirmasi_password" class="form-control bg-light" placeholder="Ulangi password" required>
                    </div>
                </div>
                <button type="submit" name="register" class="btn btn-primary w-100 py-2 fw-bold mb-3">Daftar Sekarang</button>
            </form>
            
            <div class="text-center text-muted small mt-2">
                Sudah punya akun? <a href="login.php" class="text-primary fw-bold text-decoration-none">Login di sini</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        <?php if($msg): ?>
        Swal.fire({
            icon: '<?= $msg_type ?>',
            title: 'Informasi',
            text: '<?= $msg ?>',
            confirmButtonColor: '#2563eb'
        });
        <?php endif; ?>
    </script>
</body>
</html>
