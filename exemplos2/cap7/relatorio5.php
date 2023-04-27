<?php
// inclui a biblioteca FPDF
require_once 'app.util/pdf/fpdf.php';

// inclui as bibliotecas para escrita de tabelas
require_once 'app.reports/ITableWriter.iface.php';
require_once 'app.reports/TTableWriterPDF.class.php';

// inclui a classe para geração de relatórios tabulares
require_once 'app.reports/TSimpleReport2.class.php';

// inclui as bibliotecas de acesso à base de dados
require_once 'app.ado/TConnection.class.php';

try
{
    // define as larguras das colunas da tabela
    $widths = array(300, 80, 100);
    $tr = new TTableWriterPDF($widths);
    
    // cria os estilos utilizados no documento
    $tr->addStyle('title', 'Arial', '12', 'B', '#ffffff', '#733131');
    $tr->addStyle('group', 'Arial', '10', 'B', '#000000', '#8CD68B');
    $tr->addStyle('datap', 'Arial', '10', '',  '#000000', '#ffffff');
    $tr->addStyle('datai', 'Arial', '10', '',  '#000000', '#F9F4BF');
    $tr->addStyle('total', 'Arial', '10', 'B', '#ffffff', '#6BA3A6');
    
    // atribui o escritor ao relatório
    $sr = new TSimpleReport;
    $sr->setReportWritter($tr);
    
    // adiciona as colunas do relatório
    $sr->addColumn('descricao', 'Descrição', 'left');
    $sr->addColumn('unidade',   'Unidade',   'center');
    $sr->addColumn('total',     'Valor',     'right');
    
    // define o banco de dados e a consulta
    $sr->setDatabase('exemplos');
    $sr->setQuery(' SELECT fabricante.nome, produto.descricao, produto.unidade,
                           produto.estoque * produto.preco_venda  as total
                      FROM produto, fabricante
                     WHERE produto.id_fabricante = fabricante.id
                  ORDER BY fabricante.nome
                     LIMIT 200');
    
    // grupo por nome do fabricante
    $sr->setGroup('nome');
    $sr->setTotal('descricao', 'count');
    $sr->setTotal('total',     'sum');
    
    // gera o relatório
    $sr->generate();
    $sr->save('saida5.pdf');
}
catch (Exception $e) 
{ 
    echo $e->getMessage(); // exibe a mensagem de erro 
}

// exibe um atalho para o usuário realizar download do arquivo
echo "Relatório no formato pdf gerado com sucesso<br>";
echo "<a href='saida5.pdf'>Clique aqui para efetuar o download</a><br><br>";
?>