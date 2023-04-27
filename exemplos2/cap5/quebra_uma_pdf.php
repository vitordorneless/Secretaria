<?php 
/**
 * fun��o __autoload() 
 *  Carrega uma classe quando ela � necess�ria, 
 *  ou seja, quando ela � instancia pela primeira vez. 
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
    $conn = TConnection::open('exemplos'); // abre uma conex�o 
    
    // define a consulta
    $sql = "SELECT fabricante.nome || ' (' || fabricante.id || ')' as fabricante, ".
           "       produto.id, produto.descricao, produto.unidade, ".
           "       produto.estoque, produto.preco_custo, produto.preco_venda".
           " FROM produto, fabricante".
           " WHERE produto.id_fabricante=fabricante.id".
           " ORDER BY 1, 3";
    
    $result = $conn->query($sql); // executa a instru��o SQL
    
    require('app.util/pdf/fpdf.php'); // inclui a classe FPDF
    $pdf = new FPDF('P', 'pt', 'A4'); // instancia a classe FPDF
    $pdf->AddPage(); // adiciona uma p�gina
    $pdf->SetLineWidth(1); // define a espessura da linha das c�lulas
    
    // inicializa vari�veis de controle e totaliza��o
    $colore = FALSE;
    $total_custo = 0;
    $total_venda = 0;
    $total_estoq = 0;
    $total_custo_quebra = 0;
    $total_venda_quebra = 0;
    $total_estoq_quebra = 0;
    $controle_quebra = NULL;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        // verifica se � a primeira linha ou a coluna de quebra trocou de valor
        if (!isset($controle_quebra) OR $controle_quebra !== $row['fabricante'])
        {
            // define cor e fonte para a totaliza��o e quebras
            $pdf->SetTextColor(255);
            $pdf->SetFont('Arial','B',10);
            
            // se a vari�vel de controle possui valor, deve totalizar
            if (isset($controle_quebra))
            {
                // altera a cor de fundo
                $pdf->SetFillColor(117,117,117);
                // adiciona c�lula com r�tulo de "total"
                $pdf->Cell( 340, 20, 'Total '. $controle_quebra, 1, 0, 'C', true);
                
                // adiciona c�lulas com totais
                $custo_exibir = number_format($total_custo_quebra, 2, ',', '.');
                $venda_exibir = number_format($total_venda_quebra, 2, ',', '.');
                
                $pdf->Cell( 50, 20, $total_estoq_quebra, 1, 0, 'R', true);
                $pdf->Cell( 70, 20, $custo_exibir,       1, 0, 'R', true);
                $pdf->Cell( 70, 20, $venda_exibir,       1, 0, 'R', true); 
                $pdf->Ln(); // quebra de linha
                
                // reinicializa vari�veis totalizadoras por quebra
                $total_custo_quebra = 0;
                $total_venda_quebra = 0;
                $total_estoq_quebra = 0;
            }
            
            // adiciona uma linha para exibir a quebra
            $pdf->SetFillColor(100,97,162); // cor de fundo
            $pdf->Cell( 530, 20, $row['fabricante'], 1, 0, 'L', true);
            $pdf->Ln(); // quebra de linha
            
            // adiciona c�lulas dos t�tulos das colunas
            $pdf->SetFillColor(130,80,70); // cor de fundo
            $pdf->Cell( 30, 20, '',          1, 0, 'C', true);
            $pdf->Cell( 40, 20, 'C�digo',    1, 0, 'C', true);
            $pdf->Cell(220, 20, 'Descri��o', 1, 0, 'C', true);
            $pdf->Cell( 50, 20, 'Unidade',   1, 0, 'C', true);
            $pdf->Cell( 50, 20, 'Estoque',   1, 0, 'C', true);
            $pdf->Cell( 70, 20, '$ Custo',   1, 0, 'C', true);
            $pdf->Cell( 70, 20, '$ Venda',   1, 0, 'C', true);
            $pdf->Ln(); // quebra de linha
    
            // atualiza vari�vel de controle
            $controle_quebra = $row['fabricante'];
        }
        
        // acumula pre�o de custo, de venda e estoque (geral)
        $total_custo += $row['estoque'] * $row['preco_custo'];
        $total_venda += $row['estoque'] * $row['preco_venda'];
        $total_estoq += $row['estoque'];
        
        // acumula pre�o de custo, de venda e estoque (quebra)
        $total_custo_quebra += $row['estoque'] * $row['preco_custo'];
        $total_venda_quebra += $row['estoque'] * $row['preco_venda'];
        $total_estoq_quebra += $row['estoque'];
        
        // define cor de fundo, do texto e fonte dos dados
        $pdf->SetFillColor(200,200,200);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', '', 8);
        
        // formata numericamente os pre�os
        $row['preco_custo'] = number_format($row['preco_custo'], 2, ',', '.');
        $row['preco_venda'] = number_format($row['preco_venda'], 2, ',', '.');
        
        $pdf->Cell( 30, 14, '',                 'LR',0,'C',$colore);
        $pdf->Cell( 40, 14, $row['id'],         'LR',0,'C',$colore);
        $pdf->Cell(220, 14, $row['descricao'],  'LR',0,'L',$colore);
        $pdf->Cell( 50, 14, $row['unidade'],    'LR',0,'C',$colore);
        $pdf->Cell( 50, 14, $row['estoque'],    'LR',0,'R',$colore);
        $pdf->Cell( 70, 14, $row['preco_custo'],'LR',0,'R',$colore);
        $pdf->Cell( 70, 14, $row['preco_venda'],'LR',0,'R',$colore);
        
        $pdf->Ln(); // quebra de linha
        $colore = !$colore; // inverte cor de fundo
    }
    
    $pdf->SetTextColor(255); // define cor de preenchimento
    $pdf->SetFont('Arial','B',10); // define a fonte
    
    // adiciona uma linha para o total da �ltima quebra
    $pdf->SetFillColor(117,117,117);
    // adiciona c�lula com r�tulo de "total"
    $pdf->Cell( 340, 20, 'Total '. $controle_quebra, 1, 0, 'C', true);
    
    // adiciona c�lulas com totais
    $custo_exibir = number_format($total_custo_quebra, 2, ',', '.');
    $venda_exibir = number_format($total_venda_quebra, 2, ',', '.');
    $pdf->Cell( 50, 20, $total_estoq_quebra, 1, 0, 'R', true);
    $pdf->Cell( 70, 20, $custo_exibir, 1, 0, 'R', true);
    $pdf->Cell( 70, 20, $venda_exibir, 1, 0, 'R', true); 
    $pdf->Ln(); // quebra de linha
    
    // exibe o total geral
    $pdf->Cell(340, 20, 'Total Geral',       1, 0, 'L', true);
    $pdf->Cell( 50, 20, $total_estoq, 1, 0, 'R', true);
    $pdf->Cell( 70, 20, number_format($total_custo, 2, ',', '.'),  1, 0, 'R', true);
    $pdf->Cell( 70, 20, number_format($total_venda, 2, ',', '.'),  1, 0, 'R', true);
    
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
    echo $e->getMessage(); // exibe a mensagem de erro  
} 
?>