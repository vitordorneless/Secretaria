<?php

// cria matriz com os títulos e larguras das colunas
$titulos = array('Posição', 'País', 'Nome', 'Pontuação');
$larguras= array( 3, 5, 5, 3 );

// cria matriz com os dados da tabela
$dados   = array();
$dados[] = array( 1, 'Brazil',         'Ayrton Senna',      90);
$dados[] = array( 2, 'France',         'Alain Prost',       87);
$dados[] = array( 3, 'Austria',        'Gerhard Berger',    41);
$dados[] = array( 4, 'Belgium',        'Thierry Boutsen',   27);
$dados[] = array( 5, 'Italy',          'Michele Alboreto',  24);
$dados[] = array( 6, 'Brazil',         'Nelson Piquet',     22);
$dados[] = array( 7, 'Italy',          'Ivan Capelli',      17);
$dados[] = array( 8, 'United Kingdom', 'Derek Warwick',     17);
$dados[] = array( 9, 'United Kingdom', 'Nigel Mansell',     12);
$dados[] = array(10, 'Italy',          'Alessandro Nannini',12);
$dados[] = array(11, 'Italy',          'Riccardo Patrese',   8);
$dados[] = array(12, 'United States',  'Eddie Cheever',      6);
$dados[] = array(13, 'Brazil',         'Maurício Gugelmin',  5);
$dados[] = array(14, 'United Kingdom', 'Jonathan Palmer',    5);
$dados[] = array(15, 'Italy',          'Andrea de Cesaris',  3);
$dados[] = array(16, 'Japan',          'Satoru Nakajima',    1);
$dados[] = array(17, 'Italy',          'Pierluigi Martini',  1);

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

// fonte do título
$fonte_tit   = new PHPRtfLite_Font(12, 'Arial', '#000000');
$fonte_dados = new PHPRtfLite_Font(10, 'Arial', '#000000');

// cria o cabeçalho da tabela
$i = 1;
$table->addRow(0.5);
foreach ($titulos as $titulo)
{
    $table->addColumn($larguras[$i -1]);
    $table->writeToCell(1, $i, $titulo, $fonte_tit, new PHPRtfLite_ParFormat('center'));
    $i++;
}
// define a cor de fundo da linha 1
$table->setBackgroundForCellRange('#ffff88', 1, 1, 1, $table->getColumnsCount());

$row = 2;
$total = 0;
$colore = FALSE;
// percorre os dados
foreach($dados as $linha)
{
    $table->addRow(0.5);
    // alterna a cor de fundo da linha de dados
    $color = $colore ? '#dedede' : '#ffffff';
    $table->setBackgroundForCellRange($color, $row, 1, $row, $table->getColumnsCount());
    $col = 1;
    foreach ($linha as $coluna)
    {
        // se é inteiro, alinhamento à direita
        if (is_int($coluna))
        {
            $table->writeToCell($row, $col, $coluna, $fonte_dados, new PHPRtfLite_ParFormat('right'));
        }
        // caso contrário, alinhamento à esquerda
        else
        {
            $table->writeToCell($row, $col, $coluna, $fonte_dados, new PHPRtfLite_ParFormat('left'));
        }
        $col ++;
    }
    $colore=!$colore; // inverte cor de fundo
    $total += $linha[3];
    $row ++;
}
// adiciona linha com totais
$table->addRow(0.5);
$table->mergeCellRange($row, 1, $row, 3);
$table->writeToCell($row, 1, 'Total', $fonte_dados, new PHPRtfLite_ParFormat('left'));
$table->writeToCell($row, 4, $total,  $fonte_dados, new PHPRtfLite_ParFormat('right'));

// define cor de fundo da última linha
$table->setBackgroundForCellRange('#a0a0a0', $row, 1, $row, $table->getColumnsCount());

// define bordas para toda a tabela
$table->setBorderForCellRange(PHPRtfLite_Border::create(0.7, '#000000'), 1, 1, $table->getRowsCount(), $table->getColumnsCount());

// envia o RTF ao usuário
$rtf->sendRtf();
?>