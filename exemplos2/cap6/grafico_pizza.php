<?php
date_default_timezone_set('America/Sao_Paulo');

/**
 * funзгo __autoload() 
 *  Carrega uma classe quando ela й necessбria, 
 *  ou seja, quando ela й instancia pela primeira vez. 
 */ 
function __autoload($classe) 
{ 
    if (file_exists("app.ado/{$classe}.class.php")) 
    { 
        include_once "app.ado/{$classe}.class.php";
    }
} 

try 
{
    
    $ano = 2010; // define o ano-base da consulta
    $conn = TConnection::open('exemplos'); // abre uma conexгo
    
    // define a consulta
    $sql = "SELECT  filial.id as id, filial.nome as filial,".
           "        sum(venda_itens.quantidade * venda_itens.valor) as valor".
           " FROM   venda, venda_itens, filial".
           " WHERE  strftime('%Y', dt_venda) = '$ano' AND".
           "        venda.id = venda_itens.id_venda AND".
           "        venda.id_filial = filial.id".
           " GROUP BY 1".
           " ORDER BY 1";
    
    $result  = $conn->query($sql); // executa a instruзгo SQL
    
    // inicializa vetores utilizados no exemplo
    $dados   = array();
    $rotulos = array();
    $links   = array();
    $texto   = array();
    
    foreach ($result as $row)
    {
        // lк as variбveis da consulta
        $id        = $row['id'];
        $filial    = $row['filial'];
        $valor     = $row['valor'];
        
        // cria os vetores de dados e rуtulos de legenda
        $dados[]   = $valor;
        $rotulos[] = $filial;
        
        // cria os vetores de links e rуtulos de link
        $links[] = "list_vendas.php?filial={$id}&ano={$ano}";
        $texto[] = 'venda R$ %d';
    }
    
    // inclui a biblioteca base e para grбficos de torta
    require_once ('app.util/graph/jpgraph.php');
    require_once ('app.util/graph/jpgraph_pie.php');
    require_once ('app.util/graph/jpgraph_pie3d.php');
    
    // cria o grбfico
    $graph = new PieGraph(600,400);
    
    // habilita sombreamento na imagem
    $graph->SetShadow();
    
    // define o tнtulo do grбfico
    $graph->title->Set("Vendas por filial em {$ano}");
    $graph->title->SetFont(FF_FONT1,FS_BOLD);
    
    // cria uma plotagem do tipo torta 3D
    $pieplot = new PiePlot3D($dados);
    
    // indica uma fatia para estar em destaque
    $pieplot->ExplodeSlice(1);
    
    // posiciona o centro do grбfico
    $pieplot->SetCenter(0.4, 0.6);
    
    // define os links e rуtulos das barras
    $pieplot->SetCSIMTargets($links, $texto);
    
    // define as legendas
    $pieplot->SetLegends($rotulos);
    
    // adiciona a plotagem ao grбfico
    $graph->Add($pieplot);
    
    // exibe o grбfico no navegador
    $graph->StrokeCSIM();
} 
catch (Exception $e) 
{ 
    echo $e->getMessage(); // exibe a mensagem de erro
} 
?>