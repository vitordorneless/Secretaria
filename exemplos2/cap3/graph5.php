<?php
date_default_timezone_set('America/Sao_Paulo');

// inclui a biblioteca base e para grбficos de barra
require_once ('app.util/graph/jpgraph.php');
require_once ('app.util/graph/jpgraph_bar.php');

// Define um vetor com os dados a serem exibidos
$dados=array(80, 50, 120, 170);

// cria o grбfico e define a escala
$graph = new Graph(400,250);	
$graph->SetScale("textlin");
// habilita sombreamento na imagem
$graph->SetShadow();
// define as margens
$graph->SetMargin(40,20,40,40);

// define o tнtulo do grбfico e dos eixos
$graph->title->Set('Vendas por mes');
$graph->xaxis->title->Set('mes');
$graph->yaxis->title->Set('vendas (R$)');

// define a orientaзгo das marcas
$graph->xaxis->SetTickSide(SIDE_DOWN);
$graph->yaxis->SetTickSide(SIDE_LEFT);

// cria a plotagem de barras
$barplot = new BarPlot($dados);

// define a cor das barras
$barplot->SetFillColor('#47C048');

// define os links e rуtulos das barras
$targ=array('alvo.php?id=1', 'alvo.php?id=2', 'alvo.php?id=3', 'alvo.php?id=4');
$alts=array('venda R$ %d', 'venda R$ %d', 'venda R$ %d', 'venda R$ %d');
$barplot->SetCSIMTargets($targ, $alts);

// habilita a exibiзгo do valor
$barplot->value->Show();
$barplot->value->SetFormat(" R$ %2.1f");
$barplot->value->SetColor("blue");

// adiciona a plotagem ao grбfico
$graph->Add($barplot);

// exibe o grбfico no navegador
$graph->StrokeCSIM();
?>