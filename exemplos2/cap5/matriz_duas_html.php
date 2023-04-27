<?php 
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
    else if (file_exists("app.widgets/{$classe}.class.php"))
    {
        include_once "app.widgets/{$classe}.class.php";
    }
}

try
{
    // cria um estilo para o cabeçalho
    $estilo_cabecalho = new TStyle('cabecalho');
    $estilo_cabecalho->font_family     = 'arial,verdana,sans-serif';
    $estilo_cabecalho->font_weight     = 'bold';
    $estilo_cabecalho->color           = '#ffffff';
    $estilo_cabecalho->background_color= '#825046';
    $estilo_cabecalho->font_size       = '10pt';
    $estilo_cabecalho->show();
    
    // cria um estilo para o total
    $estilo_cabecalho = new TStyle('total');
    $estilo_cabecalho->font_family     = 'arial,verdana,sans-serif';
    $estilo_cabecalho->font_weight     = 'bold';
    $estilo_cabecalho->color           = '#ffffff';
    $estilo_cabecalho->background_color= '#757575';
    $estilo_cabecalho->font_size       = '10pt';
    $estilo_cabecalho->show();
    
    // cria um estilo para os dados
    $estilo_dados = new TStyle('dados');
    $estilo_dados->font_family     = 'arial,verdana,sans-serif';
    $estilo_dados->color           = '#2D2D2D';
    $estilo_dados->font_size       = '10pt';
    $estilo_dados->show();
    
    $conn = TConnection::open('exemplos'); // abre uma conexão
    
    // define a consulta
    $sql = "SELECT vendedor.nome || ' (' || vendedor.id || ')' as vendedor," .
           "       venda.dt_venda, venda_itens.quantidade, venda_itens.valor" .
           " FROM   venda, venda_itens, vendedor" .
           " WHERE  venda.id = venda_itens.id_venda AND" .
           "        venda.id_vendedor = vendedor.id AND " .
           "        venda.dt_venda >= '2010-01-01' AND " .
           "        venda.dt_venda <= '2010-12-31' ".
           " ORDER BY 1";
    
    $result = $conn->query($sql); // executa a instrução SQL
    
    // inicializa matriz com dados
    $matriz          = array();
    $totais_mes      = array();
    $totais_vendedor = array();
    
    // percorre os resultados
    foreach ($result as $row)
    {
        // obtém os campos da consulta
        $vendedor   = $row['vendedor'];
        $dt_venda   = $row['dt_venda'];
        $mes_venda  = (int) substr($dt_venda, 5,2);
        $quantidade = $row['quantidade'];
        $valor      = $row['valor'];
        
        // inicializa a matriz de dados se necessário
        if (!isset($matriz[$vendedor][$mes_venda]))
        {
            $matriz[$vendedor][$mes_venda] = 0;
        }
        // inicializa a totais por vendedor se necessário
        if (!isset($totais_vendedor[$vendedor]))
        {
            $totais_vendedor[$vendedor] = 0;
        }
        // inicializa a totais por mês se necessário
        if (!isset($totais_mes[$mes_venda]))
        {
            $totais_mes[$mes_venda] = 0;
        }
        
        // totaliza total vendido conforme vendedor e mês
        $matriz[$vendedor][$mes_venda] += ($quantidade * $valor);
        
        // totaliza total vendido conforme vendedor
        $totais_vendedor[$vendedor]    += ($quantidade * $valor);
        
        // totaliza total vendido conforme mês
        $totais_mes[$mes_venda]        += ($quantidade * $valor);
    }
    
    $meses = array_keys($totais_mes); // cria vetor com os meses com venda
    sort($meses); // ordena o vetor
    
    // cria vetor com os nomes dos meses do ano
    $nomesmeses = array();
    $nomesmeses[1] = 'Janeiro';
    $nomesmeses[2] = 'Fevereiro';
    $nomesmeses[3] = 'Março';
    $nomesmeses[4] = 'Abril';
    $nomesmeses[5] = 'Maio';
    $nomesmeses[6] = 'Junho';
    $nomesmeses[7] = 'Julho';
    $nomesmeses[8] = 'Agosto';
    $nomesmeses[9] = 'Setembro';
    $nomesmeses[10] = 'Outubro';
    $nomesmeses[11] = 'Novembro';
    $nomesmeses[12] = 'Dezembro';
    
    // instancia objeto tabela
    $tabela = new TTable;
    $tabela->border= 1;
    $tabela->style = "border-collapse:collapse";
    
    // adiciona uma linha para os títulos 
    $linha = $tabela->addRow(); 
    $linha->class = 'cabecalho';
    
    // adiciona células com os nomes dos meses
    $linha->addCell('');
    foreach ($meses as $mes)
    {
        $cell = $linha->addCell($nomesmeses[$mes]);
        $cell->align = 'center';
    }
    // adiciona célula de total
    $cell = $linha->addCell('Total');
    $cell->align = 'center';
    
    $colore = FALSE; // controle de cor do fundo
    
    // percorre a matriz
    foreach ($matriz as $vendedor => $vendas_por_mes)
    {
        // verifica qual cor irá utilizar para o fundo dos dados
        $bgcolor = $colore ? '#d0d0d0' : '#ffffff';
        
        // adiciona uma linha para os dados
        $linha = $tabela->addRow(); 
        $linha->bgcolor = $bgcolor;
        $linha->class = 'dados';
        
        // adiciona o nome do vendedor
        $cell = $linha->addCell($vendedor);
        $cell->width = '160';
        
        // adiciona os totais por vendedor/mês
        foreach ($meses as $mes)
        {
            $valor = isset($vendas_por_mes[$mes]) ? $vendas_por_mes[$mes] : 0;
            $valor = number_format($valor, 2, ',', '.');
            $cell = $linha->addCell($valor);
            $cell->align = 'right';
            $cell->width = '80';
        }
        
        // adiciona uma célula para o total do vendedor 
        $valor = isset($totais_vendedor[$vendedor]) ? $totais_vendedor[$vendedor] : 0;
        $valor = number_format($valor, 2, ',', '.');
        $cell = $linha->addCell($valor);
        $cell->align = 'right';
        $cell->width = '80';
        
        // inverte variável de controle para cor de fundo
        $colore = !$colore;
    }
    
    // adiciona uma linha para os totais por mes 
    $linha = $tabela->addRow(); 
    $linha->class = 'total';
    
    $linha->addCell('');
    $total_geral = 0; // soma o total geral
    
    // para cada mês, adiciona célula com o total
    foreach ($meses as $mes)
    {
        $valor = isset($totais_mes[$mes]) ? $totais_mes[$mes] : 0;
        $total_geral += $valor; 
        $valor = number_format($valor, 2, ',', '.');
        $cell = $linha->addCell($valor);
        $cell->align = 'right';
        $cell->width = '80';
    }
    
    // adiciona uma célula para o total geral 
    $valor = number_format($total_geral, 2, ',', '.');
    $cell = $linha->addCell($valor);
    $cell->align = 'right';
    $cell->width = '80';
    
    $tabela->show(); // exibe a tabela
} 
catch (Exception $e) 
{ 
    echo $e->getMessage(); // exibe a mensagem de erro 
} 
?>