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
    $id_venda = 1; // define a venda
    $conn = TConnection::open('exemplos'); // abre uma conexão
    
    // define a consulta para obter os dados da venda
    $sql = "SELECT  dt_venda, id_cliente FROM  venda WHERE  id = '{$id_venda}'";
    
    // executa a instrução SQL
    $result = $conn->query($sql);
    
    // obtém o resultado da query
    $venda = $result->fetchObject();
    
    // inclui a classe para emissão de notas fiscais
    include_once 'NotaFiscalResumida.class.php';
    
    // instancia objeto de nota fiscal
    $notafiscal = new NotaFiscalResumida($id_venda, $venda->dt_venda);
    
    // define a consulta para obter os dados do cliente
    $sql = "SELECT pessoa.id, pessoa.nome, pessoa.telefone, pessoa.cpf_cnpj, ".
           "       pessoa.endereco, pessoa.bairro, pessoa.cep, pessoa.rg_ie, ".
           "       cidade.nome as municipio, cidade.estado ".
           "  FROM pessoa, cidade ".
           " WHERE pessoa.id_cidade=cidade.id and pessoa.id = '{$venda->id_cliente}'";
    
    // executa a instrução SQL
    $result = $conn->query($sql);
    // obtém os dados do cliente
    $cliente = $result->fetchObject();
    
    // adiciona a seção contendo os dados do cliente
    $notafiscal->addCliente($cliente);
    
    // adiciona uma seção contendo o cabeçalho dos produtos
    $notafiscal->addCabecalhoProduto();
    
    // define a consulta para obter os dados dos produtos
    $sql = "SELECT produto.id, produto.descricao, produto.unidade, ".
           "       venda_itens.quantidade, venda_itens.valor ".
           "  FROM produto, venda_itens ".
           " WHERE venda_itens.id_produto=produto.id and ".
           "       venda_itens.id_venda = '{$id_venda}'";
    
    // executa a instrução SQL
    $result = $conn->query($sql);
    
    // percorre os dados de retorno
    while ($produto = $result->fetchObject())
    {
        $notafiscal->addProduto($produto);
    }
    
    // adiciona a seção contendo o rodapé dos produtos
    $notafiscal->addRodapeProduto();
    
    // adiciona o rodapé da nota
    $notafiscal->addRodapeNota();
    
    // salva a nota fiscal em um arquivo
    $notafiscal->gerar('notafiscal.pdf');
    
    // cria um link para o usuário realizar o download da nota
    echo "Nota fiscal gerada com sucesso.<br>";
    echo "<a href='notafiscal.pdf'>Clique aqui para visualizar</a>.";
} 
catch (Exception $e) 
{ 
    echo $e->getMessage(); // exibe a mensagem de erro 
}
?>