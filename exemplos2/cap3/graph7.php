<?php
date_default_timezone_set('America/Sao_Paulo');

// inclui a biblioteca base e para gr�ficos de torta
require_once ('app.util/graph/jpgraph.php');
require_once ('app.util/graph/jpgraph_pie.php');

// Define um vetor com os dados a serem exibidos
$dados   = array(100, 120, 40, 70);
$rotulos = array('Maria', 'Marcos', 'Mariana', 'Pedro');

// cria o gr�fico
$graph = new PieGraph(400,250);
// habilita sombreamento na imagem
$graph->SetShadow();

// define o t�tulo do gr�fico
$graph->title->Set("Vendas em Mar�o");

// cria uma plotagem do tipo torta
$pieplot = new PiePlot($dados);
$pieplot->SetCenter(0.4);
// define a cor dos valores
$pieplot->value->SetColor("darkred");

// define as legendas
$pieplot->SetLegends($rotulos);

// adiciona a plotagem ao gr�fico
$graph->Add($pieplot);

// exibe o gr�fico no navegador
$graph->Stroke();
?>