<?php   
include 'app.util/pchart/pData.class.php';
include 'app.util/pchart/pDraw.class.php';
include 'app.util/pchart/pImage.class.php';
include 'app.util/pchart/pPie.class.php';

// cria o objeto contendo os dados do gráfico
$dados = new pData;

// adiciona o vetor contendo os dados do graico
$dados->addPoints(array(10, 20, 30, 40, 50));

// define a legenda do gráfico
$dados->addPoints(array('Maria','Pedro','Paulo','Mariana','Joana'), 'legenda');
$dados->setAbscissa('legenda');

// cria um objeto de imagem que irá conter o gráfico
$imagem = new pImage(700, 400, $dados);

// adiciona uma borda ao gráfico
$imagem->drawRectangle(0, 0, 699, 399, array('R'=>0,'G'=>0,'B'=>0));

// escreve o título do gráfico
$imagem->setFontProperties(array('FontName'=>'app.util/pchart/fonts/calibri.ttf','FontSize'=>20));
$imagem->drawText(15, 35, 'Participação');

// altera a fonte, tamanho e cor
$imagem->setFontProperties(array('FontName'=>'app.util/pchart/fonts/calibri.ttf','FontSize'=>14));

// cria um objeto para conter o gráfico de pizza
$grafico = new pPie($imagem, $dados);

// aciona o método que desenha o gráfico de pizza
$grafico->draw3DPie(350, 200, array('WriteValues'=>TRUE, // escreve valores
                                    'DrawLabels'=>TRUE,  // escreve labels
                                    'Radius' => 200, // radio
                                    'ValueR'=>0, 'ValueG'=>0, 'ValueB'=>0 // cor do texto
                                    ));

// exibe a legenda no gráfico
$grafico->drawPieLegend(15, 60, array('Alpha'=>20));

// gera a imagem do gráfico e exibe no navegador
$imagem->autoOutput();
?>
