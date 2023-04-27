<?php   
include 'app.util/pchart/pData.class.php';
include 'app.util/pchart/pDraw.class.php';
include 'app.util/pchart/pImage.class.php';

// cria o objeto contendo os dados do gráfico
$dados = new pData;
// adiciona duas séries de dados contendo os valores  
$dados->addPoints(array(23, 21, 14, 12, 8,  6),'Chile');
$dados->addPoints(array( 4, 10, 12, 14, 20, 23),'Canadá');

// adiciona os pontos que serão utilizados como rótulos do eixo X
$dados->addPoints(array('Janeiro','Fevereiro','Março','Abril', 'Maio', 'Junho'), 'Meses');

// define a série de rótulos do eixo X
$dados->setAbscissa('Meses');
// define o nome do eixo Y
$dados->setAxisName(0,'Temperatura (C)');

// define a espessura das linhas de cada série
$dados->setSerieWeight('Chile', 1);
$dados->setSerieWeight('Canadá', 1);

// cria um objeto de imagem que irá conter o gráfico
$imagem = new pImage(700, 330, $dados);

// adiciona uma borda ao gráfico
$imagem->drawRectangle(0, 0, 699, 329,array('R'=>0,'G'=>0,'B'=>0));
 
// escreve o título do gráfico
$imagem->setFontProperties(array('FontName'=>'app.util/pchart/fonts/calibri.ttf','FontSize'=>20));
$imagem->drawText(40, 35, 'Média de temperatura');

// altera a fonte e tamanho
$imagem->setFontProperties(array('FontName'=>'app.util/pchart/fonts/verdana.ttf','FontSize'=>10));

// define a área do gráfico
$imagem->setGraphArea(60,40,650,280);

// exibe a escala do gráfico
$scaleSettings = array('XMargin'=>10,'YMargin'=>10,'GridR'=>200,'GridG'=>200,'GridB'=>200,'CycleBackground'=>TRUE);
$imagem->drawScale($scaleSettings);

// exibe a legenda no gráfico
$imagem->drawLegend(60, 310,array('Style'=>LEGEND_NOBORDER,'Mode'=>LEGEND_HORIZONTAL));

// exibe o gráfico de linhas
$imagem->drawLineChart(array('DisplayValues'=>TRUE));

// gera a imagem do gráfico e exibe no navegador
$imagem->autoOutput();
//$imagem->render('/tmp/teste.png');
?>
