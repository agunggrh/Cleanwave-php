<?php 
require_once '../config/database.php'; 
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$harga = $conn->query("SELECT * FROM settings LIMIT 1")->fetch_assoc();
$harga_perkg = $harga ? $harga['harga_perkg'] : 0;

$msg = '';
$msg_type = '';

if (isset($_POST['simpan'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $berat = (float) $_POST['berat'];
    $tanggal = date('Y-m-d');
    
    if($berat <= 0) {
        $msg = "Berat harus lebih dari 0!";
        $msg_type = "error";
    } else {
        $total = $berat * $harga_perkg;
        $q = $conn->query("INSERT INTO transaksi (nama, berat, total, status, tanggal) VALUES ('$nama', '$berat', '$total', 'Proses', '$tanggal')");
        
        if($q) {
            $_SESSION['swal_success'] = "Transaksi berhasil ditambahkan!";
            header("Location: status.php");
            exit;
        } else {
            $msg = "Gagal menyimpan transaksi!";
            $msg_type = "error";
        }
    }
}
?>

<?php include '../templates/header.php'; ?>
<?php include '../templates/navbar.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h4 class="card-title fw-bold text-primary mb-0"><i class="fa-solid fa-plus-circle me-2"></i>Tambah Transaksi Baru</h4>
            </div>
            <div class="card-body p-4">
                
                <?php if($msg): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation me-2"></i><?= $msg ?>
                </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Pelanggan</label>
                        <input name="nama" type="text" class="form-control form-control-lg bg-light border-0" placeholder="Masukkan nama pelanggan" required autofocus>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Berat Cucian (Kg)</label>
                        <div class="input-group input-group-lg">
                            <input name="berat" type="number" step="0.1" id="beratInput" class="form-control bg-light border-0" placeholder="0.0" required>
                            <span class="input-group-text bg-light border-0">Kg</span>
                        </div>
                    </div>

                    <div class="p-3 bg-primary bg-opacity-10 rounded-3 mb-4 border border-primary border-opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-semibold">Harga per Kg:</span>
                            <span class="text-primary fw-bold">Rp <?= number_format($harga_perkg, 0, ',', '.') ?></span>
                        </div>
                        <hr class="border-primary border-opacity-50 my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold fs-5">Estimasi Total:</span>
                            <span class="text-primary fw-bold fs-4" id="totalBayar">Rp 0</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button name="simpan" class="btn btn-primary btn-lg flex-grow-1"><i class="fa-solid fa-save me-2"></i>Simpan Transaksi</button>
                        <a href="../dashboard.php" class="btn btn-light btn-lg border text-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const beratInput = document.getElementById('beratInput');
    const totalBayar = document.getElementById('totalBayar');
    const hargaPerKg = <?= $harga_perkg ?>;

    beratInput.addEventListener('input', function() {
        let berat = parseFloat(this.value) || 0;
        let total = berat * hargaPerKg;
        totalBayar.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    });
});
</script>

<?php include '../templates/footer.php'; ?>
