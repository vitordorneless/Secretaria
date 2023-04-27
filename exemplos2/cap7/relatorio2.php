<?php
// inclui a biblioteca FPDF
require_once 'app.util/pdf/fpdf.php';

// inclui a biblioteca PHPRtfLite
require_once 'app.util/rtf/PHPRtfLite.php';
PHPRtfLite::registerAutoloader();

// inclui os componentes html
require_once 'app.widgets/TElement.class.php';
require_once 'app.widgets/TTable.class.php';
require_once 'app.widgets/TTableRow.class.php';
require_once 'app.widgets/TTableCell.class.php';
require_once 'app.widgets/TStyle.class.php';

// inclui as bibliotecas para escrita de tabelas
require_once 'app.reports/ITableWriter.iface.php';
require_once 'app.reports/TTableWriterHTML.class.php';
require_once 'app.reports/TTableWriterPDF.class.php';
require_once 'app.reports/TTableWriterRTF.class.php';

// define as larguras das colunas da tabela
$widths = array(70, 120, 120, 100, 100);

// define os formatos para gera��o dos relat�rios
$formatos = array('html', 'pdf', 'rtf');

// percorre os formatos definidos
foreach ($formatos as $formato)
{
    // verifica qual formato deve ser utilizado
    switch ($formato)
    {
        case 'html':
            $tr = new TTableWriterHTML($widths);
            break;
        case 'pdf':
            $tr = new TTableWriterPDF($widths);
            break;
        case 'rtf':
            $tr = new TTableWriterRTF($widths);
            break;
    }
    
    // cria os estilos utilizados no documento
    $tr->addStyle('break', 'Arial', '12', 'B',   '#ffffff', '#4A2D8E');
    $tr->addStyle('title', 'Arial', '10', 'BI',  '#ffffff', '#407B49');
    $tr->addStyle('total', 'Arial', '12', 'B',   '#000000', '#646464');
    $tr->addStyle('datap', 'Arial', '10', '',    '#000000', '#869FBB');
    $tr->addStyle('datai', 'Arial', '10', '',    '#000000', '#ffffff');
    $tr->addStyle('header', 'Times', '16', 'BI', '#ff0000', '#FFF1B2');
    $tr->addStyle('footer', 'Times', '16', 'BI', '#2B2B2B', '#B5FFB4');
    
    // acrescenta uma linha para o cabe�alho
    $tr->addRow();
    $tr->addCell('cabe�alho', 'center', 'header', 5);
    
    // acrescenta uma linha para a quebra
    $tr->addRow();
    $tr->addCell('Quebra', 'left', 'break', 5);
    
    // acrescenta uma linha para os t�tulos das colunas
    $tr->addRow();
    $tr->addCell('C�digo',   'left', 'title');
    $tr->addCell('Nome',     'left', 'title');
    $tr->addCell('Endere�o', 'left', 'title');
    $tr->addCell('Telefone', 'left', 'title');
    $tr->addCell('Data',     'left', 'title');
    
    // cria uma vari�vel para controlar o preenchimento
    $colore= FALSE;
    
    // acrescenta v�rias linhas para o conte�do da tabela
    for ($n=0; $n<10; $n ++)
    {
        $style = $colore ? 'datap' : 'datai';
        $tr->addRow();
        $tr->addCell('001',            'left',   $style);
        $tr->addCell('Nome teste',     'left',   $style);
        $tr->addCell('Rua teste',      'left',   $style);
        $tr->addCell('(51) 1234-5678', 'center', $style);
        $tr->addCell('12/12/2010',     'center', $style);
        
        // altera vari�vel de controle
        $colore = !$colore;
    }
    
    // acrescenta uma linha para o total
    $tr->addRow();
    $tr->addCell('',    'left',  'total');
    $tr->addCell('',    'left',  'total');
    $tr->addCell('',    'left',  'total');
    $tr->addCell('123', 'right', 'total');
    $tr->addCell('456', 'right', 'total');
    
    // acrescenta uma linha para o rodap�
    $tr->addRow();
    $tr->addCell('rodap�', 'center', 'footer', 5);
    
    // armazena o relat�rio em um arquivo
    $tr->save("saida2.{$formato}");
    
    // exibe um atalho para o usu�rio realizar download do arquivo
    echo "Relat�rio no formato {$formato} gerado com sucesso<br>";
    echo "<a href='saida2.{$formato}'>Clique aqui para efetuar o download</a><br><br>";
}
?>