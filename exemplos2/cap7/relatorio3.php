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

// inclui as bibliotecas de acesso � base de dados
require_once 'app.ado/TConnection.class.php';

// define as larguras das colunas da tabela
$widths = array(70, 150, 150, 100);

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
    $tr->addStyle('title', 'Arial', '12', 'B', '#000000', '#B5B3DF');
    $tr->addStyle('datap', 'Arial', '10', '',  '#000000', '#ffffff');
    $tr->addStyle('datai', 'Arial', '10', '',  '#000000', '#CCCCCC');
    
    // acrescenta uma linha para os t�tulos das colunas
    $tr->addRow();
    $tr->addCell('C�digo',   'center', 'title');
    $tr->addCell('Nome',     'left',   'title');
    $tr->addCell('Endere�o', 'left',   'title');
    $tr->addCell('Telefone', 'center', 'title');
    
    try
    {
        $conn = TConnection::open('exemplos'); // abre uma conex�o
        
        // define a consulta
        $sql = "SELECT id, nome, endereco, telefone ".
               " FROM pessoa".
               " ORDER BY nome";
        
        // executa a instru��o SQL
        $result = $conn->query($sql);
        
        $colore = FALSE;
        foreach ($result as $row)
        {
            // define o estilo a ser utilizado
            $style = $colore ? 'datap' : 'datai';
            
            // acrescenta um alinha de conte�do
            $tr->addRow();
            $tr->addCell($row['id'],       'center',   $style);
            $tr->addCell($row['nome'],     'left',     $style);
            $tr->addCell($row['endereco'], 'left',     $style);
            $tr->addCell($row['telefone'], 'center',   $style);
            
            $colore = !$colore;
        }
    }
    catch (Exception $e) 
    { 
        echo $e->getMessage(); // exibe a mensagem de erro 
    }
     
    // armazena o relat�rio em um arquivo
    $tr->save("saida3.{$formato}");
    
    // exibe um atalho para o usu�rio realizar download do arquivo
    echo "Relat�rio no formato {$formato} gerado com sucesso<br>";
    echo "<a href='saida3.{$formato}'>Clique aqui para efetuar o download</a><br><br>";
}
?>