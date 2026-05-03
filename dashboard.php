<?php 
require_once 'config/database.php'; 
if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

// Get Summary Data
$today = date('Y-m-d');
$q_transaksi_hari_ini = $conn->query("SELECT COUNT(*) as total FROM transaksi WHERE tanggal = '$today'");
$transaksi_hari_ini = $q_transaksi_hari_ini->fetch_assoc()['total'];

$q_pendapatan_hari_ini = $conn->query("SELECT SUM(total) as total FROM transaksi WHERE tanggal = '$today'");
$pendapatan_hari_ini = $q_pendapatan_hari_ini->fetch_assoc()['total'] ?? 0;

$q_proses = $conn->query("SELECT COUNT(*) as total FROM transaksi WHERE status = 'Proses'");
$proses = $q_proses->fetch_assoc()['total'];

$q_selesai = $conn->query("SELECT COUNT(*) as total FROM transaksi WHERE status = 'Selesai'");
$selesai = $q_selesai->fetch_assoc()['total'];

?>
<?php include 'templates/header.php'; ?>
<?php include 'templates/navbar.php'; ?>

<!-- SweetAlert notification for login success -->
<?php if(isset($_SESSION['swal_success'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '<?= $_SESSION['swal_success'] ?>',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
});
</script>
<?php unset($_SESSION['swal_success']); endif; ?>

<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Halo, <?= htmlspecialchars($_SESSION['username']) ?>! </h3>
                    <p class="mb-0 text-white-50">Selamat datang kembali di Clean Wave Laundry.</p>
                </div>
                <i class="fa-solid fa-water fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Card Pendapatan -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 p-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-money-bill-wave fa-lg text-success"></i>
                </div>
                <div class="ms-3">
                    <p class="text-muted mb-0 small fw-semibold">Pendapatan Hari Ini</p>
                    <h4 class="mb-0 fw-bold">Rp <?= number_format($pendapatan_hari_ini, 0, ',', '.') ?></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Transaksi -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 p-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-basket-shopping fa-lg text-primary"></i>
                </div>
                <div class="ms-3">
                    <p class="text-muted mb-0 small fw-semibold">Transaksi Hari Ini</p>
                    <h4 class="mb-0 fw-bold"><?= $transaksi_hari_ini ?></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Proses -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 p-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-clock-rotate-left fa-lg text-warning"></i>
                </div>
                <div class="ms-3">
                    <p class="text-muted mb-0 small fw-semibold">Cucian Diproses</p>
                    <h4 class="mb-0 fw-bold"><?= $proses ?></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Selesai -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 p-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-info bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-check-double fa-lg text-info"></i>
                </div>
                <div class="ms-3">
                    <p class="text-muted mb-0 small fw-semibold">Cucian Selesai</p>
                    <h4 class="mb-0 fw-bold"><?= $selesai ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <h5 class="fw-bold mb-3">Aksi Cepat</h5>
        <div class="d-flex gap-3 flex-wrap">
            <a href="transaksi/tambah.php" class="btn btn-primary px-4 py-2 shadow-sm">
                <i class="fa-solid fa-plus me-2"></i> Tambah Transaksi
            </a>
            <a href="transaksi/status.php" class="btn btn-light px-4 py-2 border shadow-sm text-dark">
                <i class="fa-solid fa-list-check me-2"></i> Lihat Status
            </a>
            <a href="laporan/filter.php" class="btn btn-light px-4 py-2 border shadow-sm text-dark">
                <i class="fa-solid fa-print me-2"></i> Cetak Laporan
            </a>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
