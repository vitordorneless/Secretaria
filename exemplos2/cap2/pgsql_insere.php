<?php 
// Abre conexão com Postgres 
$conn = pg_connect("host=localhost port=5432 dbname=livro user=postgres password="); 

// Insere vários registros 
pg_query($conn, "INSERT into famosos (codigo, nome) values (1, 'Érico Veríssimo')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (2, 'John Lennon')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (3, 'Mahatma Gandhi')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (4, 'Ayrton Senna')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (5, 'Charlie Chaplin')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (6, 'Anita Garibaldi')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (7, 'Mário Quintana')"); 

// Fecha conexão 
pg_close($conn);

echo "Dados inseridos na base de dados";
?>