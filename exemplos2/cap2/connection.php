<?php 
/* 
 * função __autoload() 
 *  Carrega uma classe quando ela é necessária, 
 *  ou seja, quando ela é instancia pela primeira vez. 
 */ 
function __autoload($classe) 
{ 
    if (file_exists("app.ado/{$classe}.class.php")) 
    { 
        require_once "app.ado/{$classe}.class.php"; 
    } 
}

// define a consulta em SQL
$sql = "SELECT codigo, nome FROM famosos WHERE codigo=1";

try 
{ 
    // abre conexão com a base pg_livro (postgres) 
    $conn = TConnection::open('pg_livro'); 
    
    // executa a instrução SQL 
    $result = $conn->query($sql); 
    if ($result) 
    { 
        $row = $result->fetch(PDO::FETCH_ASSOC); 
        // exibe os dados resultantes 
        echo $row['codigo'] . ' - ' . $row['nome'] . "\n"; 
    } 
    // fecha a conexão 
    $conn = null; 
} 
catch (Exception $e) 
{ 
    // exibe a mensagem de erro 
    print "Erro!: " . $e->getMessage() . "<br/>";
} 
?>