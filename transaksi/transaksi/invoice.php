<?php 
require_once '../config/database.php'; 
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$q = $conn->query("SELECT * FROM transaksi WHERE id=$id");

if($q->num_rows == 0) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='status.php';</script>";
    exit;
}
$d = $q->fetch_assoc();

$harga = $conn->query("SELECT * FROM settings LIMIT 1")->fetch_assoc();
$harga_perkg = $harga ? $harga['harga_perkg'] : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - #INV<?= str_pad($d['id'], 5, '0', STR_PAD_LEFT) ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
        .invoice-card { max-width: 800px; margin: 40px auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .brand { font-size: 24px; font-weight: 800; color: #2563eb; }
        .table th { background-color: #f1f5f9; }
        @media print {
            body { background-color: white; }
            .invoice-card { box-shadow: none; margin: 0; padding: 20px; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="invoice-card">
        <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
            <div>
                <div class="brand mb-1"><i class="fa-solid fa-water me-2"></i>CleanWave Laundry</div>
                <div class="text-muted small">Jl. Perum Sudirman Indah No. 123, Tangerang</div>
                <div class="text-muted small">Telp: 0851-4374-1393</div>
            </div>
            <div class="text-end">
                <h3 class="fw-bold mb-1 text-uppercase text-secondary">Invoice</h3>
                <div class="fw-bold text-dark">#INV<?= str_pad($d['id'], 5, '0', STR_PAD_LEFT) ?></div>
                <div class="text-muted small">Tanggal: <?= date('d M Y', strtotime($d['tanggal'])) ?></div>
                <div class="mt-2">
                    <?php if($d['status'] == 'Selesai'): ?>
                        <span class="badge bg-success">Lunas / Selesai</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Proses</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-sm-6">
                <h6 class="text-muted fw-bold mb-2">Informasi Pelanggan:</h6>
                <div class="fw-bold fs-5 mb-1"><?= htmlspecialchars($d['nama']) ?></div>
                <!-- Tempat untuk alamat pelanggan jika ada di database -->
                <div class="text-muted small">Pelanggan Reguler</div>
            </div>
        </div>

        <table class="table mb-5">
            <thead>
                <tr>
                    <th>Deskripsi Layanan</th>
                    <th class="text-center">Berat</th>
                    <th class="text-end">Harga/Kg</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-3">
                        <div class="fw-bold">Cuci Kiloan Reguler</div>
                        <small class="text-muted">Cuci, Kering, Setrika, dan Lipat</small>
                    </td>
                    <td class="text-center align-middle"><?= $d['berat'] ?> Kg</td>
                    <td class="text-end align-middle">Rp <?= number_format($harga_perkg, 0, ',', '.') ?></td>
                    <td class="text-end align-middle fw-bold">Rp <?= number_format($d['total'], 0, ',', '.') ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold py-3">Total Pembayaran:</td>
                    <td class="text-end fw-bold fs-5 text-primary py-3">Rp <?= number_format($d['total'], 0, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5">
            <div class="col-12 text-center text-muted small">
                <p class="mb-1">Terima kasih telah mempercayakan cucian Anda pada CleanWave Laundry!</p>
                <p>Cucian yang tidak diambil dalam 30 hari bukan tanggung jawab kami.</p>
            </div>
        </div>

        <div class="no-print d-flex gap-3 justify-content-center mt-5 pt-3 border-top">
            <a href="status.php" class="btn btn-light border px-4"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
            <button onclick="window.print()" class="btn btn-primary px-4"><i class="fa-solid fa-print me-2"></i>Cetak Invoice</button>
            <a href="invoice_pdf.php?id=<?= $d['id'] ?>" class="btn btn-danger px-4" target="_blank"><i class="fa-solid fa-file-pdf me-2"></i>Download PDF</a>
        </div>
    </div>
</div>

</body>
</html>
