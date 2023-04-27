<?php   
include 'app.util/pchart/pData.class.php';
include 'app.util/pchart/pDraw.class.php';
include 'app.util/pchart/pImage.class.php';

// cria o objeto contendo os dados do gráfico
$dados = new pData;
// adiciona duas séries de dados contendo os valores  
$dados->addPoints(array(93, 80,   82, 160, 140, 170), 'Maria');
$dados->addPoints(array(84, 100, 140, 80,   52, 73),  'Joana');

// adiciona os pontos que serão utilizados como rótulos do eixo X
$dados->addPoints(array('Janeiro','Fevereiro','Março','Abril', 'Maio', 'Junho'), 'Meses');

// define a série de rótulos do eixo X
$dados->setAbscissa('Meses');
// define o nome do eixo Y 
$dados->setAxisName(0, 'Pontos');

// cria um objeto de imagem que irá conter o gráfico
$imagem = new pImage(700, 330, $dados);

// desliga a suavização de imagem
$imagem->Antialias = FALSE;

// adiciona uma borda ao gráfico
$imagem->drawRectangle(0,0,699,329,array('R'=>0,'G'=>0,'B'=>0));

// escreve o título do gráfico
$imagem->setFontProperties(array('FontName'=>'app.util/pchart/fonts/calibri.ttf','FontSize'=>20));
$imagem->drawText(40, 30, 'Pontuação');

// altera a fonte e tamanho para os dados no gráfico
$imagem->setFontProperties(array('FontName'=>'app.util/pchart/fonts/verdana.ttf','FontSize'=>10));

// define a área do gráfico
$imagem->setGraphArea(60,40,650,280);

// exibe a escala do gráfico
$scaleSettings = array('GridR'=>200,'GridG'=>200,'GridB'=>200,'CycleBackground'=>TRUE);
$imagem->drawScale($scaleSettings);

// exibe a legenda no gráfico
$imagem->drawLegend(60,310,array('Style'=>LEGEND_NOBORDER, 'Mode'=>LEGEND_HORIZONTAL));

/* Turn on shadow computing */ 
$imagem->setShadow(TRUE,array('X'=>1,'Y'=>1,'R'=>0,'G'=>0,'B'=>0,'Alpha'=>10));

// exibe o gráfico de barras
$imagem->drawBarChart(array('DisplayValues' => TRUE, // exibe valores
                            'DisplayPos'    => LABEL_POS_INSIDE, // valores dentro das barras
                            'Surrounding'   => 200));

// gera a imagem do gráfico e exibe no navegador
$imagem->autoOutput();
//$imagem->render('/tmp/teste.png');
?>
