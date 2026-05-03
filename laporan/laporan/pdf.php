<?php 
require_once '../config/database.php';

require_once '../fpdf/fpdf.php';

if (!isset($_SESSION['login'])) {
    die("Akses ditolak");
}

$d = isset($_POST['dari']) ? $conn->real_escape_string($_POST['dari']) : date('Y-m-d', strtotime('-30 days'));
$s = isset($_POST['sampai']) ? $conn->real_escape_string($_POST['sampai']) : date('Y-m-d');

$data = $conn->query("SELECT * FROM transaksi WHERE tanggal BETWEEN '$d' AND '$s' ORDER BY tanggal ASC");

class PDF extends FPDF {
    // Header
    function Header() {
        $this->SetFont('Arial','B',16);
        $this->SetTextColor(37, 99, 235);
        $this->Cell(0,8,'LAPORAN TRANSAKSI CLEANWAVE LAUNDRY',0,1,'C');
        
        $this->SetFont('Arial','',10);
        $this->SetTextColor(100, 116, 139);
        $this->Cell(0,5,'Jl. Perum Sudirman Indah No. 123, Tangerang | Telp: 0851-4374-1393',0,1,'C');
        $this->Ln(5);
        
        $this->SetDrawColor(226, 232, 240);
        $this->Line(10, 25, 200, 25);
        $this->Ln(5);
    }

    // Footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(100, 116, 139);
        $this->Cell(0,10,'Halaman '.$this->PageNo().' - Dicetak pada: '.date('d/m/Y H:i'),0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();

// Periode
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(51, 65, 85);
$pdf->Cell(40,8,'Periode Laporan',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,': '.date('d M Y', strtotime($d)).' s/d '.date('d M Y', strtotime($s)),0,1);
$pdf->Ln(5);

// Table Header
$pdf->SetFillColor(241, 245, 249);
$pdf->SetTextColor(51, 65, 85);
$pdf->SetDrawColor(226, 232, 240);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(10,10,'No',1,0,'C',true);
$pdf->Cell(30,10,'Tanggal',1,0,'C',true);
$pdf->Cell(60,10,'Nama Pelanggan',1,0,'C',true);
$pdf->Cell(20,10,'Berat',1,0,'C',true);
$pdf->Cell(30,10,'Status',1,0,'C',true);
$pdf->Cell(40,10,'Total',1,1,'C',true);

// Table Data
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);

$no = 1;
$totalSemua = 0;

if($data->num_rows > 0) {
    while($row = $data->fetch_assoc()){
        $pdf->Cell(10,10,$no++,1,0,'C');
        $pdf->Cell(30,10,date('d/m/Y', strtotime($row['tanggal'])),1,0,'C');
        $pdf->Cell(60,10,$row['nama'],1,0,'L');
        $pdf->Cell(20,10,$row['berat'].' Kg',1,0,'C');
        $pdf->Cell(30,10,$row['status'],1,0,'C');
        $pdf->Cell(40,10,'Rp '.number_format($row['total'], 0, ',', '.'),1,1,'R');
        
        $totalSemua += $row['total'];
    }
    
    // Total akhir
    $pdf->SetFont('Arial','B',11);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(150,12,'TOTAL PENDAPATAN',1,0,'R');
    $pdf->SetTextColor(37, 99, 235);
    $pdf->Cell(40,12,'Rp '.number_format($totalSemua, 0, ',', '.'),1,1,'R');
    
} else {
    $pdf->Cell(190,10,'Tidak ada data transaksi pada periode ini.',1,1,'C');
}

$pdf->Output('I', 'Laporan_Laundry_'.date('Ymd', strtotime($d)).'_'.date('Ymd', strtotime($s)).'.pdf');
?>
