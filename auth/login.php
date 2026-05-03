<?php 
require_once '../config/database.php'; 

if (isset($_SESSION['login'])) {
    header("Location: ../dashboard.php");
    exit;
}

$msg = '';
$msg_type = '';

if (isset($_POST['login'])) {
    $user = $conn->real_escape_string($_POST['username']);
    // Untuk keamanan yang lebih baik, di masa depan gunakan password_hash()
    $pass = md5($_POST['password']); 
    
    $q = $conn->query("SELECT * FROM users WHERE username='$user' AND password='$pass'");
    if ($q && $q->num_rows > 0) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $user;
        
        // Redirect with SweetAlert via Session
        $_SESSION['swal_success'] = "Selamat datang, $user!";
        header("Location: ../dashboard.php");
        exit;
    } else {
        $msg = "Username atau password salah!";
        $msg_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Laundry</title>
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
                <h2 class="brand-text mb-1">CleanWave</h2>
                <p class="text-muted">Manajemen Laundry</p>
            </div>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label text-muted fw-semibold">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                        <input type="text" name="username" class="form-control bg-light" placeholder="Masukkan username" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control bg-light" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100 py-2 fw-bold">Login Sistem</button>
            </form>
            
            <!-- Default credentials for testing -->
            <div class="text-center mt-3 text-muted small border-top pt-3">
                Belum punya akun? <a href="register.php" class="text-primary fw-bold text-decoration-none">Daftar di sini</a>
                <br><br>
                Admin bawaan: <b>admin</b> / <b>admin</b>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        <?php if($msg): ?>
        Swal.fire({
            icon: '<?= $msg_type ?>',
            title: 'Oops...',
            text: '<?= $msg ?>',
            confirmButtonColor: '#2563eb'
        });
        <?php endif; ?>
        
        <?php if(isset($_SESSION['swal_register_success'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= $_SESSION['swal_register_success'] ?>',
            confirmButtonColor: '#2563eb',
            timer: 3000
        });
        <?php unset($_SESSION['swal_register_success']); endif; ?>
        
        <?php if(isset($_SESSION['swal_logout'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Logout Berhasil',
            text: '<?= $_SESSION['swal_logout'] ?>',
            confirmButtonColor: '#2563eb',
            timer: 2000,
            showConfirmButton: false
        });
        <?php unset($_SESSION['swal_logout']); endif; ?>
    </script>
</body>
</html>
