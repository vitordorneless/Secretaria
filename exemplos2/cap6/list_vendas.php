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
    $conn = TConnection::open('exemplos'); // abre uma conexão 
    
    // cria um estilo para o cabeçalho
    $estilo_cabecalho = new TStyle('cabecalho'); 
    $estilo_cabecalho->font_family     = 'arial,verdana,sans-serif'; 
    $estilo_cabecalho->font_style      = 'normal'; 
    $estilo_cabecalho->font_weight     = 'bold';
    $estilo_cabecalho->color           = '#ffffff';
    $estilo_cabecalho->text_decoration = 'none';
    $estilo_cabecalho->background_color= '#825046'; 
    $estilo_cabecalho->font_size       = '10pt'; 
    
    // cria um estilo para os dados
    $estilo_dados = new TStyle('dados'); 
    $estilo_dados->font_family     = 'arial,verdana,sans-serif'; 
    $estilo_dados->font_style      = 'normal'; 
    $estilo_dados->color           = '#2D2D2D'; 
    $estilo_dados->text_decoration = 'none'; 
    $estilo_dados->font_size       = '10pt'; 
    
    // cria um estilo para o total
    $estilo_total = new TStyle('total');
    $estilo_total->font_family     = 'arial,verdana,sans-serif';
    $estilo_total->font_weight     = 'bold';
    $estilo_total->color           = '#ffffff';
    $estilo_total->background_color= '#757575';
    $estilo_total->font_size       = '10pt';
    
    $estilo_dados->show();
    $estilo_cabecalho->show();
    $estilo_total->show();
    
    // captura os parâmetros via URL
    $ano    = (int) $_REQUEST['ano'];
    $filial = (int) $_REQUEST['filial'];
    
    // define a consulta
    $sql = "SELECT vendedor.nome as vendedor, ".
           "       sum(venda_itens.quantidade * venda_itens.valor) as valor".
           "  FROM vendedor, venda, venda_itens".
           " WHERE venda.id_vendedor = vendedor.id AND".
           "       venda_itens.id_venda = venda.id AND".
           "       strftime('%Y', venda.dt_venda) = '$ano' AND".
           "       venda.id_filial = '$filial' ".
           " GROUP BY 1".
           " ORDER BY 1";
    
    $result = $conn->query($sql); // executa a instrução SQL
    
    $tabela = new TTable; // instancia objeto tabela
    // define algumas propriedades da tabela
    $tabela->width = 700;
    $tabela->border= 1;
    $tabela->style = "border-collapse:collapse";
    
    // instancia uma linha para o cabeçalho
    $cabecalho = $tabela->addRow();
    
    // adiciona células
    $cabecalho->addCell('Vendedor');
    $cabecalho->addCell('Valor');
    $cabecalho->class = 'cabecalho';
    
    // inicializa variáveis de controle e totalização
    $colore = FALSE;
    $total_valor = 0;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        // verifica qual cor irá utilizar para o fundo 
        $bgcolor = $colore ? '#d0d0d0' : '#ffffff';
        
        // adiciona uma linha para os dados
        $linha = $tabela->addRow();
        $linha->bgcolor = $bgcolor;
        $linha->class = 'dados';
        
        // totaliza o valor
        $total_valor += $row['valor'];
        
        // adiciona as células 
        $cell1 = $linha->addCell($row['vendedor']);
        $cell2 = $linha->addCell(number_format($row['valor'], 2, ',', '.'));
        
        // define o alinhamento das células
        $cell1->align = 'left';
        $cell2->align = 'right';
        
        $colore = !$colore; // inverte cor de fundo
    }
    
    // instancia uma linha para o totalizador 
    $total = $tabela->addRow();
    $total->class = 'total';
    
    // adiciona células 
    $total->addCell('Total'); 
    $celula = $total->addCell(number_format($total_valor, 2, ',', '.'));
    $celula->align   = "right";
    
    $tabela->show();
} 
catch (Exception $e) 
{ 
    echo $e->getMessage(); // exibe a mensagem de erro 
} 
?>