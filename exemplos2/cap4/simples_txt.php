<?php 
/** 
 * Carrega uma classe quando ela é necessária, 
 * ou seja, quando ela é instancia pela primeira vez. 
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
    $conn = TConnection::open('exemplos'); // abre conexão com base de dados
    
    // define a consulta SQL
    $sql = 'SELECT id, descricao, unidade, estoque, preco_custo, preco_venda'.
           ' FROM produto'.
           ' ORDER BY descricao';
    
    // cria o arquivo TXT
    $handle = fopen('app.output/output.txt', 'w');
    $result = $conn->query($sql); // executa a instrução SQL 
    
    // monta o cabeçalho do relatório
    $linha = str_pad('Código', 10, ' ', STR_PAD_RIGHT)     . ' | ';
    $linha.= str_pad('Descrição', 40, ' ', STR_PAD_RIGHT)  . ' | ';
    $linha.= str_pad('Unidade', 7, ' ', STR_PAD_BOTH)      . ' | ';
    $linha.= str_pad('Estoque', 7, ' ', STR_PAD_LEFT)      . ' | ';
    $linha.= str_pad('$ Custo', 12, ' ', STR_PAD_LEFT)     . ' | ';
    $linha.= str_pad('$ Venda', 12, ' ', STR_PAD_LEFT);
    $linha.= "\r\n";
    $linha.= str_repeat('=', 103);
    $linha.= "\r\n";
    
    // escreve o cabeçalho no arquivo
    fwrite($handle, $linha);
    
    // inicializa variáveis de totalização
    $total_custo = 0;
    $total_venda = 0;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        // acumula preço de custo e de venda
        $total_custo += $row['estoque'] * $row['preco_custo'];
        $total_venda += $row['estoque'] * $row['preco_venda'];
        
        // trunca o comprimento da descrição
        $row['descricao']   = substr($row['descricao'], 0, 40);
        
        // formata numericamente os preços
        $row['preco_custo'] = number_format($row['preco_custo'], 2, ',', '.');
        $row['preco_venda'] = number_format($row['preco_venda'], 2, ',', '.');
        
        // monta a linha de dados
        $linha = str_pad($row['id'], 10, ' ', STR_PAD_RIGHT)          . ' | ';
        $linha.= str_pad($row['descricao'], 40, ' ', STR_PAD_RIGHT)   . ' | ';
        $linha.= str_pad($row['unidade'], 7, ' ', STR_PAD_BOTH)       . ' | ';
        $linha.= str_pad($row['estoque'], 7, ' ', STR_PAD_LEFT)       . ' | ';
        $linha.= str_pad($row['preco_custo'], 12, ' ', STR_PAD_LEFT)  . ' | ';
        $linha.= str_pad($row['preco_venda'], 12, ' ', STR_PAD_LEFT);
        $linha.= "\r\n";
        
        // escreve a linha no arquivo
        fwrite($handle, $linha);
    }
    // escreve uma linha de separação
    $linha.= str_repeat('=', 103);
    $linha.= "\r\n";
    
    // escreve a linha no arquivo
    fwrite($handle, $linha);
    
    // monta a linha de totalização
    $linha = 'Total:' . str_repeat(' ', 70);
    $apresentar_custo = number_format($total_custo, 2, ',', '.');
    $apresentar_venda = number_format($total_venda, 2, ',', '.');
    $linha.= str_pad($apresentar_custo, 10, ' ', STR_PAD_LEFT);
    $linha.= ' | ';
    $linha.= str_pad($apresentar_venda, 10, ' ', STR_PAD_LEFT);
    $linha.= "\r\n";
    
    fwrite($handle, $linha); // escreve a linha no arquivo
    fclose($handle); // fecha o arquivo
    
    // escreve um link para baixar o arquivo na tela
    echo '<center>';
    echo "Arquivo gerado com sucesso<br>";
    echo "<a target=newwindow href='app.output/output.txt'> Clique aqui para baixar</a>";
    echo '</center>';
} 
catch (Exception $e) 
{ 
    // exibe a mensagem de erro 
    echo $e->getMessage();  
} 
?>