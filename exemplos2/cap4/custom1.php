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
    
    // define os r�tulos das colunas
    $label = array();
    $label['pessoa.id']            = 'C�digo';
    $label['pessoa.nome']          = 'Nome';
    $label['pessoa.sexo']          = 'Sexo';
    $label['pessoa.dt_nascimento'] = 'Nascimento';
    $label['pessoa.telefone']      = 'Telefone';
    $label['pessoa.email']         = 'Email';
    $label['cidade.id']            = 'Cidade';
    $label['cidade.nome']          =' Nome Cidade';
    
    // define os alinhamentos das colunas
    $align = array();
    $align['pessoa.id']            = 'left';
    $align['pessoa.nome']          = 'left';
    $align['pessoa.sexo']          = 'left';
    $align['pessoa.dt_nascimento'] = 'left';
    $align['pessoa.telefone']      = 'left';
    $align['pessoa.email']         = 'left';
    $align['cidade.id']            = 'left';
    $align['cidade.nome']          =' left';
    
    $select = array();
    // forma as colunas para o SELECT
    if ($_REQUEST['colunas'])
    {
        foreach ($_REQUEST['colunas'] as $coluna)
        {
            $select[] = "{$coluna} as \"{$coluna}\"";
        }
    }
    
    // define a consulta
    $sql = 'SELECT '. implode(',', $select).
           ' FROM pessoa, cidade' .
           ' WHERE pessoa.id_cidade=cidade.id ';
    
    
    if (!empty($_REQUEST['cidade'])) // detecta filtro por nome da cidade
    {
        $cidade = addslashes(strtoupper($_REQUEST['cidade'])); 
        $sql .= " AND cidade.nome like '%{$cidade}%'";
    }
    
    if (!empty($_REQUEST['pessoa'])) // detecta filtro por nome da pessoa
    {
        $pessoa = addslashes(strtoupper($_REQUEST['pessoa']));
        $sql .= " AND pessoa.nome like '%{$pessoa}%'";
    }
    
    if (!empty($_REQUEST['sexo'])) // detecta filtro por sexo
    {
        $sexo = addslashes($_REQUEST['sexo']);
        $sql .= " AND pessoa.sexo ='{$sexo}'";
    }
    
    if (!empty($_REQUEST['estado'])) // detecta filtro por estado
    {
        $estado = addslashes($_REQUEST['estado']);
        $sql .= " AND cidade.estado ='{$estado}'";
    }
    
    $sql .= ' ORDER BY ' . $_REQUEST['ordem'];
    
    
    $result = $conn->query($sql); // executa a instru��o SQL
    
    $tabela = new TTable; // instancia objeto tabela 
    // define algumas propriedades da tabela
    $tabela->width = 730; 
    $tabela->border= 1;
    $tabela->style = "border-collapse:collapse";
    
    // instancia uma linha para o cabe�alho 
    $cabecalho = $tabela->addRow(); 
    
    // adiciona c�lulas de t�tulo das colunas
    foreach ($_REQUEST['colunas'] as $coluna)
    {
        // obt�m o t�tulo da coluna
        $titulo = $label[$coluna];
        $cabecalho->addCell($titulo); 
    }
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
                         
        // adiciona as c�lulas contendo os dados do relat�rio
        foreach ($_REQUEST['colunas'] as $coluna)
        {
            $dado = $row[$coluna];
            $cell = $linha->addCell($dado);
            // define o alinhamento da coluna
            $cell->align = $align[$coluna];
        }
        
        // inverte cor de fundo
        $colore = !$colore;
    }
    // exibe a tabela contendo o relat�rio
    $tabela->show();
} 
catch (Exception $e) 
{ 
    // exibe a mensagem de erro 
    echo $e->getMessage(); 
} 
?>