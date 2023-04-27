<?php
// inclui a classe Rtf
require 'app.util/rtf/PHPRtfLite.php';
// registra o class loader
PHPRtfLite::registerAutoloader();

// instancia a classe Rtf
$rtf = new PHPRtfLite;

// adiciona uma seção ao documento
$secao = $rtf->addSection();

// escreve o tí­tulo em Arial 16 negrito, sublinhado e centralizado
$secao->writeText('<b><u>Formatação de parágrafos</b></u>', new PHPRtfLite_Font(16, 'Arial'), new PHPRtfLite_ParFormat('center'));

// cria um parágrafo vazio
$secao->emptyParagraph(new PHPRtfLite_Font(12), new PHPRtfLite_ParFormat);

$paragrafo1 = new PHPRtfLite_ParFormat('center');
$secao->writeText('Verdana, 10pt, Verde', new PHPRtfLite_Font(10, 'Verdana', '#00cc00'), $paragrafo1);
$secao->writeText('Arial, 10pt, Vermelho, fundo Amarelo', new PHPRtfLite_Font(10, 'Arial', '#ff0000', '#ffff00'), $paragrafo1);
$secao->writeText('Tahoma, 10pt, Azul', new PHPRtfLite_Font(10, 'Tahoma', '#0000ff'), $paragrafo1);
$secao->writeText('<b>Courier, 10pt, Laranja, negrito</b>', new PHPRtfLite_Font(10, 'Courier', '#FF7500'), $paragrafo1);

// parágrafo com cor de fundo, espaçamento
// antes e depois e identação na primeira linha
$paragrafo2 = new PHPRtfLite_ParFormat('justify');
$paragrafo2->setIndentFirstLine(2);
$paragrafo2->setBackgroundColor('#BCE5B7');
$paragrafo2->setSpaceBefore(10); // 10 pontos
$paragrafo2->setSpaceAfter(10); // 10 pontos
$secao->writeText(str_repeat('Parágrafo com fundo verde. ', 12), new PHPRtfLite_Font(8, 'Verdana'), $paragrafo2);

// parágrafo com bordas e espaçamento
// à esquerda e direita
$paragrafo3 = new PHPRtfLite_ParFormat('justify');
$paragrafo3->setIndentLeft(2);
$paragrafo3->setIndentRight(2);
$paragrafo3->setBorder(PHPRtfLite_Border::create(1.5, '#000000'));
$secao->writeText(str_repeat('Parágrafo com bordas. ', 12), new PHPRtfLite_Font(8, 'Verdana'), $paragrafo3);

// envia o RTF ao usuário
$rtf->sendRtf();
?>
