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
    $sql = "SELECT fabricante.nome || ' (' || fabricante.id || ')' as fabricante, ".
           "       produto.id, produto.descricao, produto.unidade, ".
           "       produto.estoque, produto.preco_custo, produto.preco_venda".
           " FROM produto, fabricante".
           " WHERE produto.id_fabricante=fabricante.id".
           " ORDER BY 1, 3";
    
    // executa a instrução SQL
    $result = $conn->query($sql);
    
    // instancia objeto tabela
    $tabela = new TTable;
    
    // define algumas propriedades da tabela
    $tabela->width = 700;
    $tabela->border= 1;
    $tabela->style = "border-collapse:collapse";
    
    // inicializa variáveis de controle e totalização
    $colore = FALSE;
    $total_custo = 0;
    $total_venda = 0;
    $total_estoq = 0;
    $total_custo_quebra = 0;
    $total_venda_quebra = 0;
    $total_estoq_quebra = 0;
    $controle_quebra = NULL;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        // verifica se é a primeira linha ou a coluna de quebra trocou de valor
        if (!isset($controle_quebra) OR $controle_quebra !== $row['fabricante'])
        {
            // se a variável de controle possui valor, deve totalizar
            if (isset($controle_quebra))
            {
                // instancia uma linha para o total da quebra
                $total  = $tabela->addRow();
                $celula = $total->addCell('Total '. $controle_quebra);
                $total->class = 'total';
                $celula->colspan = 4;
                
                // adiciona células com totais
                $custo_exibir = number_format($total_custo_quebra, 2, ',', '.');
                $venda_exibir = number_format($total_venda_quebra, 2, ',', '.');
                $celula1 = $total->addCell($total_estoq_quebra);
                $celula2 = $total->addCell($custo_exibir);
                $celula3 = $total->addCell($venda_exibir); 
                $celula1->align   = "right";
                $celula2->align   = "right";
                $celula3->align   = "right";
                
                // reinicializa variáveis totalizadoras por quebra
                $total_custo_quebra = 0;
                $total_venda_quebra = 0;
                $total_estoq_quebra = 0;
            }
            
            // instancia uma linha para exibir o valor atual da quebra
            $quebra = $tabela->addRow();
            $cell = $quebra->addCell($row['fabricante']);
            $cell->colspan = 7; 
            $quebra->class = 'quebra';
            
            // instancia uma linha para o cabeçalho
            $cabecalho = $tabela->addRow();
            $cabecalho->addCell(''); 
            $cabecalho->addCell('Código'); 
            $cabecalho->addCell('Descrição'); 
            $cabecalho->addCell('Unidade'); 
            $cabecalho->addCell('Estoque');
            $cabecalho->addCell('$ Custo');
            $cabecalho->addCell('$ Venda');
            $cabecalho->class = 'cabecalho';
            
            // atualiza variável de controle
            $controle_quebra = $row['fabricante'];
        }
        
        // acumula preço de custo, de venda e estoque (geral)
        $total_custo += $row['estoque'] * $row['preco_custo'];
        $total_venda += $row['estoque'] * $row['preco_venda'];
        $total_estoq += $row['estoque'];
        
        // acumula preço de custo, de venda e estoque (quebra)
        $total_custo_quebra += $row['estoque'] * $row['preco_custo'];
        $total_venda_quebra += $row['estoque'] * $row['preco_venda'];
        $total_estoq_quebra += $row['estoque'];
        
        // formata numericamente os preços
        $row['preco_custo'] = number_format($row['preco_custo'], 2, ',', '.');
        $row['preco_venda'] = number_format($row['preco_venda'], 2, ',', '.');
        
        // verifica qual cor irá utilizar para o fundo dos dados
        $bgcolor = $colore ? '#d0d0d0' : '#ffffff';
        
        // adiciona uma linha para os dados (detalhamento)
        $linha = $tabela->addRow(); 
        $linha->bgcolor = $bgcolor;
        $linha->class = 'dados';
        
        // adiciona as células na linha de dados 
        $cellx = $linha->addCell('');
        $cellx->width = 30;
        $cell1 = $linha->addCell($row['id']);
        $cell2 = $linha->addCell($row['descricao']);
        $cell3 = $linha->addCell($row['unidade']);
        $cell4 = $linha->addCell($row['estoque']);
        $cell5 = $linha->addCell($row['preco_custo']);
        $cell6 = $linha->addCell($row['preco_venda']);
        
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
    
    // adiciona linha para os totais da última quebra
    $total = $tabela->addRow();
    $celula= $total->addCell('Total '. $controle_quebra);
    $total->class = 'total'; 
    $celula->colspan = 4;
    $custo_exibir = number_format($total_custo_quebra, 2, ',', '.');
    $venda_exibir = number_format($total_venda_quebra, 2, ',', '.');
    $celula1 = $total->addCell($total_estoq_quebra);
    $celula2 = $total->addCell($custo_exibir);
    $celula3 = $total->addCell($venda_exibir); 
    $celula1->align   = "right";
    $celula2->align   = "right";
    $celula3->align   = "right";
    
    // adiciona linha para o total geral 
    $total = $tabela->addRow();
    $total->class = 'total';
    $celula  = $total->addCell('Total Geral'); 
    $celula->colspan = 4;
    $celula1 = $total->addCell($total_estoq);
    $celula2 = $total->addCell(number_format($total_custo, 2, ',', '.'));
    $celula3 = $total->addCell(number_format($total_venda, 2, ',', '.'));
    $celula1->align   = "right";
    $celula2->align   = "right";
    $celula3->align   = "right";
    
    // exibe a tabela
    $tabela->show();
} 
catch (Exception $e) 
{ 
    // exibe a mensagem de erro 
    echo $e->getMessage(); 
} 
?>