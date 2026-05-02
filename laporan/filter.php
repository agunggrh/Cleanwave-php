<?php 
require_once '../config/database.php'; 
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data_transaksi = null;
$d = '';
$s = '';

if (isset($_POST['filter'])) {
    $d = $conn->real_escape_string($_POST['dari']);
    $s = $conn->real_escape_string($_POST['sampai']);
    $data_transaksi = $conn->query("SELECT * FROM transaksi WHERE tanggal BETWEEN '$d' AND '$s' ORDER BY tanggal ASC");
} else {
    // Default show last 30 days or empty
    $s = date('Y-m-d');
    $d = date('Y-m-d', strtotime('-30 days'));
    $data_transaksi = $conn->query("SELECT * FROM transaksi WHERE tanggal BETWEEN '$d' AND '$s' ORDER BY tanggal ASC");
}

?>

<?php include '../templates/header.php'; ?>
<?php include '../templates/navbar.php'; ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="fa-solid fa-filter me-2 text-primary"></i>Filter Laporan</h5>
                
                <form method="POST" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Dari Tanggal</label>
                        <input type="date" name="dari" value="<?= $d ?>" class="form-control form-control-lg bg-light" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sampai Tanggal</label>
                        <input type="date" name="sampai" value="<?= $s ?>" class="form-control form-control-lg bg-light" required>
                    </div>
                    <div class="col-md-4">
                        <button name="filter" class="btn btn-primary btn-lg w-100"><i class="fa-solid fa-search me-2"></i> Tampilkan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if($data_transaksi): ?>
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Hasil Laporan: <?= date('d M Y', strtotime($d)) ?> s/d <?= date('d M Y', strtotime($s)) ?></h5>
        
        <div class="d-flex gap-2">
            <form action="print.php" method="POST" target="_blank">
                <input type="hidden" name="dari" value="<?= $d ?>">
                <input type="hidden" name="sampai" value="<?= $s ?>">
                <button type="submit" class="btn btn-outline-secondary"><i class="fa-solid fa-print me-2"></i>Cetak Laporan</button>
            </form>
            <form action="pdf.php" method="POST" target="_blank">
                <input type="hidden" name="dari" value="<?= $d ?>">
                <input type="hidden" name="sampai" value="<?= $s ?>">
                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-file-pdf me-2"></i>Export PDF</button>
            </form>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="15%">Tanggal</th>
                        <th>Nama Pelanggan</th>
                        <th width="10%">Berat</th>
                        <th width="15%">Status</th>
                        <th width="20%" class="text-end">Total Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $total_pendapatan = 0;
                    
                    if($data_transaksi->num_rows > 0):
                        while ($r = $data_transaksi->fetch_assoc()): 
                            $total_pendapatan += $r['total'];
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                        <td><?= htmlspecialchars($r['nama']) ?></td>
                        <td><?= $r['berat'] ?> Kg</td>
                        <td>
                            <?php if($r['status'] == 'Selesai'): ?>
                                <span class="badge bg-success">Selesai</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Proses</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end fw-bold">Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
                    </tr>
                    <?php 
                        endwhile; 
                    else: 
                    ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Tidak ada data transaksi pada rentang tanggal ini.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <?php if($data_transaksi->num_rows > 0): ?>
                <tfoot>
                    <tr class="table-primary fw-bold">
                        <td colspan="5" class="text-end">TOTAL PENDAPATAN</td>
                        <td class="text-end fs-5 text-primary">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include '../templates/footer.php'; ?>
