<?php
date_default_timezone_set('America/Sao_Paulo');

// inclui a biblioteca base e para gráficos de linha
require_once ('app.util/graph/jpgraph.php');
require_once ('app.util/graph/jpgraph_line.php');

// define os vetores com os dados a serem exibidos
$dados1 = array(120,341,259,285,378,190,401,380,248,340);
$dados2 = array(354,200,265,120,191,391,198,225,293,251);
$rotulos= array('jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out');

// cria o gráfico e define a escala
$graph = new Graph(400,250);	
$graph->SetScale("textlin");
// habilita sombreamento na imagem
$graph->SetShadow();
// define as margens
$graph->SetMargin(50,20,40,40);

// define o título do gráfico e dos eixos
$graph->title->Set('Gastos por mes');
$graph->xaxis->title->Set('mes');
$graph->yaxis->title->Set('gastos (R$)');
$graph->yaxis->SetTitleMargin(35);

// define os rótulos do eixo X
$graph->xaxis->SetTickLabels($rotulos);

// cria duas plotagens lineares
$lineplot1=new LinePlot($dados1);
$lineplot2=new LinePlot($dados2);

// adiciona as plotagens ao gráfico
$graph->Add($lineplot1);
$graph->Add($lineplot2);

// define a cor das linhas
$lineplot1->SetColor("blue");
$lineplot2->SetColor("orange");

// define a espessura das linhas
$lineplot1->SetWeight(2);
$lineplot2->SetWeight(2);

// define o nome das linhas na legenda
$lineplot1->SetLegend("Marcos");
$lineplot2->SetLegend("Pedro");

// exibe o gráfico no navegador
$graph->Stroke();
?>