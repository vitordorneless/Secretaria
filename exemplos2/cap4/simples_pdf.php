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
    $conn = TConnection::open('exemplos'); // abre uma conex�o com a base de dados 
    
    // define a consulta
    $sql = 'SELECT id, descricao, unidade, estoque, preco_custo, preco_venda'.
           ' FROM produto'.
           ' ORDER BY descricao'; 
    
    // executa a instru��o SQL 
    $result = $conn->query($sql);
    
    require('app.util/pdf/fpdf.php'); // inclui a classe FPDF
    
    
    $pdf = new FPDF('P', 'pt', 'A4'); // instancia a classe FPDF
    $pdf->AddPage(); // adiciona uma p�gina
    
    // define a fonte
    $pdf->SetFont('Arial','B',10);
    
    // define cor de preenchimento,
    // cor de texto e espessura da linha
    $pdf->SetFillColor(130,80,70);
    $pdf->SetTextColor(255);
    $pdf->SetLineWidth(1);
    
    // adiciona c�lulas
    $pdf->Cell( 40, 20, 'C�digo',    1, 0, 'C', true);
    $pdf->Cell(220, 20, 'Descri��o', 1, 0, 'C', true);
    $pdf->Cell( 50, 20, 'Unidade',   1, 0, 'C', true);
    $pdf->Cell( 50, 20, 'Estoque',   1, 0, 'C', true);
    $pdf->Cell( 70, 20, '$ Custo',   1, 0, 'C', true);
    $pdf->Cell( 70, 20, '$ Venda',   1, 0, 'C', true);
    
    // quebra de linha
    $pdf->Ln();
    
    // define cor de fundo, do
    // texto e fonte dos dados
    $pdf->SetFillColor(200,200,200);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial', '', 8);
    
    // inicializa vari�veis de controle e totaliza��o
    $colore = FALSE;
    $total_custo = 0;
    $total_venda = 0;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        // acumula pre�o de custo e de venda
        $total_custo += $row['estoque'] * $row['preco_custo'];
        $total_venda += $row['estoque'] * $row['preco_venda'];
        
        // formata numericamente os pre�os
        $row['preco_custo'] = number_format($row['preco_custo'], 2, ',', '.');
        $row['preco_venda'] = number_format($row['preco_venda'], 2, ',', '.');
        
        $pdf->Cell( 40, 14, $row['id'],         'LR'0,,'C',$colore);
        $pdf->Cell(220, 14, $row['descricao'],  'LR',0,'L',$colore);
        $pdf->Cell( 50, 14, $row['unidade'],    'LR',0,'C',$colore);
        $pdf->Cell( 50, 14, $row['estoque'],    'LR',0,'R',$colore);
        $pdf->Cell( 70, 14, $row['preco_custo'],'LR',0,'R',$colore);
        $pdf->Cell( 70, 14, $row['preco_venda'],'LR',0,'R',$colore);
        
        // quebra de linha
        $pdf->Ln();
        // inverte cor de fundo
        $colore = !$colore;
    }
    
    // define a fonte dos totais
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(360, 20, 'Total',       1, 0, 'L', true);
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
    // exibe a mensagem de erro 
    echo $e->getMessage(); 
} 
?>