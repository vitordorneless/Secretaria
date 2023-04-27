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
    
    // executa a instrução SQL
    $result = $conn->query($sql);
    
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
    
    require('app.util/pdf/fpdf.php'); // inclui a classe FPDF
    $pdf = new FPDF('L', 'pt', 'A4'); // instancia a classe FPDF
    $pdf->AddPage(); // adiciona uma página
    $pdf->SetLineWidth(1); // define a espessura da linha das células
    
    // define cores e fontes para os títulos da tabela
    $pdf->SetFillColor(130,80,70); // cor de fundo
    $pdf->SetTextColor(255); // cor da fonte
    $pdf->SetFont('Arial','B',10); // fonte
    
    // adiciona células com os nomes dos meses
    $pdf->Cell( 160, 20, '', 1, 0, 'C', true);
    foreach ($meses as $mes)
    {
        $pdf->Cell( 120, 20, $nomesmeses[$mes], 1, 0, 'C', true);
    }
    $pdf->Cell( 80, 20, 'Total', 1, 0, 'C', true);
    $pdf->Ln();
    
    // adiciona células com os nomes dos sexos
    $pdf->Cell( 160, 20, '', 1, 0, 'C', true);
    foreach ($meses as $mes)
    {
        foreach ($sexos as $sexo)
        {
            $pdf->Cell( 60, 20, $sexo, 1, 0, 'C', true);
        }
    }
    $pdf->Cell( 80, 20, '', 1, 0, 'C', true);
    $pdf->Ln();
    
    $colore = FALSE; // controle de cor do fundo
    
    // percorre a matriz
    foreach ($matriz as $filial => $vendas_por_vendedor)
    {
        // adiciona uma linha para a filial
        $pdf->SetFillColor(100,97,162); // cor de fundo
        $pdf->SetTextColor(255);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell( 160 + (count($meses) * count($sexos) * 60) + 80, 20, $filial, 1, 0, 'L', 1);
        $pdf->Ln();
        
        foreach ($vendas_por_vendedor as $vendedor => $vendas_por_mes)
        {
            // define cores e fontes para os dados da tabela
            $pdf->SetFillColor(200,200,200); // cor de fundo
            $pdf->SetTextColor(0); // cor do texto
            $pdf->SetFont('Arial', '', 10); // fonte

            $pdf->Cell( 160, 20, $vendedor, 1, 0, 'L', $colore);
            
            // percorre todos os meses com vendas
            foreach ($meses as $mes)
            {
                // percorre todos os sexos
                foreach ($sexos as $sexo)
                {
                    $valor = isset($vendas_por_mes[$mes][$sexo]) ? $vendas_por_mes[$mes][$sexo] : 0;
                    $valor = number_format($valor, 2, ',', '.');
                    $pdf->Cell( 60, 20, $valor, 1, 0, 'R', $colore);
                }
            }
            
            // adiciona uma célula para o total do vendedor 
            $valor = isset($totais_vendedor[$filial][$vendedor]) ? $totais_vendedor[$filial][$vendedor] : 0;
            $valor = number_format($valor, 2, ',', '.');
            $pdf->Cell( 80, 20, $valor, 1, 0, 'R', $colore);
            
            $colore = !$colore;
            $pdf->Ln();
        }
    }
    
    // define cores e fontes para a linha de totalização
    $pdf->SetFillColor(117, 117, 117); // cor de fundo
    $pdf->SetTextColor(255); // cor da fonte
    $pdf->SetFont('Arial','B',10); // fonte
    
    $total_geral = 0; // soma o total geral
    
    $pdf->Cell( 160, 20, '', 1, 0, 'C', true);
    // percorre todos os meses com vendas
    foreach ($meses as $mes)
    {
        // percorre todos os sexos
        foreach ($sexos as $sexo)
        {
            $valor = isset($totais_mes[$mes][$sexo]) ? $totais_mes[$mes][$sexo] : 0;
            $total_geral += $valor;
            $valor = number_format($valor, 2, ',', '.');
            $pdf->Cell( 60, 20, $valor, 1, 0, 'R', true);
        }
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