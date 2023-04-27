<?php 
/**
 * fun��o __autoload() 
 *  Carrega uma classe quando ela � necess�ria, 
 *  ou seja, quando ela � instancia pela primeira vez. 
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
    $conn = TConnection::open('exemplos'); // abre uma conex�o 
    
    // cria um estilo para o cabe�alho
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
    
    $id_cidade = (int) $_REQUEST['id_cidade'];
    // define a consulta
    $sql = 'SELECT id, nome, telefone, email'.
           ' FROM pessoa'.
           " WHERE id_cidade = {$id_cidade}" .
           ' ORDER BY id'; 
    
    // executa a instru��o SQL 
    $result = $conn->query($sql);
    
    // instancia objeto tabela 
    $tabela = new TTable; 
    
    // define algumas propriedades da tabela
    $tabela->width = 700; 
    $tabela->border= 1;
    $tabela->align = 'center';
    $tabela->style = "border-collapse:collapse";
    
    // instancia uma linha para o cabe�alho 
    $cabecalho = $tabela->addRow();
    
    // adiciona c�lulas 
    $cabecalho->addCell('C�digo'); 
    $cabecalho->addCell('Nome'); 
    $cabecalho->addCell('Telefone');
    $cabecalho->addCell('Email'); 
    $cabecalho->class = 'cabecalho';
    
    // inicializa vari�veis de controle
    $colore = FALSE;
    
    // percorre os resultados
    foreach ($result as $row)
    {
        // verifica qual cor ir� utilizar para o fundo 
        $bgcolor = $colore ? '#d0d0d0' : '#ffffff';
        
        // adiciona uma linha para os dados 
        $linha = $tabela->addRow(); 
        $linha->bgcolor = $bgcolor;
        $linha->class = 'dados';
        
        // adiciona as c�lulas 
        $cell1 = $linha->addCell($row['id']);
        $cell2 = $linha->addCell($row['nome']);
        $cell3 = $linha->addCell($row['telefone']);
        $cell4 = $linha->addCell($row['email']);
        
        // define o alinhamento das c�lulas
        $cell1->align = 'center';
        $cell2->align = 'left';
        $cell3->align = 'center';
        $cell4->align = 'left';
        
        // inverte cor de fundo
        $colore = !$colore;
    }
    
    $tabela->show();
} 
catch (Exception $e) 
{ 
    // exibe a mensagem de erro 
    echo $e->getMessage(); 
} 
?>