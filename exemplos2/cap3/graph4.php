<?php

date_default_timezone_set('America/Sao_Paulo');

// inclui a biblioteca base e para gráficos de barra
require_once ('app.util/graph/jpgraph.php');
require_once ('app.util/graph/jpgraph_bar.php');

// define os vetores com os dados a serem exibidos
$dados1  = array(120,160,200,  0,  0,  0);
$dados2  = array(150,190,190,190,190,200);
$dados3  = array(200,170, 80,140,230,260);
$rotulos = array('jan', 'fev', 'mar', 'abr', 'mai', 'jun');

// cria o gráfico e define a escala
$graph = new Graph(400,250);	
$graph->SetScale("textlin");
// habilita sombreamento na imagem
$graph->SetShadow();
// define as margens
$graph->SetMargin(40,20,40,40);

// define o título do gráfico e dos eixos
$graph->title->Set('Vendas por mes');

// define os rótulos do eixo X
$graph->xaxis->SetTickLabels($rotulos);
// reduz a altura das barras para não irem até o final
$graph->yaxis->scale->SetGrace(40);

// cria três plotagens de barras
$barplot1 = new BarPlot($dados1);
$barplot2 = new BarPlot($dados2);
$barplot3 = new BarPlot($dados3);

// define as cores das barras
$barplot1->SetFillColor("orange");
$barplot2->SetFillColor("brown");
$barplot3->SetFillColor("darkgreen");

$barplot1->SetLegend("Maria");
$barplot2->SetLegend("Marcos");
$barplot3->SetLegend("Pedro");

// habilita sombra nas barras
$barplot1->SetShadow();
$barplot2->SetShadow();
$barplot3->SetShadow();

// cria um grupo para plotagem de barras
$grupobarplot = new GroupBarPlot(array($barplot1, $barplot2, $barplot3));

// define a largura das barras
$grupobarplot->SetWidth(0.6);

// adiciona o grupo para plotagem no gráfico
$graph->Add($grupobarplot);

// exibe o gráfico no navegador
$graph->Stroke();
?>
