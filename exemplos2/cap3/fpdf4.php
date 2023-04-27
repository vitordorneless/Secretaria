<?php
// figuras geometricas e imagens
require('app.util/pdf/fpdf.php');

$pdf=new FPDF('P', 'pt', 'A4');
$pdf->AddPage();
// define as margens do documento
$pdf->SetMargins(100, 100, 100);

// exibe uma imagem
$pdf->Image('images/basquete.jpg', 20, 20, 120);

$x = 160;
$y = 10;

// exibe ret�ngulo vermelho
$pdf->SetFillColor(255,120,120);
$pdf->Rect($x, $y, 200, 100, 'DF');

$x += 20;
$y += 20;

// exibe ret�ngulo verde
$pdf->SetFillColor(170,255,120);
$pdf->Rect($x, $y, 200, 100, 'DF');

$x += 20;
$y += 20;

// exibe ret�ngulo azul
$pdf->SetLineWidth(4);
$pdf->SetDrawColor(255, 255, 0);
$pdf->SetFillColor(100,100,255);
$pdf->Rect($x, $y, 200, 100, 'DF');

// exibe uma imagem
$pdf->Image('images/basquete.jpg', 450, 20, 120);

// define a posi��o do cursor
$pdf->SetXY(300, 100);

$pdf->SetFont('Arial','B',19);
$pdf->SetTextColor(255, 255, 255);
$pdf->Text(220, 100, 'TEXTO CENTRO');

// define a posi��o do cursor
$pdf->SetX(20);
$pdf->SetY(160);

$pdf->SetDrawColor(255, 0, 0);
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 400, $pdf->GetY());

$pdf->Output();
?>