<?php
try
{
    // instancia objeto PDO, conectando no postgresql
    $conn = new PDO('pgsql:dbname=livro;user=postgres;password=;host=localhost');
    // executa uma instru��o SQL de consulta
    $result = $conn->query("SELECT codigo, nome from famosos");
    if ($result)
    {
        // percorre os resultados via itera��o
        foreach($result as $row)
        {
            // exibe os resultados
            echo $row['codigo'] . ' - ' .
                 $row['nome'] . "<br>\n";
        }
    }
    // fecha a conex�o
    $conn = null;
}
catch (PDOException $e)
{
    print "Erro!: " . $e->getMessage() . "<br/>";
}
?>