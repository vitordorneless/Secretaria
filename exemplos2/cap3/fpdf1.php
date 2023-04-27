<?php
// inclui a classe FPDF
require('app.util/pdf/fpdf.php');

// instancia a classe FPDF
$pdf=new FPDF('P', 'pt', 'A4');

// define os atributos do PDF
$pdf->SetTitle('Teste PDF 1');
$pdf->SetAuthor('Pablo Dall\'Oglio');
$pdf->SetCreator('PHP'.phpversion());
$pdf->SetKeywords('php, pdf');
$pdf->SetSubject('Como criar um PDF com PHP 1');

// adiciona uma pсgina
$pdf->AddPage();

// define a fonte
$pdf->SetFont('Arial','',12);

// marca os quatro cantos da pсgina
$pdf->Text(0, 12, 'X1');
$pdf->Text(576, 12, 'X2');
$pdf->Text(0, 840, 'X3');
$pdf->Text(576, 840, 'X4');

// vinte pontos de espaчamento
$pdf->Ln(20);

// imprie o tэtulo em azul centralizado
$pdf->SetFont('Courier', 'B', 16);
$pdf->SetTextColor(50, 50, 100);
$pdf->SetY(70);
$pdf->SetX(260);
$pdf->Write(30, 'Tэtulo'); // nуo desloca o cursor

// vinte pontos de espaчamento
$pdf->Ln(30);

// cria variсveis de texto com repetiчѕes
$txt = str_repeat('write ', 30);

$pdf->SetTextColor(100, 50, 50);  // tom de vermelho
$pdf->SetFont('Times', 'B', 14);
// imprime texto usando a funчуo Write
$pdf->Write(20, $txt); // nуo desloca o cursor

// imprime texto apѓs alterar coordenada X
$pdf->Ln(40);
$pdf->SetX(200); // altera a posiчуo X
$pdf->SetTextColor(50, 100, 50); // tom de verde
$pdf->Write(20, 'SetX '. $txt);

// imprime dados com hyperlink
$pdf->Ln(40);
$pdf->SetX(260);
$pdf->SetTextColor(0, 0, 255); // azul
$pdf->Write(20, 'Site Adianti', 'http://www.adianti.com.br');

// exibe o resultado no navegador
$pdf->Output();
?>