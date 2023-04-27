<?php
// Abre conex�o com Postgres
$conn = pg_connect("host=localhost port=5432 dbname=livro user=postgres password=");

// Define consulta que ser� realizada
$query = 'select codigo, nome from famosos';

// Envia consulta ao banco de dados
$result = pg_query($conn, $query);

if ($result)
{
    // percorre resultados da pesquisa
    while ($row = pg_fetch_assoc($result))
    {
        echo $row['codigo'] . ' - ' . $row['nome'] . "<br>\n";
    }
}
// Fecha conex�o
pg_close($conn);
?>