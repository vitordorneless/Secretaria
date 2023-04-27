<?php
date_default_timezone_set('America/Sao_Paulo');

// inclui a biblioteca base e para gr�ficos de linha
require_once ('app.util/graph/jpgraph.php');
require_once ('app.util/graph/jpgraph_line.php');

// Define um vetor com os dados a serem exibidos
$dados = array(100, 300, 200, 500, 200, 400, 300);

// cria o gr�fico e define a escala
$graph = new Graph(400,250);
$graph->SetScale('textlin');
// habilita sombreamento na imagem
$graph->SetShadow();
// define as margens
$graph->SetMargin(40,20,40,40);

// define o t�tulo do gr�fico e dos eixos
$graph->title->Set('T�tulo do gr�fico');
$graph->xaxis->title->Set('t�tulo do eixo X');
$graph->yaxis->title->Set('t�tulo do eixo Y');

// define a cor de cada eixo
$graph->xaxis->SetColor('#4EBA3F');
$graph->yaxis->SetColor('#4EBA3F');

// Cria uma plotagem linear
$lineplot = new LinePlot($dados);

// define cor e espessura
$lineplot->SetColor( 'maroon' );
$lineplot->SetWeight( 2 ); // em pixels

// define caracter�sticas de marca de valor
$lineplot->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot->mark->SetColor('blue');
$lineplot->mark->SetFillColor('red');
$lineplot->value->Show();

// adiciona a plotagem ao gr�fico
$graph->Add($lineplot);

// exibe o gr�fico no navegador
$graph->Stroke();
?>