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
    
    // cria um estilo para a quebra
    $estilo_quebra = new TStyle('quebra'); 
    $estilo_quebra->font_family     = 'arial,verdana,sans-serif'; 
    $estilo_quebra->font_weight     = 'bold';
    $estilo_quebra->color           = '#ffffff';
    $estilo_quebra->background_color= '#6461A2'; 
    $estilo_quebra->font_size       = '12pt'; 
    $estilo_quebra->show();
    
    // cria um estilo para os dados
    $estilo_dados = new TStyle('dados');
    $estilo_dados->font_family     = 'arial,verdana,sans-serif';
    $estilo_dados->color           = '#2D2D2D';
    $estilo_dados->font_size       = '10pt';
    $estilo_dados->show();
    
    $conn = TConnection::open('exemplos'); // abre uma conexão
    
    // define a consulta
    $sql = "SELECT filial.nome || ' (' || filial.id || ')' as filial," .
           "       vendedor.nome || ' (' || vendedor.id || ')' as vendedor," .
           "       pessoa.sexo, venda.dt_venda, venda_itens.quantidade, venda_itens.valor" .
           " FROM   venda, venda_itens, pessoa, vendedor, filial" .
           " WHERE  venda.id = venda_itens.id_venda AND" .
           "        venda.id_cliente = pessoa.id AND" .
           "        venda.id_vendedor = vendedor.id AND" .
           "        venda.id_filial = filial.id AND" .
           "        venda.dt_venda >= '2010-10-01' AND " .
           "        venda.dt_venda <= '2010-12-31' ".
           " ORDER BY 1, 2";
    
    $result = $conn->query($sql); // executa a instrução SQL
    
    // inicializa matriz com dados e totais
    $matriz          = array();
    $totais_mes      = array();
    $totais_vendedor = array();
    
    // inicializa vetores de sexos e meses
    $sexos = array();
    $meses = array();
    
    // percorre os resultados
    foreach ($result as $row)
    {
        // obtém os campos da consulta
        $filial     = $row['filial'];
        $vendedor   = $row['vendedor'];
        $sexo       = $row['sexo'];
        $dt_venda   = $row['dt_venda'];
        $mes_venda  = (int) substr($dt_venda, 5,2);
        $quantidade = $row['quantidade'];
        $valor      = $row['valor'];
        
        // inicializa a matriz de dados se necessário
        if (!isset($matriz[$filial][$vendedor][$mes_venda][$sexo]))
        {
            $matriz[$filial][$vendedor][$mes_venda][$sexo] = 0;
        }
        // inicializa a totais por vendedor se necessário
        if (!isset($totais_vendedor[$filial][$vendedor]))
        {
            $totais_vendedor[$filial][$vendedor] = 0;
        }
        // inicializa a totais por mês se necessário
        if (!isset($totais_mes[$mes_venda][$sexo]))
        {
            $totais_mes[$mes_venda][$sexo] = 0;
        }
        
        // totaliza total vendido conforme vendedor e mês
        $matriz[$filial][$vendedor][$mes_venda][$sexo] += ($quantidade * $valor);
        
        // totaliza total vendido conforme vendedor
        $totais_vendedor[$filial][$vendedor]    += ($quantidade * $valor);
        
        // totaliza total vendido conforme mês
        $totais_mes[$mes_venda][$sexo]    += ($quantidade * $valor);
        
        // descobre os sexos e meses
        $sexos[] = $sexo;
        $meses[] = $mes_venda;
    }
    
    // unifica vetores
    $sexos = array_unique($sexos);
    $meses = array_unique($meses);
    // ordena os vetores
    sort($sexos);
    sort($meses);
    
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
    
    // adiciona linhas para os títulos 
    $linha1 = $tabela->addRow();
    $linha2 = $tabela->addRow(); 
    $linha1->class = 'cabecalho';
    $linha2->class = 'cabecalho';
    
    // adiciona células com os nomes dos meses
    $linha1->addCell('');
    $linha2->addCell('');
    foreach ($meses as $mes)
    {
        $cell = $linha1->addCell($nomesmeses[$mes]);
        $cell->align = 'center';
        $cell->colspan = 2;
        
        // adiciona células com os nomes dos sexos
        foreach ($sexos as $sexo)
        {
            $cell = $linha2->addCell($sexo);
            $cell->align = 'center';
        }
    }
    
    // adiciona célula de total
    $cell = $linha1->addCell('Total');
    $cell->align = 'center';
    $linha2->addCell('');
    
    $colore = FALSE; // controle de cor do fundo
    
    // percorre a matriz
    foreach ($matriz as $filial => $vendas_por_vendedor)
    {
        // adiciona uma linha para a filial
        $linha = $tabela->addRow(); 
        $linha->class = 'quebra';
        $cell = $linha->addCell($filial);
        $cell->colspan = (count($meses) * count($sexos)) +2;
        
        foreach ($vendas_por_vendedor as $vendedor => $vendas_por_mes)
        {
            // verifica qual cor irá utilizar para o fundo dos dados
            $bgcolor = $colore ? '#d0d0d0' : '#ffffff';
            
            // adiciona uma linha para o vendedor
            $linha = $tabela->addRow(); 
            $linha->bgcolor = $bgcolor;
            $linha->class = 'dados';
            
            $cell = $linha->addCell($vendedor);
            $cell->width='160';
            
            // percorre todos os meses com vendas
            foreach ($meses as $mes)
            {
                // percorre todos os sexos
                foreach ($sexos as $sexo)
                {
                    // var_dump($vendas_por_sexo);
                    $valor = isset($vendas_por_mes[$mes][$sexo]) ? $vendas_por_mes[$mes][$sexo] : 0;
                    $valor = number_format($valor, 2, ',', '.');
                    $cell = $linha->addCell($valor);
                    $cell->align = 'right';
                    $cell->width = '80';
                }
            }
            
            // adiciona uma célula para o total do vendedor 
            $valor = isset($totais_vendedor[$filial][$vendedor]) ? $totais_vendedor[$filial][$vendedor] : 0;
            $valor = number_format($valor, 2, ',', '.');
            $cell = $linha->addCell($valor);
            $cell->align = 'right';
            $cell->width = '80';
            
            $colore = !$colore;
        }
    }
    
    // adiciona uma linha para os totais por mes 
    $linha = $tabela->addRow(); 
    $linha->class = 'total';
    
    $linha->addCell('');
    $total_geral = 0; // soma o total geral
    
    // percorre todos os meses com vendas
    foreach ($meses as $mes)
    {
        // percorre todos os sexos
        foreach ($sexos as $sexo)
        {
            $valor = isset($totais_mes[$mes][$sexo]) ? $totais_mes[$mes][$sexo] : 0;
            $total_geral += $valor;
            $valor = number_format($valor, 2, ',', '.');
            $cell = $linha->addCell($valor);
            $cell->align = 'right';
            $cell->width = '80';
        }
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