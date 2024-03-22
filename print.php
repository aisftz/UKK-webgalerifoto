<?php
require_once('assets/fpdf/fpdf.php'); // Sesuaikan path dengan lokasi library fpdf

class PDF extends FPDF {
    // Page header
    function Header() {
        // Logo
        $this->Image('img/Batman-Logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Title
        $this->Cell(0,10,'Web Galeri Foto',0,1,'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Retrieve foto details
if(isset($_GET['id'])) {
    $foto_id = $_GET['id'];
    
    // Fetch foto details from database
    include('proses/koneksi.php'); // Include your database connection file
    
    $query = "SELECT * FROM foto WHERE fotoid='$foto_id'";
    $result = $conn->query($query);
    
    if($result->num_rows > 0) {
        $foto = $result->fetch_assoc();
        
        // Add foto details to PDF
        $pdf->Cell(0,10,'Judul Foto: '.$foto['judulfoto'],0,1);
        $pdf->Cell(0,10,'Deskripsi: '.$foto['deskripsifoto'],0,1);
        $pdf->Cell(0,10,'Tanggal: '.$foto['tanggalunggah'],0,1);
        
        // Add foto to PDF
        $image = 'assets/img/'.$foto['lokasifile'];
        $pdf->Image($image,10,40,100); // Adjust position and size as needed
    } else {
        $pdf->Cell(0,10,'Foto not found!',0,1);
    }
} else {
    $pdf->Cell(0,10,'Invalid request!',0,1);
}

$pdf->Output();
?>