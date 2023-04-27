<?php
date_default_timezone_set('America/Sao_Paulo');

require_once 'app.util/pchart/pData.class.php'; 
require_once 'app.util/pchart/pDraw.class.php'; 
require_once 'app.util/pchart/pPie.class.php'; 
require_once 'app.util/pchart/pImage.class.php';

require_once 'app.util/graph/jpgraph.php';
require_once 'app.util/graph/jpgraph_line.php';
require_once 'app.util/graph/jpgraph_bar.php';
require_once 'app.util/graph/jpgraph_pie.php';
require_once 'app.util/graph/jpgraph_pie3d.php';

require_once 'app.reports/TChart.class.php';
require_once 'app.reports/TBarChart.class.php';
require_once 'app.reports/TPieChart.class.php';
require_once 'app.reports/TLineChart.class.php';

require_once 'app.reports/TChartDesigner.class.php';
require_once 'app.reports/TJPGraphDesigner.class.php';
require_once 'app.reports/TPChartDesigner.class.php';

$chart = new TPieChart(new TPChartDesigner);
$chart->setTitle('Título do gráfico', NULL, NULL);
$chart->setSize(500, 300);
$chart->setOutputPath('tmp/teste.png');
$chart->addData('maria', 40);
$chart->addData('pedro', 30);
$chart->addData('joao',  30);
$chart->generate();

$chart = new TPieChart(new TJPGraphDesigner);
$chart->setTitle('Título do gráfico', NULL, NULL);
$chart->setSize(500, 300);
$chart->setOutputPath('tmp/teste2.png');
$chart->addData('maria', 40);
$chart->addData('pedro', 30);
$chart->addData('joao',  30);
$chart->generate();

echo "<img src='tmp/teste.png'>";
echo "<img src='tmp/teste2.png'>";
?>