<?php
date_default_timezone_set('America/Sao_Paulo');

// inclui a biblioteca base e para gráficos de torta
require_once ('app.util/graph/jpgraph.php');
require_once ('app.util/graph/jpgraph_pie.php');
require_once ('app.util/graph/jpgraph_pie3d.php');

// Define um vetor com os dados a serem exibidos
$dados   = array(100, 120, 40, 70);
$rotulos = array('Maria', 'Marcos', 'Mariana', 'Pedro');

// cria o gráfico
$graph = new PieGraph(400,250);
// habilita sombreamento na imagem
$graph->SetShadow();

// define o título do gráfico
$graph->title->Set("Vendas em Março");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

// cria uma plotagem do tipo torta 3D
$pieplot = new PiePlot3D($dados);
// indica uma fatia para estar em destaque
$pieplot->ExplodeSlice(1);
// posiciona o centro do gráfico
$pieplot->SetCenter(0.45);

// define os links e rótulos das barras
$targ=array('alvo.php?id=1', 'alvo.php?id=2', 'alvo.php?id=3', 'alvo.php?id=4');
$alts=array('venda R$ %d', 'venda R$ %d', 'venda R$ %d', 'venda R$ %d');
$pieplot->SetCSIMTargets($targ,$alts);

// define as legendas
$pieplot->SetLegends($rotulos);

// adiciona a plotagem ao gráfico
$graph->Add($pieplot);

// exibe o gráfico no navegador
$graph->StrokeCSIM();
?>