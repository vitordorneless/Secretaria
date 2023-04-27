<?php
// inclui a classe Rtf
require 'app.util/rtf/PHPRtfLite.php';
// registra o class loader
PHPRtfLite::registerAutoloader();

// instancia a classe Rtf
$rtf = new PHPRtfLite;

// adiciona uma seção ao documento
$secao = $rtf->addSection();

// define características de fonte
$fontTitulo = new PHPRtfLite_Font(16, 'Arial');
$fontTitulo->setBold();
$fontTitulo->setUnderline();

// escreve o título em Arial 16 negrito, sublinhado e centralizado
$secao->writeText('Características básicas', $fontTitulo, new PHPRtfLite_ParFormat('center'));

// cria um parágrafo vazio
$secao->emptyParagraph(new PHPRtfLite_Font(12), new PHPRtfLite_ParFormat);

// escreve texto utilizando tags HTML
$texto = 'Texto com formatação em <b>negrito</b>, <i>italico</i> e <u>sublinhado</u>. ';
$secao->writeText(str_repeat($texto, 12), new PHPRtfLite_Font(12), new PHPRtfLite_ParFormat('justify'));

// acrescenta uma imagem à seção
$secao->addImage('images/bandeira_brasil.png', new PHPRtfLite_ParFormat('center'), 3);

// define características de fonte
$fontLink = new PHPRtfLite_Font(10, 'Helvetica', '#0000cc');

// escreve um link
$secao->writeHyperlink('http://www.adianti.com.br', 'Adianti Solutions', $fontLink, new PHPRtfLite_ParFormat('center'));

// envia o RTF ao usuário
$rtf->sendRtf();
?>