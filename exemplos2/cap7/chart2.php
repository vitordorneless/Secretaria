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

$data['maria'] = array( 1, 2,  3, 4,  5, 6, 7);
$data['pedro'] = array(12, 3, 12, 4, 12, 4, 2);
$data['joao']  = array( 9, 8,  7, 6,  5, 4, 3);

$chart = new TLineChart(new TPChartDesigner);
$chart->setTitle('Título do gráfico', NULL, NULL);
$chart->setSize(500, 300);
$chart->setXLabels(array('a', 'b', 'c', 'd', 'e', 'f', 'g'));
$chart->setYLabel('label do eixo Y');
$chart->setOutputPath('tmp/teste.png');
$chart->addData('maria', $data['maria']);
$chart->addData('pedro', $data['pedro']);
$chart->addData('joao',  $data['joao']);
$chart->generate();

$chart = new TLineChart(new TJPGraphDesigner);
$chart->setTitle('Título do gráfico', NULL, NULL);
$chart->setSize(500, 300);
$chart->setXLabels(array('a', 'b', 'c', 'd', 'e', 'f', 'g'));
$chart->setYLabel('label do eixo Y');
$chart->setOutputPath('tmp/teste2.png');
$chart->addData('maria', $data['maria']);
$chart->addData('pedro', $data['pedro']);
$chart->addData('joao',  $data['joao']);
$chart->generate();

echo "<img src='tmp/teste.png'>";
echo "<img src='tmp/teste2.png'>";
?>