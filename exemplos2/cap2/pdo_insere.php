<?php
try
{
    // instancia objeto PDO, conectando no postgresql
    $conn = new PDO('pgsql:dbname=livro;user=postgres;password=;host=localhost');
    // executa uma série de instruções SQL
    $conn->exec("INSERT into famosos (codigo, nome) values (1, 'Érico Veríssimo')");
    $conn->exec("INSERT into famosos (codigo, nome) values (2, 'John Lennon')");
    $conn->exec("INSERT into famosos (codigo, nome) values (3, 'Mahatma Gandhi')");
    $conn->exec("INSERT into famosos (codigo, nome) values (4, 'Ayrton Senna')");
    $conn->exec("INSERT into famosos (codigo, nome) values (5, 'Charlie Chaplin')");
    $conn->exec("INSERT into famosos (codigo, nome) values (6, 'Anita Garibaldi')");
    $conn->exec("INSERT into famosos (codigo, nome) values (7, 'Mário Quintana')");
    // fecha a conexão
    $conn = null;
    
    echo "Dados inseridos na base de dados";
}
catch (PDOException $e)
{
    // caso ocorra uma exceção, exibe na tela
    print "Erro!: " . $e->getMessage() . "\n";
}
?>