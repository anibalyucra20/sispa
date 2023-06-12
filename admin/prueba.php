<?php
include_once('include/verificar_sesion_docente_coordinador_secretaria.php');
require_once('../tcpdf/tcpdf.php');
include_once('../include/conexion.php');
include_once('include/busquedas.php');

class PDF extends TCPDF {
  function Header() {
    $this->SetFont('helvetica', 'B', 16);
    $this->Cell(0, 10, 'Mi Documento PDF', 0, 1, 'C');
  }

  function Footer() {
    $this->SetY(-15);
    $this->SetFont('helvetica', 'I', 8);
    $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
  }

  function Content() {
    $this->SetFont('helvetica', '', 12);

    // Colocar texto verticalmente
    $this->StartTransform();
    $this->Rotate(90); // Girar el contenido 90 grados en sentido horario
    $this->Text(-50, 50, 'Texto vertical');
    $this->StopTransform();

    $this->Cell(0, 10, '¡Hola, mundo!', 0, 1);
  }
}

$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('TCPDF');
$pdf->SetAuthor('Autor');
$pdf->SetTitle('Mi Documento PDF');
$pdf->SetAutoPageBreak(true, 15);

$pdf->AddPage();
$pdf->Content();
$pdf->Output('documento.pdf', 'I');
?>