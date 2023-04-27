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
    $sql = 'SELECT id, descricao, unidade, estoque, preco_custo, preco_venda'.
           ' FROM produto'.
           ' ORDER BY descricao'; 
    
    $result = $conn->query($sql); // executa a instrução SQL
    
    // inclui a classe Rtf
    require 'app.util/rtf/PHPRtfLite.php';
    // registra o class loader
    PHPRtfLite::registerAutoloader();
    
    // instancia a classe Rtf
    $rtf = new PHPRtfLite;
    $rtf->setMargins(2,2,2,2);
    
    $secao = $rtf->addSection(); // adiciona uma seção ao documento
    $table = $secao->addTable(); // adiciona a tabela
    
    // fonte do título
    $fonte_tit   = new PHPRtfLite_Font(12, 'Arial', '#ffffff');
    $fonte_dados = new PHPRtfLite_Font( 8, 'Arial', '#000000');
    
    // cria o cabeçalho da tabela
    $table->addRow(0.5);
    $table->addColumnsList(array(2,7,2,2,2,2));
    
    // adiciona células
    $table->writeToCell(1, 1, 'Código',    $fonte_tit, new PHPRtfLite_ParFormat('center'));
    $table->writeToCell(1, 2, 'Descrição', $fonte_tit, new PHPRtfLite_ParFormat('left'));
    $table->writeToCell(1, 3, 'Unidade',   $fonte_tit, new PHPRtfLite_ParFormat('center'));
    $table->writeToCell(1, 4, 'Estoque',   $fonte_tit, new PHPRtfLite_ParFormat('right'));
    $table->writeToCell(1, 5, '$ Custo',   $fonte_tit, new PHPRtfLite_ParFormat('right'));
    $table->writeToCell(1, 6, '$ Venda',   $fonte_tit, new PHPRtfLite_ParFormat('right'));
    
    // define a cor de fundo da linha 1
    $table->setBackgroundForCellRange('#825046', 1, 1, 1, $table->getColumnsCount());
    
    // inicializa variáveis de controle e totalização
    $colore = FALSE;
    $total_custo = 0;
    $total_venda = 0;
    $linha = 2;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        // acumula preço de custo e de venda
        $total_custo += $row['estoque'] * $row['preco_custo'];
        $total_venda += $row['estoque'] * $row['preco_venda'];
        
        // formata numericamente os preços
        $row['preco_custo'] = number_format($row['preco_custo'], 2, ',', '.');
        $row['preco_venda'] = number_format($row['preco_venda'], 2, ',', '.');
        
        // verifica qual cor irá utilizar para o fundo 
        $bgcolor = $colore ? '#d0d0d0' : '#ffffff';
        
        $table->addRow(0.5);
        
        $table->writeToCell($linha, 1, $row['id'],          $fonte_dados, new PHPRtfLite_ParFormat('center'));
        $table->writeToCell($linha, 2, $row['descricao'],   $fonte_dados, new PHPRtfLite_ParFormat('left'));
        $table->writeToCell($linha, 3, $row['unidade'],     $fonte_dados, new PHPRtfLite_ParFormat('center'));
        $table->writeToCell($linha, 4, $row['estoque'],     $fonte_dados, new PHPRtfLite_ParFormat('right'));
        $table->writeToCell($linha, 5, $row['preco_custo'], $fonte_dados, new PHPRtfLite_ParFormat('right'));
        $table->writeToCell($linha, 6, $row['preco_venda'], $fonte_dados, new PHPRtfLite_ParFormat('right'));
        
        // colore o fundo da linha
        $table->setBackgroundForCellRange($bgcolor, $linha, 1, $linha, $table->getColumnsCount());
        
        // inverte cor de fundo
        $colore = !$colore;
        // incrementa contador de linha
        $linha ++;
    }
    
    // adiciona linha com totais
    $table->addRow(0.5);
    
    $table->mergeCellRange($linha, 1, $linha, 4);
    $table->writeToCell($linha, 1, 'Total', $fonte_tit, new PHPRtfLite_ParFormat('left'));
    
    $apresentar_custo = number_format($total_custo, 2, ',', '.');
    $apresentar_venda = number_format($total_venda, 2, ',', '.');
    $table->writeToCell($linha, 5, $apresentar_custo,  $fonte_tit, new PHPRtfLite_ParFormat('right'));
    $table->writeToCell($linha, 6, $apresentar_venda,  $fonte_tit, new PHPRtfLite_ParFormat('right'));
    
    // define cor de fundo da última linha
    $table->setBackgroundForCellRange('#825046', $linha, 1, $linha, $table->getColumnsCount());
    
    // define bordas para toda a tabela
    $table->setBorderForCellRange(PHPRtfLite_Border::create(0.7, '#000000'), 1, 1,
                                  $table->getRowsCount(), $table->getColumnsCount());
    
    // salva o RTF em arquivo
    $rtf->save('app.output/output.rtf');
    
    // escreve um link para baixar o arquivo na tela
    echo '<center>';
    echo "Arquivo gerado com sucesso<br>";
    echo "<a target=newwindow href='app.output/output.rtf'> Clique aqui para baixar</a>";
    echo '</center>';
} 
catch (Exception $e) 
{ 
    // exibe a mensagem de erro 
    echo $e->getMessage(); 
} 
?>