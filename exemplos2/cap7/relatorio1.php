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
$widths = array(70, 150, 150, 100);

// define os formatos para geração dos relatórios
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
    $tr->addStyle('title', 'Arial', '10', 'B', '#ffffff', '#737373');
    $tr->addStyle('data',  'Arial', '10', '',  '#000000', '#ffffff');
    
    // acrescenta uma linha para os títulos das colunas
    $tr->addRow();
    $tr->addCell('Código',   'left', 'title');
    $tr->addCell('Nome',     'left', 'title');
    $tr->addCell('Endereço', 'left', 'title');
    $tr->addCell('Telefone', 'left', 'title');
    
    // acrescenta um alinha de conteúdo
    $tr->addRow();
    $tr->addCell('001',                   'left',   'data');
    $tr->addCell('Ayrton Senna da Silva', 'left',   'data');
    $tr->addCell('Rua dos campeões, 123', 'left',   'data');
    $tr->addCell('(51) 1234-5678',        'center', 'data');
    
    // acrescenta um alinha de conteúdo
    $tr->addRow();
    $tr->addCell('001',                   'left',   'data');
    $tr->addCell('John Lennon',           'left',   'data');
    $tr->addCell('Rua dos ídolos, 123',   'left',   'data');
    $tr->addCell('(51) 1234-5678',        'center', 'data');
    
    // acrescenta um alinha de conteúdo
    $tr->addRow();
    $tr->addCell('001',                   'left',   'data');
    $tr->addCell('Charlie Chaplin',       'left',   'data');
    $tr->addCell('Rua dos gênios, 123',   'left',   'data');
    $tr->addCell('(51) 1234-5678',        'center', 'data');
    
    // acrescenta um alinha de conteúdo
    $tr->addRow();
    $tr->addCell('001',                   'left',   'data');
    $tr->addCell('Giuseppe Garibaldi',    'left',   'data');
    $tr->addCell('Rua dos heróis, 123',   'left',   'data');
    $tr->addCell('(51) 1234-5678',        'center', 'data');
    
    // armazena o relatório em um arquivo
    $tr->save("saida1.{$formato}");
    
    // exibe um atalho para o usuário realizar download do arquivo
    echo "Relatório no formato {$formato} gerado com sucesso<br>";
    echo "<a href='saida1.{$formato}'>Clique aqui para efetuar o download</a><br><br>";
}
?>