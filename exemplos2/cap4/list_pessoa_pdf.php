<?php 
/**
 * funзгo __autoload() 
 *  Carrega uma classe quando ela й necessбria, 
 *  ou seja, quando ela й instancia pela primeira vez. 
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
    $conn = TConnection::open('exemplos'); // abre uma conexгo 
    
    $id_cidade = (int) $_REQUEST['id_cidade'];
    // define a consulta
    $sql = 'SELECT id, nome, telefone, email'.
           ' FROM pessoa'.
           " WHERE id_cidade = {$id_cidade}" .
           ' ORDER BY id'; 
    
    // executa a instruзгo SQL 
    $result = $conn->query($sql);
    
    // inclui a classe FPDF
    require('app.util/pdf/fpdf.php');
    
    // instancia a classe FPDF
    $pdf = new FPDF('P', 'pt', 'A4');
    
    // adiciona uma pбgina
    $pdf->AddPage();
    
    // define a fonte
    $pdf->SetFont('Arial','B',10);
    
    // define cor de preenchimento,
    // cor de texto e espessura da linha
    $pdf->SetFillColor(130,80,70);
    $pdf->SetTextColor(255);
    $pdf->SetLineWidth(1);
    
    // adiciona cйlulas
    $pdf->Cell( 40, 20, 'Cуdigo',    1, 0, 'C', true);
    $pdf->Cell(220, 20, 'Nome',      1, 0, 'C', true);
    $pdf->Cell(100, 20, 'Telefone',  1, 0, 'C', true);
    $pdf->Cell(160, 20, 'Email',     1, 0, 'C', true);
    
    // quebra de linha
    $pdf->Ln();
    
    // define cor de fundo, do
    // texto e fonte dos dados
    $pdf->SetFillColor(200,200,200);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial', '', 8);
    
    // inicializa variбveis de controle
    $colore = FALSE;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        $pdf->Cell( 40, 14, $row['id'],        'LR',0,'C', $colore);
        $pdf->Cell(220, 14, $row['nome'],      'LR',0,'L', $colore);
        $pdf->Cell(100, 14, $row['telefone'],  'LR',0,'C', $colore);
        $pdf->Cell(160, 14, $row['email'],     'LR',0,'L', $colore);
        
        // quebra de linha
        $pdf->Ln();
        // inverte cor de fundo
        $colore = !$colore;
    }
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(520, 20, '', 'T', 0, 'L', true);
    
    // salva o PDF em arquivo
    $pdf->Output();
} 
catch (Exception $e) 
{ 
    // exibe a mensagem de erro 
    echo $e->getMessage(); 
} 
?>