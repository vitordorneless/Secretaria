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
}

try
{
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
    
    require('app.util/pdf/fpdf.php'); // inclui a classe FPDF
    $pdf = new FPDF('L', 'pt', 'A4'); // instancia a classe FPDF
    $pdf->AddPage(); // adiciona uma página
    $pdf->SetLineWidth(1); // define a espessura da linha das células
    
    // define cores e fontes para os títulos da tabela
    $pdf->SetFillColor(130,80,70); // cor de fundo
    $pdf->SetTextColor(255); // cor da fonte
    $pdf->SetFont('Arial','B',10); // fonte
    
    // adiciona células com os nomes dos meses
    $pdf->Cell( 140, 20, '', 1, 0, 'C', true);
    foreach ($meses as $mes)
    {
        $pdf->Cell( 80, 20, $nomesmeses[$mes], 1, 0, 'C', true);
    }
    
    // adiciona célula de total
    $pdf->Cell( 80, 20, 'Total', 1, 0, 'C', true);
    $pdf->Ln(); // quebra de linha
    
    $colore = FALSE; // controle de cor do fundo
    
    // percorre a matriz
    foreach ($matriz as $vendedor => $vendas_por_mes)
    {
        // define cores e fontes para os dados da tabela
        $pdf->SetFillColor(200,200,200); // cor de fundo
        $pdf->SetTextColor(0); // cor do texto
        $pdf->SetFont('Arial', '', 10); // fonte
        
        $pdf->Cell( 140, 20, $vendedor, 1, 0, 'L', $colore);
        
        // adiciona os totais por vendedor/mês
        foreach ($meses as $mes)
        {
            $valor = isset($vendas_por_mes[$mes]) ? $vendas_por_mes[$mes] : 0;
            $valor = number_format($valor, 2, ',', '.');
            
            $pdf->Cell( 80, 20, $valor, 1, 0, 'R', $colore);
        }
        
        // adiciona uma célula para o total do vendedor 
        $valor = isset($totais_vendedor[$vendedor]) ? $totais_vendedor[$vendedor] : 0;
        $valor = number_format($valor, 2, ',', '.');
        $pdf->Cell( 80, 20, $valor, 1, 0, 'R', $colore);
        $pdf->Ln();
        
        // inverte variável de controle para cor de fundo
        $colore = !$colore;
    }
    
    // define cores e fontes para a linha de totalização
    $pdf->SetFillColor(117, 117, 117); // cor de fundo
    $pdf->SetTextColor(255); // cor da fonte
    $pdf->SetFont('Arial','B',10); // fonte
    
    // adiciona uma linha para os totais por mes
    $pdf->Cell( 140, 20, '', 1, 0, 'C', true);
    $total_geral = 0; // soma o total geral
    
    // para cada mês, adiciona célula com o total
    foreach ($meses as $mes)
    {
        $valor = isset($totais_mes[$mes]) ? $totais_mes[$mes] : 0;
        $total_geral += $valor; 
        $valor = number_format($valor, 2, ',', '.');
        $pdf->Cell( 80, 20, $valor, 1, 0, 'R', true);
    }
    
    // adiciona uma célula para o total geral 
    $valor = number_format($total_geral, 2, ',', '.');
    $pdf->Cell( 80, 20, $valor, 1, 0, 'R', true);
    
    // salva o PDF em arquivo
    $pdf->Output('app.output/output.pdf', 'F');
    
    // escreve um link para baixar o arquivo na tela
    echo '<center>';
    echo "Arquivo gerado com sucesso<br>";
    echo "<a target=newwindow href='app.output/output.pdf'> Clique aqui para baixar</a>";
    echo '</center>';
} 
catch (Exception $e) 
{ 
    // exibe a mensagem de erro 
    echo $e->getMessage(); 
} 
?>