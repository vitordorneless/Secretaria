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
    else if (file_exists("app.widgets/{$classe}.class.php"))
    {
        include_once "app.widgets/{$classe}.class.php";
    }
}

try
{
    // cria um estilo para o cabeçalho
    $estilo_cabecalho = new TStyle('cabecalho');
    $estilo_cabecalho->font_family     = 'arial,verdana,sans-serif';
    $estilo_cabecalho->font_weight     = 'bold';
    $estilo_cabecalho->color           = '#ffffff';
    $estilo_cabecalho->background_color= '#825046';
    $estilo_cabecalho->font_size       = '10pt';
    $estilo_cabecalho->show();
    
    // cria um estilo para o total
    $estilo_cabecalho = new TStyle('total');
    $estilo_cabecalho->font_family     = 'arial,verdana,sans-serif';
    $estilo_cabecalho->font_weight     = 'bold';
    $estilo_cabecalho->color           = '#ffffff';
    $estilo_cabecalho->background_color= '#757575';
    $estilo_cabecalho->font_size       = '10pt';
    $estilo_cabecalho->show();
    
    // cria um estilo para a quebra
    $estilo_quebra = new TStyle('quebra');
    $estilo_quebra->font_family     = 'arial,verdana,sans-serif';
    $estilo_quebra->font_weight     = 'bold';
    $estilo_quebra->color           = '#ffffff';
    $estilo_quebra->background_color= '#6461A2';
    $estilo_quebra->font_size       = '12pt';
    $estilo_quebra->show();
    
    // cria um estilo para os dados
    $estilo_dados = new TStyle('dados');
    $estilo_dados->font_family     = 'arial,verdana,sans-serif';
    $estilo_dados->color           = '#2D2D2D';
    $estilo_dados->font_size       = '10pt';
    $estilo_dados->show();
    
    $conn = TConnection::open('exemplos'); // abre uma conexão
    
    // define a consulta
    $sql = "SELECT filial.nome || ' (' || filial.id || ')' as filial," .
           "       ' Vendedor ' || vendedor.nome || ' (' || vendedor.id || ')' as vendedor," .
           "       produto.id, produto.descricao, produto.unidade, ".
           "       venda_itens.quantidade, venda_itens.valor" .
           " FROM   venda, venda_itens, pessoa, vendedor, filial, produto" .
           " WHERE  venda.id = venda_itens.id_venda AND" .
           "        venda.id_cliente = pessoa.id AND" .
           "        venda.id_vendedor = vendedor.id AND" .
           "        venda.id_filial = filial.id AND" .
           "        venda_itens.id_produto = produto.id".
           " ORDER BY 1, 2";
    
    $result = $conn->query($sql); // executa a instrução SQL
    
    $tabela = new TTable; // instancia objeto tabela
    
    // define algumas propriedades da tabela
    $tabela->width = 750;
    $tabela->border= 1;
    $tabela->style = "border-collapse:collapse";
    
    // inicializa variáveis de controle e totalização
    $colore = FALSE;
    $total_quantidade = array(0, 0, 0);
    $total_valor      = array(0, 0, 0);
    $controle_quebra1 = NULL;
    $controle_quebra2 = NULL;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        $imprime_titulos  = FALSE;
        
        // verifica se a coluna da quebra 2 (vendedor) trocou de valor e não é a primeira linha
        if (isset($controle_quebra2) AND $controle_quebra2 !== $row['vendedor'])
        {
            // instancia uma linha para o total da quebra
            $total  = $tabela->addRow();
            $total->addCell('');
            $celula = $total->addCell('Total '. $controle_quebra2);
            $total->class = 'total';
            $celula->colspan = 4;
            
            // adiciona células com totais
            $celula1 = $total->addCell($total_quantidade[2]);
            $celula2 = $total->addCell('');
            $celula3 = $total->addCell($total_valor[2]);
            $celula1->align   = "right";
            $celula3->align   = "right";
            
            // reinicializa totais da segunda quebra
            $total_quantidade[2] = 0;
            $total_valor[2]      = 0;
        }
        
        // verifica se a coluna da quebra 1 (filial) trocou de valor e não é a primeira linha
        if (isset($controle_quebra1) AND $controle_quebra1 !== $row['filial'])
        {
            // instancia uma linha para o total da quebra
            $total  = $tabela->addRow();
            $celula = $total->addCell('Total '. $controle_quebra1);
            $total->class = 'total';
            $celula->colspan = 5;
            
            // adiciona células com totais
            $celula1 = $total->addCell($total_quantidade[1]);
            $celula2 = $total->addCell('');
            $celula3 = $total->addCell($total_valor[1]);
            $celula1->align   = "right";
            $celula3->align   = "right";
            
            // reinicializa totais da primeira quebra
            $total_quantidade[1] = 0;
            $total_valor[1]      = 0;
            // reinicializa totais da segunda quebra
            $total_quantidade[2] = 0;
            $total_valor[2]      = 0;
        }
        
        // verifica se a coluna da quebra 1 (filial) trocou de valor
        if ($controle_quebra1 !== $row['filial'])
        {
            // instancia uma linha para exibir a quebra
            $quebra = $tabela->addRow();
            $cell = $quebra->addCell($row['filial']);
            $cell->colspan = 8;
            $quebra->class = 'quebra';
            
            // atualiza variável de controle
            $controle_quebra1 = $row['filial'];
            $imprime_titulos  = TRUE;
        }
        
        // verifica se a coluna da quebra 2 (vendedor) trocou de valor
        if ($controle_quebra2 !== $row['vendedor'])
        {
            // instancia uma linha para exibir a quebra
            $quebra = $tabela->addRow();
            $quebra->addCell('');
            $cell = $quebra->addCell($row['vendedor']);
            $cell->colspan = 7;
            $quebra->class = 'quebra';
            
            // atualiza variável de controle
            $controle_quebra2 = $row['vendedor'];
            $imprime_titulos  = TRUE;
        }
        
        // se alguma quebra trocou de valor, deve imprimir os títulos
        if ($imprime_titulos)
        {
            // instancia uma linha para o cabeçalho
            $cabecalho = $tabela->addRow();
            $cabecalho->addCell('');
            $cabecalho->addCell('');
            $cabecalho->addCell('Código');
            $cabecalho->addCell('Descrição');
            $cabecalho->addCell('Unidade');
            $cabecalho->addCell('Quantidade');
            $cabecalho->addCell('Valor unitário');
            $cabecalho->addCell('Valor total');
            $cabecalho->class = 'cabecalho';
        }
        
        // acumula quantidade vendida para cada quebra
        $total_quantidade[0] += $row['quantidade'];
        $total_quantidade[1] += $row['quantidade'];
        $total_quantidade[2] += $row['quantidade'];
        
        // acumula o valor total do item para cada quebra
        $total_valor[0] += $row['valor'] * $row['quantidade'];
        $total_valor[1] += $row['valor'] * $row['quantidade'];
        $total_valor[2] += $row['valor'] * $row['quantidade'];
        
        // verifica qual cor irá utilizar para o fundo dos dados
        $bgcolor = $colore ? '#d0d0d0' : '#ffffff';
        
        // adiciona uma linha para os dados 
        $linha = $tabela->addRow(); 
        $linha->bgcolor = $bgcolor;
        $linha->class = 'dados';
        
        // adiciona as células na linha de dados
        $cellx = $linha->addCell(''); 
        $celly = $linha->addCell('');
        $cellx->width = 30;
        $celly->width = 30;
        $cell1 = $linha->addCell($row['id']);
        $cell2 = $linha->addCell($row['descricao']);
        $cell3 = $linha->addCell($row['unidade']);
        $cell4 = $linha->addCell($row['quantidade']);
        $cell5 = $linha->addCell($row['valor']);
        $cell6 = $linha->addCell($row['valor'] * $row['quantidade']);
        
        // define o alinhamento das células
        $cell1->align = 'center';
        $cell2->align = 'left';
        $cell3->align = 'center';
        $cell4->align = 'right';
        $cell5->align = 'right';
        $cell6->align = 'right';
        
        // inverte variável de controle para cor de fundo
        $colore = !$colore;
    }
    
    // instancia uma linha para o total da quebra por vendedor
    $total  = $tabela->addRow();
    $total->addCell('');
    $celula = $total->addCell('Total '. $controle_quebra2);
    $total->class = 'total';
    $celula->colspan = 4;
    
    // adiciona células com totais
    $celula1 = $total->addCell($total_quantidade[2]);
    $celula2 = $total->addCell('');
    $celula3 = $total->addCell($total_valor[2]);
    $celula1->align   = "right";
    $celula3->align   = "right";
    
    // instancia uma linha para o total da quebra por filial
    $total  = $tabela->addRow();
    $celula = $total->addCell('Total '. $controle_quebra1);
    $total->class = 'total';
    $celula->colspan = 5;
    
    // adiciona células com totais
    $celula1 = $total->addCell($total_quantidade[1]);
    $celula2 = $total->addCell('');
    $celula3 = $total->addCell($total_valor[1]);
    $celula1->align   = "right";
    $celula3->align   = "right";
    
    // instancia uma linha para o total geral
    $total  = $tabela->addRow();
    $celula = $total->addCell('Total Geral');
    $total->class = 'total';
    $celula->colspan = 5;
    
    // adiciona células com totais
    $celula1 = $total->addCell($total_quantidade[0]);
    $celula2 = $total->addCell('');
    $celula3 = $total->addCell($total_valor[0]);
    $celula1->align   = "right";
    $celula3->align   = "right";
    
    $tabela->show(); // exibe a tabela
} 
catch (Exception $e) 
{ 
    echo $e->getMessage(); // exibe a mensagem de erro 
} 
?>