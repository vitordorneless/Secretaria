<?php 
// Abre conex�o com Postgres 
$conn = pg_connect("host=localhost port=5432 dbname=livro user=postgres password="); 

// Insere v�rios registros 
pg_query($conn, "INSERT into famosos (codigo, nome) values (1, '�rico Ver�ssimo')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (2, 'John Lennon')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (3, 'Mahatma Gandhi')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (4, 'Ayrton Senna')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (5, 'Charlie Chaplin')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (6, 'Anita Garibaldi')"); 
pg_query($conn, "INSERT into famosos (codigo, nome) values (7, 'M�rio Quintana')"); 

// Fecha conex�o 
pg_close($conn);

echo "Dados inseridos na base de dados";
?>