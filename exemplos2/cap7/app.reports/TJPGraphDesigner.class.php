<?php
/**
 * Classe que implementa o desenho de gráficos para a biblioteca JPGraph
 */
final class TJPGraphDesigner extends TChartDesigner
{
    private $colors;
    
    /**
     * Método construtor
     */
    public function __construct()
    {
        $this->colors = array('#D0F442', '#F47842', '#F4EA42', '#42ABF4', '#C442F4',
                              '#F44289', '#70F442', '#F4C442', '#52DAFF', '#F29E64');
    }
    
    /**
     * Desenha um gráfico de linhas
     * @param $title título do graico
     * @param $data matriz contendo as séries de dados
     * @param $xlabels vetor contendo os rótulos do eixo X
     * @param $ylabel  rótulo do eixo Y
     * @param $width largura do gráfico
     * @param $height altura do gráfico
     * @param $outputPath caminho de saída do gráfico
     */
    public function drawLineChart($title, $data, $xlabels, $ylabel, $width, $height, $outputPath)
    {
        // cria o gráfico e define a escala
        $graph = new Graph($width, $height);
        $graph->SetScale("textlin");
        // habilita sombreamento na imagem
        $graph->SetShadow();
        // define as margens
        $graph->SetMargin(50,20,40,40);
        
        // define o título do gráfico e dos eixos
        $graph->title->Set($title);
        $graph->yaxis->title->Set($ylabel);
        $graph->yaxis->SetTitleMargin(35);
        
        // define os rótulos do eixo X
        $graph->xaxis->SetTickLabels($xlabels);
        
        if ($data)
        {
            $i = 0;
            foreach ($data as $legend => $points)
            {
                // cria uma plotagem lineares
                $lineplot=new LinePlot($points);
                
                // adiciona as plotagens ao gráfico
                $graph->Add($lineplot);
                
                // define a cor das linhas
                $lineplot->SetColor($this->colors[$i]);
                
                // define a espessura das linhas
                $lineplot->SetWeight(2);
                
                // define o nome das linhas na legenda
                $lineplot->SetLegend($legend);
                
                // define características de marca de valor
                $lineplot->mark->SetType(MARK_FILLEDCIRCLE);
                $lineplot->mark->SetColor('black');
                $lineplot->mark->SetFillColor('white');
                $lineplot->value->Show();
                
                $i ++;
            }
        }
        // exibe o gráfico no navegador
        $graph->Stroke($outputPath);
    }
    
    /**
     * Desenha um gráfico de barras
     * @param $title título do graico
     * @param $data matriz contendo as séries de dados
     * @param $xlabels vetor contendo os rótulos do eixo X
     * @param $ylabel  rótulo do eixo Y
     * @param $width largura do gráfico
     * @param $height altura do gráfico
     * @param $outputPath caminho de saída do gráfico
     */
    public function drawBarChart($title,  $data, $xlabels, $ylabel, $width, $height, $outputPath)
    {
        // cria o gráfico e define a escala
        $graph = new Graph($width, $height);	
        $graph->SetScale("textlin");
        // habilita sombreamento na imagem
        $graph->SetShadow();
        // define as margens
        $graph->SetMargin(40,20,40,40);
        
        // define o título do gráfico e dos eixos
        $graph->title->Set($title);
        $graph->yaxis->title->Set($ylabel);
        // define os rótulos do eixo X
        $graph->xaxis->SetTickLabels($xlabels);
        // reduz a altura das barras para não irem até o final
        $graph->yaxis->scale->SetGrace(40);
        
        if ($data)
        {
            $barplots = array();
            $i = 0;
            foreach ($data as $legend => $points)
            {
                // cria a plotagem de barras
                $barplot = new BarPlot($points);
                
                // define as cores das barras
                $barplot->SetFillColor($this->colors[$i]);
                
                $barplot->SetLegend($legend);
                
                $barplot->value->Show();
                // $barplot->value->SetFormat(" R$ %2.1f");
                // $barplot->value->SetColor($this->colors[$i]);
                
                // habilita sombra nas barras
                $barplot->SetShadow('#777777');
                
                // adiciona a plotagem em um vetor
                $barplots[] = $barplot;
                $i ++;
            }
        }
        
        // cria um grupo para plotagem de barras
        $grupobarplot = new GroupBarPlot($barplots);
        
        // define a largura das barras
        $grupobarplot->SetWidth(0.6);
        
        // adiciona o grupo para plotagem no gráfico
        $graph->Add($grupobarplot);
        
        // exibe o gráfico no navegador
        $graph->Stroke($outputPath);
    }
    
    /**
     * Desenha um gráfico de torta
     * @param $title título do graico
     * @param $data vetor contendo os dados do gráfico
     * @param $width largura do gráfico
     * @param $height altura do gráfico
     * @param $outputPath caminho de saída do gráfico
     */
    public function drawPieChart($title, $data, $width, $height, $outputPath)
    {
        // cria o gráfico
        $graph = new PieGraph($width, $height);
        // habilita sombreamento na imagem
        $graph->SetShadow();
        
        // define o título do gráfico
        $graph->title->Set($title);
        $graph->title->SetFont(FF_FONT1,FS_BOLD);
        
        // cria uma plotagem do tipo torta 3D
        $pieplot = new PiePlot3D(array_values($data));
        // indica uma fatia para estar em destaque
        //$pieplot->ExplodeSlice(1);
        // posiciona o centro do gráfico
        $pieplot->SetCenter(0.45);
        
        // define as legendas
        $pieplot->SetLegends(array_keys($data));
        
        // adiciona a plotagem ao gráfico
        $graph->Add($pieplot);
        
        // exibe o gráfico no navegador
        $graph->Stroke($outputPath);
    }
}
?>