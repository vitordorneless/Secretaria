<?php
// inclui a biblioteca FPDF
require_once 'app.util/pdf/fpdf.php';

// inclui as bibliotecas para escrita de tabelas
require_once 'app.reports/ITableWriter.iface.php';
require_once 'app.reports/TTableWriterPDF.class.php';

// inclui a classe para gera��o de relat�rios tabulares
require_once 'app.reports/TSimpleReport1.class.php';

// inclui as bibliotecas de acesso � base de dados
require_once 'app.ado/TConnection.class.php';

try
{
    // define as larguras das colunas da tabela
    $widths = array(70, 150, 150, 100);
    $tr = new TTableWriterPDF($widths);
    
    // cria os estilos utilizados no documento
    $tr->addStyle('title', 'Arial', '12', 'B', '#ffffff', '#733131');
    $tr->addStyle('datap', 'Arial', '10', '',  '#000000', '#ffffff');
    $tr->addStyle('datai', 'Arial', '10', '',  '#000000', '#F9F4BF');
    
    // atribui o escritor ao relat�rio
    $sr = new TSimpleReport;
    $sr->setReportWritter($tr);
    
    // adiciona as colunas do relat�rio
    $sr->addColumn('id',       'C�digo',   'center');
    $sr->addColumn('nome',     'Nome',     'left');
    $sr->addColumn('endereco', 'Endere�o', 'left');
    $sr->addColumn('telefone', 'Telefone', 'center');
    
    // define o banco de dados e a consulta
    $sr->setDatabase('exemplos');
    $sr->setQuery('SELECT id, nome, telefone, endereco from pessoa order by nome');
    
    // gera o relat�rio
    $sr->generate();
    $sr->save('saida4.pdf');
}
catch (Exception $e) 
{ 
    echo $e->getMessage(); // exibe a mensagem de erro 
}

// exibe um atalho para o usu�rio realizar download do arquivo
echo "Relat�rio no formato pdf gerado com sucesso<br>";
echo "<a href='saida4.pdf'>Clique aqui para efetuar o download</a><br><br>";
?>