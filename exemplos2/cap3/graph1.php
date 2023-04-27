<?php
date_default_timezone_set('America/Sao_Paulo');

// inclui a biblioteca base e para gráficos de linha
require_once ('app.util/graph/jpgraph.php');
require_once ('app.util/graph/jpgraph_line.php');

// Define um vetor com os dados a serem exibidos
$dados = array(100, 300, 200, 500, 200, 400, 300);

// cria o gráfico e define a escala
$graph = new Graph(400,250);
$graph->SetScale('textlin');
// habilita sombreamento na imagem
$graph->SetShadow();
// define as margens
$graph->SetMargin(40,20,40,40);

// define o título do gráfico e dos eixos
$graph->title->Set('Título do gráfico');
$graph->xaxis->title->Set('título do eixo X');
$graph->yaxis->title->Set('título do eixo Y');

// define a cor de cada eixo
$graph->xaxis->SetColor('#4EBA3F');
$graph->yaxis->SetColor('#4EBA3F');

// Cria uma plotagem linear
$lineplot = new LinePlot($dados);

// define cor e espessura
$lineplot->SetColor( 'maroon' );
$lineplot->SetWeight( 2 ); // em pixels

// define características de marca de valor
$lineplot->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot->mark->SetColor('blue');
$lineplot->mark->SetFillColor('red');
$lineplot->value->Show();

// adiciona a plotagem ao gráfico
$graph->Add($lineplot);

// exibe o gráfico no navegador
$graph->Stroke();
?>