<?php
date_default_timezone_set('America/Sao_Paulo');

/**
 * função __autoload() 
 *  Carrega uma classe quando ela é necessária, 
 *  ou seja, quando ela é instancia pela primeira vez. 
 */ 
function __autoload($classe) 
{ 
    if (file_exists("app.ado/{$classe}.class.php")) 
    { 
        include_once "app.ado/{$classe}.class.php";
    }
} 

try
{
    $ano = 2010; // define o ano-base da consulta
    $conn = TConnection::open('exemplos'); // abre uma conexão
    
    // define a consulta
    $sql = "SELECT  filial.nome as filial,".
           "        strftime('%m', venda.dt_venda) as mes,".
           "        sum(venda_itens.quantidade * venda_itens.valor) as valor".
           " FROM   venda, venda_itens, filial".
           " WHERE  strftime('%Y', dt_venda) = '$ano' AND".
           "        strftime('%m', dt_venda) > 6 AND".
           "        venda.id = venda_itens.id_venda AND".
           "        venda.id_filial = filial.id".
           " GROUP BY 1,2".
           " ORDER BY 1,2";
    
    $result = $conn->query($sql); // executa a instrução SQL
    $data = array(); // inicializa vetor de dados
    
    foreach ($result as $row)
    {
        // lê as variáveis da consulta
        $filial = $row['filial'];
        $mes    = (int) $row['mes'];
        $valor  = $row['valor'];
        
        // cria um vetor com os dados
        $data[$filial][$mes] = $valor;
    }
    
    // inclui a biblioteca base e para gráficos de barra
    require_once ('app.util/graph/jpgraph.php');
    require_once ('app.util/graph/jpgraph_bar.php');
    
    // define o vetor de cores e rótulos
    $color  = array('orange', 'blue', 'red', 'green', 'olive', 'maroon');
    $rotulos= array('jul', 'ago', 'set', 'out', 'nov', 'dez');
    
    // cria o gráfico e define a escala
    $graph = new Graph(600,400);
    $graph->SetScale("textlin");
    $graph->SetShadow(); // habilita sombreamento na imagem
    $graph->SetMargin(70,20,40,40); // define as margens
    
    // define o título do gráfico e dos eixos
    $graph->title->Set("Vendas segundo semestre {$ano}");
    $graph->xaxis->title->Set('mes');
    $graph->yaxis->title->Set('vendas (R$)');
    $graph->yaxis->SetTitleMargin(55);
    
    // define os rótulos do eixo X
    $graph->xaxis->SetTickLabels($rotulos);
    // reduz a altura das barras para não irem até o final
    $graph->yaxis->scale->SetGrace(40);
    
    // vetor que irá armazenar objetos BarPlot
    $barplots = array();
    
    $i = 0;
    // percorre os dados por filial
    foreach ($data as $filial => $dados_por_mes)
    {
        // inicializa vetor de dados a serem plotados
        $plotdata = array();
        
        // iteração para uniformizar o vetor de dados
        for ($n=7; $n<=12; $n++)
        {
            $plotdata[] = isset($dados_por_mes[$n]) ? $dados_por_mes[$n] : 0;
        }
        
        // cria três plotagens de barras
        $barplot = new BarPlot($plotdata);
        $barplot->SetFillColor($color[$i]); // define as cores das barras
        $barplot->value->Show(); // habilita a exibição do valor
        $barplot->SetLegend($filial); // define o nome das barras na legenda
        $barplot->SetShadow(); // habilita sombra nas barras
        
        $barplots[] = $barplot; // agrega a BarPlot no grupo
        $i ++;
    }
    
    // cria um grupo para plotagem de barras
    $grupobarplot = new GroupBarPlot($barplots);
    $grupobarplot->SetWidth(0.7); // define a largura das barras
    
    $graph->Add($grupobarplot); // adiciona o grupo para plotagem no gráfico
    $graph->Stroke(); // exibe o gráfico no navegador
} 
catch (Exception $e) 
{ 
    echo $e->getMessage(); // exibe a mensagem de erro 
} 
?>