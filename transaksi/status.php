<?php 
require_once '../config/database.php'; 
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = $conn->query("SELECT * FROM transaksi ORDER BY id DESC");
?>

<?php include '../templates/header.php'; ?>
<?php include '../templates/navbar.php'; ?>

<!-- SweetAlert notification -->
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

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
        <h4 class="card-title fw-bold text-primary mb-0"><i class="fa-solid fa-list-check me-2"></i>Status Transaksi</h4>
        <a href="tambah.php" class="btn btn-primary btn-sm rounded-pill px-3"><i class="fa-solid fa-plus me-1"></i> Transaksi Baru</a>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover datatable align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th>Nama Pelanggan</th>
                        <th width="10%">Berat</th>
                        <th width="15%">Total</th>
                        <th width="15%">Status</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while ($d = $data->fetch_assoc()): 
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($d['tanggal'])) ?></td>
                        <td class="fw-semibold text-dark"><?= htmlspecialchars($d['nama']) ?></td>
                        <td><?= $d['berat'] ?> Kg</td>
                        <td class="fw-bold text-success">Rp <?= number_format($d['total'], 0, ',', '.') ?></td>
                        <td>
                            <?php if($d['status'] == 'Selesai'): ?>
                                <span class="badge bg-success rounded-pill px-3 py-2"><i class="fa-solid fa-check-circle me-1"></i> Selesai</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i class="fa-solid fa-clock me-1"></i> Proses</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <?php if($d['status'] == 'Proses'): ?>
                                    <a href="#" onclick="konfirmasiSelesai(<?= $d['id'] ?>)" class="btn btn-sm btn-success" title="Tandai Selesai">
                                        <i class="fa-solid fa-check"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="invoice.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-info text-white" title="Lihat Invoice">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </a>
                                <!-- Opsional: Fitur cetak PDF menggunakan FPDF jika tersedia -->
                                <!-- <a href="invoice_pdf.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-danger" target="_blank" title="Cetak PDF"><i class="fa-solid fa-file-pdf"></i></a> -->
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function konfirmasiSelesai(id) {
    Swal.fire({
        title: 'Selesaikan Cucian?',
        text: "Status transaksi akan diubah menjadi Selesai.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Selesai!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'proses.php?id=' + id;
        }
    })
}
</script>

<?php include '../templates/footer.php'; ?>
