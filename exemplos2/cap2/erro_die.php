<?php
function Abrir($file = null)
{
    if (!$file)
    {
        die('Falta o par�metro com o nome do Arquivo');
    }
    if (!file_exists($file))
    {
        die('Arquivo n�o existente');
    }
    if (!$retorno = @file_get_contents($file))
    {
        die('Imposs�vel ler o arquivo');
    }
    return $retorno;
}

// abrindo um arquivo
$arquivo = Abrir('/tmp/arquivo.dat');
echo $arquivo;
?>