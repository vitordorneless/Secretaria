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
date_default_timezone_set('America/Sao_Paulo');
try
{
    $id_cliente = 116; // define o cliente
    $conn = TConnection::open('exemplos'); // abre uma conexão
    
    // define a consulta para obter os dados do cliente
    $sql = "SELECT pessoa.id, pessoa.nome, pessoa.telefone, pessoa.cpf_cnpj, ".
           "       pessoa.endereco, pessoa.bairro, pessoa.cep, pessoa.rg_ie, ".
           "       cidade.nome as municipio, cidade.estado ".
           "  FROM pessoa, cidade ".
           " WHERE pessoa.id_cidade=cidade.id and pessoa.id = '{$id_cliente}'";
    
    // executa a instrução SQL
    $result = $conn->query($sql);
    $cliente = $result->fetchObject();
    
    // define o vetor de substituições para o texto da carta
    $substituicoes = array();
    $substituicoes['local']      = 'Lajeado';
    $substituicoes['data']       = date('d-m-Y');
    $substituicoes['nome']       = $cliente->nome;
    $substituicoes['endereco']   = $cliente->endereco;
    $substituicoes['bairro']     = $cliente->bairro;
    $substituicoes['municipio']  = $cliente->municipio;
    $substituicoes['uf']         = $cliente->estado;
    $substituicoes['cep']        = $cliente->cep;
    $substituicoes['empresa']    = 'Informática comércio Ltda';
    
    // inclui a classe para carta de inadimplencia
    include_once 'CartaInadimplencia.class.php';
    
    // instancia a carta de inadimplência
    $carta = new CartaInadimplencia;
    
    // atribui o título da carta
    $carta->addTitulo('Comunicado de inadimplência');
    
    // adiciona o texto à carta a partir de um arquivo texto
    $carta->addTexto(utf8_encode(file_get_contents('carta.txt')), $substituicoes);
    
    // cria matriz com os títulos e larguras das colunas
    $titulos = array('Data', 'Produto', 'Qtde', 'Valor', 'Total');
    $larguras= array( 2, 7, 2, 2, 2 );
    
    // cria a tabela de detalhamento da carta
    $carta->addTabela($titulos, $larguras);
    
    // define a consulta para obter os dados dos itens vendidos
    $sql = "SELECT venda.dt_venda, produto.descricao, ".
           "       venda_itens.quantidade, venda_itens.valor ".
           "  FROM produto, venda_itens, venda ".
           " WHERE venda_itens.id_produto=produto.id and ".
           "       venda_itens.id_venda = venda.id and ".
           "       venda.id_cliente = '{$id_cliente}' and ".
           "       venda.quitada = 'f'";
    
    // executa a instrução SQL
    $result = $conn->query($sql);
    
    // percorre os itens vendidos e adiciona na carta
    while ($detalhe = $result->fetchObject())
    {
        $carta->addDetalhe($detalhe);
    }
    
    // adiciona uma linha de totalização à carta
    $carta->addTotal();
    
    // salva a carta em um arquivo
    $carta->gerar('carta.rtf');
    
    // cria um link para o usuário realizar o download da carta
    echo "Carta de inadimplência gerada com sucesso.<br>";
    echo "<a href='carta.rtf'>Clique aqui para visualizar</a>.";
} 
catch (Exception $e) 
{ 
    echo $e->getMessage(); // exibe a mensagem de erro 
}
?>