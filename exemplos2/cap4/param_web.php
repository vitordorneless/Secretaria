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
    
    // define a consulta
    $sql = 'SELECT p.id, p.nome, p.dt_nascimento, p.telefone,
                   p.email, c.nome as cidade' .
           ' FROM pessoa p, cidade c' .
           ' WHERE p.id_cidade=c.id ';
    
    // detecta filtro por nome da cidade
    if (!empty($_REQUEST['cidade']))
    {
        $cidade = addslashes(strtoupper($_REQUEST['cidade'])); 
        $sql .= " AND c.nome like '%{$cidade}%'";
    }
    // detecta filtro por nome da pessoa
    if (!empty($_REQUEST['pessoa']))
    {
        $pessoa = addslashes(strtoupper($_REQUEST['pessoa']));
        $sql .= " AND p.nome like '%{$pessoa}%'";
    }
    // detecta filtro por sexo
    if (!empty($_REQUEST['sexo']))
    {
        $sexo = addslashes($_REQUEST['sexo']);
        $sql .= " AND p.sexo ='{$sexo}'";
    }
    // detecta filtro por estado
    if (!empty($_REQUEST['estado']))
    {
        $estado = addslashes($_REQUEST['estado']);
        $sql .= " AND c.estado ='{$estado}'";
    }
    
    $sql .= ' ORDER BY p.nome';
     
    // executa a instru��o SQL 
    $result = $conn->query($sql);
    
    // instancia objeto tabela 
    $tabela = new TTable; 
    
    // define algumas propriedades da tabela
    $tabela->width = 730; 
    $tabela->border= 1;
    $tabela->style = "border-collapse:collapse";
    
    // instancia uma linha para o cabe�alho 
    $cabecalho = $tabela->addRow();
    
    // adiciona c�lulas 
    $cabecalho->addCell('C�digo'); 
    $cabecalho->addCell('Nome'); 
    $cabecalho->addCell('Nascimento'); 
    $cabecalho->addCell('Telefone');
    $cabecalho->addCell('E-Mail');
    $cabecalho->addCell('Cidade');
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
        
        // l� a data de nascimento
        $dt_nascimento = date_parse($row['dt_nascimento']);
        $dt_nascimento = str_pad($dt_nascimento['day'], 2, '0', STR_PAD_LEFT).'/'.
                         str_pad($dt_nascimento['month'], 2, '0', STR_PAD_LEFT).'/'.
                         $dt_nascimento['year'];
                         
        // adiciona as c�lulas 
        $cell1 = $linha->addCell($row['id']);
        $cell2 = $linha->addCell($row['nome']);
        $cell3 = $linha->addCell($dt_nascimento);
        $cell4 = $linha->addCell($row['telefone']);
        $cell5 = $linha->addCell($row['email']);
        $cell6 = $linha->addCell($row['cidade']);
        
        // define o alinhamento das c�lulas
        $cell1->align = 'center';
        $cell2->align = 'left';
        $cell3->align = 'center';
        $cell4->align = 'left';
        $cell5->align = 'left';
        $cell6->align = 'left';
        
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