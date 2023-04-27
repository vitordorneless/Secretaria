<?php
// inclui a classe FPDF
require('app.util/pdf/fpdf.php');

// instancia a classe FPDF
$pdf=new FPDF('P', 'pt', 'A4');

// adiciona uma pсgina
$pdf->AddPage();

// define a fonte
$pdf->SetFont('Arial','B',16);

// imprime duas versѕes do tэtulo
$pdf->Cell(510, 20, 'Tэtulo sem borda', 0, 1, 'C');
$pdf->Cell(510, 20, 'Tэtulo com borda', 1, 1, 'C');
$pdf->Ln(20);

// imprime cщlula vermelha alinhada р esquerda
$pdf->SetFillColor(255,120,120);
$pdf->Cell(170, 30,'Alinhado a esquerda', 1, 0, 'L', TRUE, 'www.teste.com');

// imprime cщlula verde alinhada ao centro
$pdf->SetFillColor(170,255,120);
$pdf->Cell(170, 30,'Alinhado ao centro', 1, 0, 'C', TRUE, 'www.teste.com');

// imprime cщlula azul alinhada р direita
$pdf->SetFillColor(100,100,255);
$pdf->Cell(170, 30,'Alinhado a direita', 1, 1, 'R', TRUE, 'www.teste.com');

// cria variсveis de texto com repetiчѕes
$txt1 = str_repeat('cell ', 40);
$txt2 = str_repeat('multicell ', 12);

// vinte pontos de espaчamento
$pdf->Ln(20);

// imprime usando a funчуo Cell
$pdf->SetFont('Times', 'B', 14);
$pdf->SetTextColor(100, 50, 50); // tom de vermelho
$pdf->Cell(510, 20, $txt1, 0, 1, 'L', FALSE);

$pdf->Ln(20);

// imprime usando a funчуo MultiCell
$pdf->SetTextColor(50, 100, 50); // tom de verde
$pdf->MultiCell(510, 20, $txt2, 0, 'L', FALSE);
$pdf->Ln(10);
$pdf->MultiCell(510, 20, $txt2, 1, 'L', FALSE);

$pdf->Ln(20);
$pdf->SetX(200); // altera a posiчуo X
$pdf->MultiCell(340, 20, 'SetX '. $txt2, 1, 'L', FALSE);
$pdf->Ln(20);

// exibe o resultado no navegador
$pdf->Output();
?>