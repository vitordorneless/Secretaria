<?php 
// Abre conexão com o Mysql 
$conn = mysql_connect('localhost', 'root', 'mysql'); 

// seleciona o banco de dados ativo 
mysql_select_db('livro', $conn); 

// Insere vários registros 
mysql_query("INSERT into famosos (codigo, nome) values (1, 'Érico Veríssimo')", $conn); 
mysql_query("INSERT into famosos (codigo, nome) values (2, 'John Lennon')",     $conn); 
mysql_query("INSERT into famosos (codigo, nome) values (3, 'Mahatma Gandhi')",  $conn); 
mysql_query("INSERT into famosos (codigo, nome) values (4, 'Ayrton Senna')",    $conn); 
mysql_query("INSERT into famosos (codigo, nome) values (5, 'Charlie Chaplin')", $conn); 
mysql_query("INSERT into famosos (codigo, nome) values (6, 'Anita Garibaldi')", $conn); 
mysql_query("INSERT into famosos (codigo, nome) values (7, 'Mário Quintana')",  $conn); 

// Fecha conexão 
mysql_close($conn);

echo "Dados inseridos na base de dados";
?>