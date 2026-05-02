<?php 
require_once '../config/database.php';

require_once '../fpdf/fpdf.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$q = $conn->query("SELECT * FROM transaksi WHERE id=$id");

if($q->num_rows == 0) {
    die("Data tidak ditemukan!");
}
$data = $q->fetch_assoc();

class PDF extends FPDF {
    // Header
    function Header() {
        // Logo atau Nama Laundry
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(37, 99, 235); // Blue Primary Color
        $this->Cell(0,10,'CleanWave Laundry',0,1,'C');
        
        $this->SetFont('Arial','',10);
        $this->SetTextColor(100, 116, 139); // Text muted
        $this->Cell(0,5,'Jl. Contoh Laundry No. 123, Jakarta | Telp: 0812-3456-7890',0,1,'C');
        $this->Ln(5);
        
        // Garis Header
        $this->SetDrawColor(226, 232, 240); // Border color
        $this->Line(10, 30, 200, 30);
        $this->Ln(5);
    }

    // Footer
    function Footer() {
        $this->SetY(-30);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(100, 116, 139);
        $this->Cell(0,5,'Terima kasih telah mempercayakan cucian Anda pada kami.',0,1,'C');
        $this->Cell(0,5,'Cucian yang tidak diambil lebih dari 30 hari di luar tanggung jawab kami.',0,1,'C');
        $this->Cell(0,10,'Halaman '.$this->PageNo(),0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();

// Judul Invoice
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(51, 65, 85); // Dark Slate
$pdf->Cell(0,10,'INVOICE PELANGGAN',0,1,'C');
$pdf->Ln(5);

// Info Invoice
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,8,'No. Invoice',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,': #INV'.str_pad($data['id'], 5, '0', STR_PAD_LEFT),0,1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,8,'Tanggal',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,': '.date('d M Y', strtotime($data['tanggal'])),0,1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,8,'Nama Pelanggan',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,': '.$data['nama'],0,1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,8,'Status',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,': '.$data['status'],0,1);

$pdf->Ln(10);

// Table Header
$pdf->SetFillColor(241, 245, 249); // bg-light
$pdf->SetTextColor(51, 65, 85);
$pdf->SetDrawColor(226, 232, 240);
$pdf->SetFont('Arial','B',11);

$pdf->Cell(80,10,'Deskripsi Layanan',1,0,'C',true);
$pdf->Cell(40,10,'Berat',1,0,'C',true);
$pdf->Cell(70,10,'Subtotal',1,1,'C',true);

// Table Data
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(0,0,0);

$pdf->Cell(80,12,'Cuci Kiloan Reguler',1,0,'C');
$pdf->Cell(40,12,$data['berat'].' Kg',1,0,'C');
$pdf->Cell(70,12,'Rp '.number_format($data['total'], 0, ',', '.'),1,1,'R');

// Total Akhir
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(120,12,'TOTAL PEMBAYARAN',1,0,'R');
$pdf->SetTextColor(37, 99, 235); // Blue
$pdf->Cell(70,12,'Rp '.number_format($data['total'], 0, ',', '.'),1,1,'R');

$pdf->Output('I', 'Invoice_INV'.str_pad($data['id'], 5, '0', STR_PAD_LEFT).'.pdf');
?>
