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
    
    // define os rótulos das colunas
    $label = array();
    $label['produto.id']          = 'Código';
    $label['produto.descricao']   = 'Descrição'; 
    $label['produto.preco_custo'] = 'Preço de custo';
    $label['produto.estoque']     = 'Estoque';
    $label['produto.unidade']     = 'Unidade';
    $label['produto.preco_venda'] = 'Preço de venda';
    $label['fabricante.id']       = 'Fabricante';
    $label['fabricante.nome']     = 'Nome do fabricante';
    
    // define os alinhamentos das colunas
    $align = array();
    $align['produto.id']          = 'L';
    $align['produto.descricao']   = 'L';
    $align['produto.preco_custo'] = 'R';
    $align['produto.estoque']     = 'C';
    $align['produto.unidade']     = 'L';
    $align['produto.preco_venda'] = 'R';
    $align['fabricante.id']       = 'L';
    $align['fabricante.nome']     = 'L';
    
    // define a largura das colunas
    $width = array();
    $width['produto.id']          =  40;
    $width['produto.descricao']   = 240;
    $width['produto.preco_custo'] =  80;
    $width['produto.estoque']     =  50;
    $width['produto.unidade']     =  50;
    $width['produto.preco_venda'] =  80;
    $width['fabricante.id']       =  40;
    $width['fabricante.nome']     = 100;
    
    $select = array();
    // forma as colunas para o SELECT
    if ($_REQUEST['colunas'])
    {
        foreach ($_REQUEST['colunas'] as $coluna)
        {
            $select[] = "{$coluna} as \"{$coluna}\"";
        }
    }
    
    // define a consulta
    $sql = 'SELECT '. implode(',', $select).
           ' FROM produto, fabricante' .
           ' WHERE produto.id_fabricante=fabricante.id ';
           
    if (!empty($_REQUEST['produto'])) // detecta filtro por descricao do produto
    {
        $produto = addslashes(strtoupper($_REQUEST['produto'])); 
        $sql .= " AND produto.descricao like '%{$produto}%'";
    }
    
    if (!empty($_REQUEST['fabricante'])) // detecta filtro por nome do fabricante
    {
        $fabricante = addslashes(strtoupper($_REQUEST['fabricante']));
        $sql .= " AND fabricante.nome like '%{$fabricante}%'";
    }
    
    if (!empty($_REQUEST['estoquemin'])) // detecta filtro por estoque minimo
    {
        $estoquemin = (int) $_REQUEST['estoquemin'];
        $sql .= " AND produto.estoque >= {$estoquemin}";
    }
    
    if (!empty($_REQUEST['estoquemax'])) // detecta filtro por estoque maximo
    {
        $estoquemax = (int) $_REQUEST['estoquemax'];
        $sql .= " AND produto.estoque <= {$estoquemax}";
    }
    
    $sql .= ' ORDER BY ' . $_REQUEST['ordem'];
    
    
    $result = $conn->query($sql); // executa a instrução SQL
    
    
    require_once 'app.util/pdf/fpdf.php'; // inclui a classe FPDF
    $pdf = new FPDF('P', 'pt', 'A4'); // instancia a classe FPDF
    $pdf->AddPage(); // adiciona uma página
    $pdf->SetFont('Arial','B',10); // define a fonte
    
    // define cor de preenchimento, cor de texto e espessura da linha
    $pdf->SetFillColor(130,80,70);
    $pdf->SetTextColor(255);
    $pdf->SetLineWidth(1);
    
    $largura_total = 0;
    // adiciona células de título das colunas
    foreach ($_REQUEST['colunas'] as $coluna)
    {
        $titulo      = $label[$coluna];
        $largura     = $width[$coluna];
        $alinhamento = $align[$coluna];
        $pdf->Cell( $largura, 20, $titulo, 1, 0, $alinhamento, true );
        
        $largura_total += $largura;
    }
    
    $pdf->Ln(); // quebra de linha
    
    // define cor de fundo, do texto e fonte dos dados
    $pdf->SetFillColor(200,200,200);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial', '', 8);
    
    // inicializa variáveis de controle e totalização
    $colore = FALSE;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        // adiciona as células contendo os dados do relatório
        foreach ($_REQUEST['colunas'] as $coluna)
        {
            $dado        = $row[$coluna];
            $largura     = $width[$coluna];
            $alinhamento = $align[$coluna];
            
            $pdf->Cell( $largura, 14, $dado, 'LR', 0, $alinhamento, $colore);
        }
        
        $pdf->Ln(); // quebra de linha
        $colore = !$colore; // inverte cor de fundo
    }
    // desenha a linha final
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell($largura_total, 20, '',  'T', 0, 'L', true);
    
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