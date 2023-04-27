<?php
// Abre conexão com o Mysql
$conn = mysql_connect('localhost', 'root', 'mysql');
// Seleciona o banco de dados ativo
mysql_select_db('livro', $conn);
// Define consulta que será realizada
$query = 'select codigo, nome from famosos';
// Envia consulta ao banco de dados
$result = mysql_query($query, $conn);
if ($result)
{
	 // Percorre resultados da pesquisa
	 while ($row = mysql_fetch_assoc($result))
	 {
		 echo $row['codigo'] . ' - ' . $row['nome'] . "<br>\n";
	 }
}
// Fecha conexão
mysql_close($conn);
?>