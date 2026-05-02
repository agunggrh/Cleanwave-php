<?php 
require_once '../config/database.php';

if (!isset($_SESSION['login'])) {
    die("Akses ditolak");
}

$d = isset($_POST['dari']) ? $conn->real_escape_string($_POST['dari']) : date('Y-m-d', strtotime('-30 days'));
$s = isset($_POST['sampai']) ? $conn->real_escape_string($_POST['sampai']) : date('Y-m-d');

$data_transaksi = $conn->query("SELECT * FROM transaksi WHERE tanggal BETWEEN '$d' AND '$s' ORDER BY tanggal ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Laundry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2563eb;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f8f9fa;
        }
        table td.right {
            text-align: right;
        }
        table td.center {
            text-align: center;
        }
        .total-row th {
            text-align: right;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 5px; cursor: pointer;">Cetak Sekarang</button>
    </div>

    <div class="header">
        <h1>CleanWave Laundry</h1>
        <p>Jl. Contoh Laundry No. 123, Jakarta | Telp: 0812-3456-7890</p>
        <h3 style="margin-top: 20px; color: #333;">Laporan Transaksi</h3>
        <p>Periode: <?= date('d M Y', strtotime($d)) ?> s/d <?= date('d M Y', strtotime($s)) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="center">No</th>
                <th width="15%">Tanggal</th>
                <th>Nama Pelanggan</th>
                <th width="10%">Berat</th>
                <th width="15%">Status</th>
                <th width="20%" class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $totalSemua = 0;
            if($data_transaksi->num_rows > 0):
                while($row = $data_transaksi->fetch_assoc()):
                    $totalSemua += $row['total'];
            ?>
            <tr>
                <td class="center"><?= $no++ ?></td>
                <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['berat'] ?> Kg</td>
                <td><?= $row['status'] ?></td>
                <td class="right">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
            </tr>
            <?php 
                endwhile;
            else:
            ?>
            <tr>
                <td colspan="6" class="center">Tidak ada transaksi pada periode ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <?php if($data_transaksi->num_rows > 0): ?>
        <tfoot>
            <tr class="total-row">
                <th colspan="5">TOTAL PENDAPATAN</th>
                <th class="right" style="font-size: 16px;">Rp <?= number_format($totalSemua, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>

    <div style="text-align: right; margin-top: 50px; padding-right: 50px;">
        <p>Jakarta, <?= date('d M Y') ?></p>
        <br><br><br>
        <p>( ____________________ )</p>
        <p>Admin CleanWave</p>
    </div>

</body>
</html>
