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
           "       ' Vendedor ' || vendedor.nome || ' (' || vendedor.id || ')' as vendedor," .
           "       produto.id, produto.descricao, produto.unidade, ".
           "       venda_itens.quantidade, venda_itens.valor" .
           " FROM   venda, venda_itens, pessoa, vendedor, filial, produto" .
           " WHERE  venda.id = venda_itens.id_venda AND" .
           "        venda.id_cliente = pessoa.id AND" .
           "        venda.id_vendedor = vendedor.id AND" .
           "        venda.id_filial = filial.id AND" .
           "        venda_itens.id_produto = produto.id".
           " ORDER BY 1, 2";
    
    $result = $conn->query($sql); // executa a instrução SQL
    
    require('app.util/pdf/fpdf.php'); // inclui a classe FPDF
    $pdf = new FPDF('P', 'pt', 'A4'); // instancia a classe FPDF
    $pdf->AddPage(); // adiciona uma página
    $pdf->SetLineWidth(1); // define a espessura da linha das células
    
    // inicializa variáveis de controle e totalização
    $colore = FALSE;
    $total_quantidade = array(0, 0, 0);
    $total_valor      = array(0, 0, 0);
    $controle_quebra1 = NULL;
    $controle_quebra2 = NULL;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        $imprime_titulos  = FALSE;
        // define cor e fonte para a totalização e quebras
        $pdf->SetTextColor(255);
        $pdf->SetFont('Arial','B',10);
        
        // verifica se a coluna da quebra 2 (vendedor) trocou de valor e não é a primeira linha
        if (isset($controle_quebra2) AND $controle_quebra2 !== $row['vendedor'])
        {
            // altera a cor de fundo
            $pdf->SetFillColor(117,117,117);
            // adiciona célula com rótulo de "total"
            $pdf->Cell( 20, 20, '',                          1, 0, 'L', true);
            $pdf->Cell(340, 20, 'Total '. $controle_quebra2, 1, 0, 'L', true);
            $pdf->Cell( 50, 20, $total_quantidade[2],        1, 0, 'R', true);
            $pdf->Cell( 70, 20, '',                          1, 0, 'R', true);
            $pdf->Cell( 70, 20, $total_valor[2],             1, 0, 'R', true); 
            $pdf->Ln(); // quebra de linha
            
            // reinicializa totais da segunda quebra
            $total_quantidade[2] = 0;
            $total_valor[2]      = 0;
        }
        
        // verifica se a coluna da quebra 1 (filial) trocou de valor e não é a primeira linha
        if (isset($controle_quebra1) AND $controle_quebra1 !== $row['filial'])
        {
            // altera a cor de fundo
            $pdf->SetFillColor(117,117,117);
            // adiciona célula com rótulo de "total"
            $pdf->Cell(360, 20, 'Total '. $controle_quebra1, 1, 0, 'L', true);
            $pdf->Cell( 50, 20, $total_quantidade[1],        1, 0, 'R', true);
            $pdf->Cell( 70, 20, '',                          1, 0, 'R', true);
            $pdf->Cell( 70, 20, $total_valor[1],             1, 0, 'R', true); 
            $pdf->Ln(); // quebra de linha
            
            // reinicializa totais da primeira e segunda quebras
            $total_quantidade[1] = 0;
            $total_quantidade[2] = 0;
            $total_valor[1]      = 0;
            $total_valor[2]      = 0;
        }
        
        // verifica se a coluna da quebra 1 (filial) trocou de valor
        if ($controle_quebra1 !== $row['filial'])
        {
            // adiciona uma linha para exibir a quebra
            $pdf->SetFillColor(100,97,162); // cor de fundo
            $pdf->Cell( 550, 20, $row['filial'], 1, 0, 'L', true);
            $pdf->Ln(); // quebra de linha
            
            // atualiza variável de controle
            $controle_quebra1 = $row['filial'];
            $imprime_titulos  = TRUE;
        }
        
        // verifica se a coluna da quebra 2 (vendedor) trocou de valor
        if ($controle_quebra2 !== $row['vendedor'])
        {
            // adiciona uma linha para exibir a quebra
            $pdf->SetFillColor(100,97,162); // cor de fundo
            $pdf->Cell(  20, 20, '',               1, 0, 'L', true);
            $pdf->Cell( 530, 20, $row['vendedor'], 1, 0, 'L', true);
            $pdf->Ln(); // quebra de linha
            
            // atualiza variável de controle
            $controle_quebra2 = $row['vendedor'];
            $imprime_titulos  = TRUE;
        }
        
        // se alguma quebra trocou de valor, deve imprimir os títulos
        if ($imprime_titulos)
        {
            // adiciona células dos títulos das colunas
            $pdf->SetFillColor(130,80,70); // cor de fundo
            $pdf->Cell( 20, 20, '',              1, 0, 'C', true);
            $pdf->Cell( 20, 20, '',              1, 0, 'C', true);
            $pdf->Cell( 50, 20, 'Código',        1, 0, 'C', true);
            $pdf->Cell(220, 20, 'Descrição',     1, 0, 'C', true);
            $pdf->Cell( 50, 20, 'Unidade',       1, 0, 'C', true);
            $pdf->Cell( 50, 20, 'Quantid.',      1, 0, 'C', true);
            $pdf->Cell( 70, 20, 'Valor unitário',1, 0, 'C', true);
            $pdf->Cell( 70, 20, 'Valor total',   1, 0, 'C', true);
            $pdf->Ln(); // quebra de linha
        }
        
        $pdf->SetFillColor(200,200,200); // cor de fundo
        $pdf->SetTextColor(0); // cor do texto
        $pdf->SetFont('Arial', '', 8); // fonte dos dados
        
        // acumula quantidade vendida para cada quebra
        $total_quantidade[0] += $row['quantidade'];
        $total_quantidade[1] += $row['quantidade'];
        $total_quantidade[2] += $row['quantidade'];
        
        // acumula o valor total do item para cada quebra
        $total_valor[0] += $row['valor'] * $row['quantidade'];
        $total_valor[1] += $row['valor'] * $row['quantidade'];
        $total_valor[2] += $row['valor'] * $row['quantidade'];
        
        $pdf->Cell( 20, 14, '',                 'LR',0,'C',$colore);
        $pdf->Cell( 20, 14, '',                 'LR',0,'C',$colore);
        $pdf->Cell( 50, 14, $row['id'],         'LR',0,'C',$colore);
        $pdf->Cell(220, 14, $row['descricao'],  'LR',0,'L',$colore);
        $pdf->Cell( 50, 14, $row['unidade'],    'LR',0,'C',$colore);
        $pdf->Cell( 50, 14, $row['quantidade'], 'LR',0,'R',$colore);
        $pdf->Cell( 70, 14, $row['valor'],      'LR',0,'R',$colore);
        $pdf->Cell( 70, 14, $row['valor'] * $row['quantidade'],'LR',0,'R',$colore);
        
        $pdf->Ln(); // quebra de linha
        $colore = !$colore; // inverte cor de fundo
    }
    
    // cores e fontes para os totais
    $pdf->SetTextColor(255); // cor do texto
    $pdf->SetFont('Arial','B',10); // fonte
    $pdf->SetFillColor(117,117,117); // cor de fundo
    
    // imprime a totalização da quebra2 (por vendedor)
    $pdf->Cell(  20, 20, '',                          1, 0, 'L', true);
    $pdf->Cell( 340, 20, 'Total '. $controle_quebra2, 1, 0, 'L', true);
    $pdf->Cell( 50, 20, $total_quantidade[2], 1, 0, 'R', true);
    $pdf->Cell( 70, 20, '',                   1, 0, 'R', true);
    $pdf->Cell( 70, 20, $total_valor[2],      1, 0, 'R', true); 
    $pdf->Ln(); // quebra de linha
            
    // imprime a totalização da quebra1 (por filial)
    $pdf->SetFillColor(117,117,117); // cor de fundo
    $pdf->Cell( 360, 20, 'Total '. $controle_quebra1, 1, 0, 'L', true);
    $pdf->Cell( 50, 20, $total_quantidade[1], 1, 0, 'R', true);
    $pdf->Cell( 70, 20, '',                   1, 0, 'R', true);
    $pdf->Cell( 70, 20, $total_valor[1],      1, 0, 'R', true); 
    $pdf->Ln(); // quebra de linha
    
    // imprime o total geral
    $pdf->SetFillColor(117,117,117); // cor de fundo
    $pdf->Cell( 360, 20, 'Total Geral',       1, 0, 'L', true);
    $pdf->Cell( 50, 20, $total_quantidade[0], 1, 0, 'R', true);
    $pdf->Cell( 70, 20, '',                   1, 0, 'R', true);
    $pdf->Cell( 70, 20, $total_valor[0],      1, 0, 'R', true); 
    $pdf->Ln(); // quebra de linha
    
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