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
    $sql = 'SELECT id, nome, estado, '.
           '       (select count(*) from pessoa where id_cidade=cidade.id) as qtde'.
           ' FROM cidade'.
           ' ORDER BY (select count(*) from pessoa where id_cidade=cidade.id) desc'; 
    
    // executa a instrução SQL 
    $result = $conn->query($sql);
    
    // inclui a classe FPDF
    require('app.util/pdf/fpdf.php');
    
    // instancia a classe FPDF
    $pdf = new FPDF('P', 'pt', 'A4');
    
    // adiciona uma página
    $pdf->AddPage();
    
    // define a fonte
    $pdf->SetFont('Arial','B',10);
    
    // define cor de preenchimento,
    // cor de texto e espessura da linha
    $pdf->SetFillColor(130,80,70);
    $pdf->SetTextColor(255);
    $pdf->SetLineWidth(1);
    
    // adiciona células
    $pdf->Cell( 40, 20, 'Código',    1, 0, 'C', true);
    $pdf->Cell(220, 20, 'Nome',      1, 0, 'C', true);
    $pdf->Cell( 50, 20, 'Estado',    1, 0, 'C', true);
    $pdf->Cell( 70, 20, 'Quantidade',1, 0, 'C', true);
    
    // quebra de linha
    $pdf->Ln();
    
    // define cor de fundo, do
    // texto e fonte dos dados
    $pdf->SetFillColor(200,200,200);
    // inicializa variáveis de controle e totalização
    $colore = FALSE;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        $link = $_SERVER['HTTP_REFERER'] . "list_pessoa_pdf.php?id_cidade={$row['id']}";
        // define a fonte para o link
        $pdf->SetTextColor(0,0,255);
        $pdf->SetFont('Arial', 'U', 8);
        // adiciona a célula de código
        $pdf->Cell( 40, 14, $row['id'],        'LR',0,'C', $colore, $link);
        
        // define a fonte para o texto
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', '', 8);
        // adiciona as demais células
        $pdf->Cell(220, 14, $row['nome'],      'LR',0,'L', $colore);
        $pdf->Cell( 50, 14, $row['estado'],    'LR',0,'C', $colore);
        $pdf->Cell( 70, 14, $row['qtde'],      'LR',0,'C', $colore);
        
        // quebra de linha
        $pdf->Ln();
        // inverte cor de fundo
        $colore = !$colore;
    }
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(380, 20, '', 'T', 0, 'L', true);
    
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