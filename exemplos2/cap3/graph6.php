<?php
date_default_timezone_set('America/Sao_Paulo');

// inclui a biblioteca base e para gr�ficos de barra
require_once ('app.util/graph/jpgraph.php');
require_once ('app.util/graph/jpgraph_bar.php');

// Define um vetor com os dados a serem exibidos
$dados   = array(100, 120, 40, 70);
$rotulos = array('Maria', 'Marcos', 'Mariana', 'Pedro');

// cria o gr�fico e define a escala
$graph = new Graph(400,250);	
$graph->SetScale("textlin");
// habilita sombreamento na imagem
$graph->SetShadow();
// define as margens
$graph->Set90AndMargin(50, 30, 50, 30);

// define o t�tulo do gr�fico e dos eixos
$graph->title->Set('Vendas por mes');
$graph->xaxis->SetTickLabels($rotulos);
$graph->yaxis->scale->SetGrace(20);

// cria a plotagem de barras
$barplot = new BarPlot($dados);

// define a cor das barras
$barplot->SetFillColor('orange');

// habilita a exibi��o do valor
$barplot->value->Show();
$barplot->value->SetFormat(" R$ %2.2f");
$barplot->value->SetColor("blue");

// adiciona a plotagem ao gr�fico
$graph->Add($barplot);

// exibe o gr�fico no navegador
$graph->Stroke();
?>