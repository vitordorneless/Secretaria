<?php
date_default_timezone_set('America/Sao_Paulo');

// inclui a classe para emissão de notas fiscais
include_once('NotaFiscalCompleta.class.php');

// instancia objeto de nota fiscal
$notafiscal = new NotaFiscalCompleta('001');
// define as datas de emissão e saída
$notafiscal->setDatas(date('d/m/Y'), date('d/m/Y'), date('H:m:s'));

// define os atributos de cliente
$cliente = new StdClass;
$cliente->nome      = 'cliente';
$cliente->documento = 'CNPJ Cliente';
$cliente->endereco  = 'Rua Cliente';
$cliente->bairro    = 'Bairro Cliente';
$cliente->cep       = 'CEP Cliente';
$cliente->municipio = 'Municipio cliente';
$cliente->fone      = 'Fone';
$cliente->uf        = 'UF';
$cliente->ie        = 'IE';

// acrescenta os dados da nota fiscal
$notafiscal->addCabecalhoNota('5.949', 'Venda', '12.345.678/0001-99', '123456789');

// adiciona a seção contendo os dados do cliente
$notafiscal->addCliente($cliente);

// define os atributos de um produto
$produto1 = new StdClass;
$produto1->codigo = 1;
$produto1->descricao = 'Chuchu';
$produto1->classe = 'A';
$produto1->situacao = '041';
$produto1->unidade = 'PC';
$produto1->quantidade = 2;
$produto1->valor = 3;
$produto1->icms  = 12;
$produto1->ipi   = 10;

// define os atributos de um produto
$produto2 = new StdClass;
$produto2->codigo = 2;
$produto2->descricao = 'Mamão';
$produto2->classe = 'A';
$produto2->situacao = '041';
$produto2->unidade = 'PC';
$produto2->quantidade = 3;
$produto2->valor = 4;
$produto2->icms  = 12;
$produto2->ipi   = 10;

// adiciona uma seção contendo o cabeçalho dos produtos
$notafiscal->addCabecalhoProduto();

// adiciona os produtos definidos repetidas vezes
$notafiscal->addProduto($produto1);
$notafiscal->addProduto($produto1);
$notafiscal->addProduto($produto1);
$notafiscal->addProduto($produto2);
$notafiscal->addProduto($produto2);
$notafiscal->addProduto($produto2);

// adiciona a seção contendo o rodapé dos produtos
$notafiscal->addRodapeProduto();

// define os atributos de transporte
$transporte = new StdClass;
$transporte->nome         = 'Transp ok';
$transporte->conta        = 'Emitente';
$transporte->placa        = 'IDF 1234';
$transporte->uf_veic      = 'RS';
$transporte->cnpj         = '12.345.678/0001-99';
$transporte->endereco     = 'Rua da transp.';
$transporte->municipio    = 'Porto Alegre';
$transporte->uf           = 'RS';
$transporte->ie           = '2349827340';
$transporte->quantidade   = 100;
$transporte->especie      = 'Volumes';
$transporte->marca        = 'Teste';
$transporte->numero       = 12;
$transporte->peso_bruto   = 120;
$transporte->peso_liquido = 100;

// adiciona seção contendo os totais da nota
$notafiscal->addTotaisNota(200, 300, 100);

// adiciona seção contendo os dados de transporte
$notafiscal->addDadosTransportadora($transporte);

// adiciona seção contendo o rodapé da nota fiscal
$notafiscal->addRodapeNota('Adianti Soluções em Informática');

// salva a nota fiscal em um arquivo
$notafiscal->gerar('notafiscal.pdf');

// cria um link para o usuário realizar o download da nota
echo "Nota fiscal gerada com sucesso.<br>";
echo "<a href='notafiscal.pdf'>Clique aqui para visualizar</a>.";
?>