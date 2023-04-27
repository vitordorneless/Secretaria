<?php
// inclui a classe Rtf
require 'app.util/rtf/PHPRtfLite.php';
// registra o class loader
PHPRtfLite::registerAutoloader();

// instancia a classe Rtf
$rtf = new PHPRtfLite;
$rtf->setMargins(3,3,3,3);
$rtf->setPaperWidth(21);
$rtf->setPaperHeight(16);

$font_head = new PHPRtfLite_Font(12, 'Arial', '#FF0000');
$font_foot = new PHPRtfLite_Font(12, 'Arial', '#58A055');
// $rtf->setOddEvenDifferent();

$header = $rtf->addHeader();
$header->writeText('<b>Cabeçalho do documento</b>', $font_head, new PHPRtfLite_ParFormat('center'));
$header->addImage('images/banner.jpg', new PHPRtfLite_ParFormat('center'), 15);

$footer = $rtf->addFooter();
$footer->writeText('<b>Rodapé do documento</b>', $font_foot, new PHPRtfLite_ParFormat('center'));
$footer->writeText('<i>Página <pagenum></i>', $font_foot, new PHPRtfLite_ParFormat('center'));

// adiciona uma seção ao documento
$secao = $rtf->addSection();

$secao->writeText(str_repeat('texto qualquer ', 1000), new PHPRtfLite_Font(8, 'Verdana'), new PHPRtfLite_ParFormat('justify'));

// envia o RTF ao usuário
$rtf->sendRtf();
?>