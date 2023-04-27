<?php

date_default_timezone_set('America/Sao_Paulo');

// inclui a biblioteca base e para gráficos de barra
require_once ('app.util/graph/jpgraph.php');
require_once ('app.util/graph/jpgraph_bar.php');

// Define um vetor com os dados a serem exibidos
$dados=array(120,80,170,40,100);

// cria o gráfico e define a escala
$graph = new Graph(400,250);	
$graph->SetScale("textlin");
// habilita sombreamento na imagem
$graph->SetShadow();
// define as margens
$graph->SetMargin(40,20,40,40);

// define o título do gráfico e dos eixos
$graph->title->Set('Vendas por mes');
$graph->xaxis->title->Set('mes');
$graph->yaxis->title->Set('vendas (R$)');

// cria a plotagem de barras
$barplot = new BarPlot($dados);

// define a cor das barras
$barplot->SetFillColor('orange');

// habilita a exibição do valor
$barplot->value->Show();
$barplot->value->SetFormat(" R$ %2.1f");
$barplot->value->SetColor("blue");

// adiciona a plotagem ao gráfico
$graph->Add($barplot);

// define estilo negrito para as fontes
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// exibe o gráfico no navegador
$graph->Stroke();
?>