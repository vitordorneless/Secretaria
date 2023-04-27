<?php
// inclui a classe Rtf
require 'app.util/rtf/PHPRtfLite.php';
// registra o class loader
PHPRtfLite::registerAutoloader();

// instancia a classe Rtf
$rtf = new PHPRtfLite;

// adiciona uma seção ao documento
$secao = $rtf->addSection();

// adiciona a tabela
$table = $secao->addTable();
// adiciona 1 linha de 3 cm de altura
$table->addRows(1, 3);
// adiciona 2 linhas de 0.5 cm de altura
$table->addRows(2, 0.5);
// adiciona 1 linha de 4 cm de altura
$table->addRows(1, 4);
$table->addColumnsList(array(5,5,5));

// borda para todas células da tabela
$table->setBorderForCellRange(PHPRtfLite_Border::create(1, '#000000'), 1, 1, $table->getRowsCount(), $table->getColumnsCount());

// declara as fontes a serem utilizadas
$fonte1 = new PHPRtfLite_Font(12, 'Times new Roman', '#FF0000');
$fonte2 = new PHPRtfLite_Font(12, 'Times new Roman', '#0000FF');
$fonte3 = new PHPRtfLite_Font(12, 'Times new Roman', '#5DA75A');

// escreve texto em célula com tags HTML
$table->writeToCell(1, 1, '<b>Célula 1,1</b>', $fonte1, new PHPRtfLite_ParFormat('left'));
$table->writeToCell(1, 2, '<b>Célula 1,2</b>', $fonte2, new PHPRtfLite_ParFormat('center'));
$table->writeToCell(1, 3, '<b>Célula 1,3</b>', $fonte3, new PHPRtfLite_ParFormat('right'));

// adiciona mais duas linhas
for ($n=2; $n<=3; $n++)
{
    $table->writeToCell($n, 1, 'texto qualquer', new PHPRtfLite_Font, new PHPRtfLite_ParFormat('left'));
    $table->writeToCell($n, 2, 'texto qualquer', new PHPRtfLite_Font, new PHPRtfLite_ParFormat('center'));
    $table->writeToCell($n, 3, 'texto qualquer', new PHPRtfLite_Font, new PHPRtfLite_ParFormat('right'));
}

// adiciona uma imagem na célula 4,2
$table->addImageToCell(4, 2, 'images/basquete.jpg', new PHPRtfLite_ParFormat('center'), 3);

// envia o RTF ao usuário
$rtf->sendRtf();
?>