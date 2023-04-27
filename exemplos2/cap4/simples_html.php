<?php 
/**
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
    $estilo_cabecalho->show();
    
    // cria um estilo para os dados
    $estilo_dados = new TStyle('dados'); 
    $estilo_dados->font_family     = 'arial,verdana,sans-serif'; 
    $estilo_dados->font_style      = 'normal'; 
    $estilo_dados->color           = '#2D2D2D'; 
    $estilo_dados->text_decoration = 'none'; 
    $estilo_dados->font_size       = '10pt'; 
    $estilo_dados->show();
    
    // define a consulta
    $sql = 'SELECT id, descricao, unidade, estoque, preco_custo, preco_venda'.
           ' FROM produto'.
           ' ORDER BY descricao'; 
    
    // executa a instrução SQL 
    $result = $conn->query($sql);
    
    // instancia objeto tabela 
    $tabela = new TTable; 
    
    // define algumas propriedades da tabela
    $tabela->width = 700; 
    $tabela->border= 1;
    $tabela->style = "border-collapse:collapse";
    
    // instancia uma linha para o cabeçalho 
    $cabecalho = $tabela->addRow();
    
    // adiciona células 
    $cabecalho->addCell('Código'); 
    $cabecalho->addCell('Descrição'); 
    $cabecalho->addCell('Unidade'); 
    $cabecalho->addCell('Estoque');
    $cabecalho->addCell('$ Custo');
    $cabecalho->addCell('$ Venda');
    $cabecalho->class = 'cabecalho';
    
    // inicializa variáveis de controle e totalização
    $colore = FALSE;
    $total_custo = 0;
    $total_venda = 0;
    
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
        
        // adiciona uma linha para os dados 
        $linha = $tabela->addRow(); 
        $linha->bgcolor = $bgcolor;
        $linha->class = 'dados';
        
        // adiciona as células 
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
        
        // inverte cor de fundo
        $colore = !$colore;
    }
    
    // instancia uma linha para o totalizador 
    $total = $tabela->addRow();
    $total->class = 'cabecalho';
    
    // adiciona células 
    $celula= $total->addCell('Total'); 
    $celula->colspan = 4; 
    
    $celula1 = $total->addCell(number_format($total_custo, 2, ',', '.'));
    $celula2 = $total->addCell(number_format($total_venda, 2, ',', '.')); 
    $celula1->align   = "right";
    $celula2->align   = "right";
    
    $tabela->show();
} 
catch (Exception $e) 
{ 
    // exibe a mensagem de erro 
    echo $e->getMessage(); 
} 
?>