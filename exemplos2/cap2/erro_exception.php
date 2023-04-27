<?php
function Abrir($file = null)
{
    if (!$file)
    {
        throw new Exception('Falta o par�metro com o nome do Arquivo');
    }
    if (!file_exists($file))
    {
        throw new Exception('Arquivo n�o existente');
    }
    if (!$retorno = @file_get_contents($file))
    {
        throw new Exception('Imposs�vel ler o arquivo');
    }
    return $retorno;
}

try // inicia tratamento de exce��es
{
    // abrindo um arquivo
    $arquivo = Abrir('/tmp/arquivo.dat');
    echo $arquivo;
}
catch (Exception $excessao) // captura a exce��o
{
    echo $excessao->getFile() . ' : ' . $excessao->getLine() . ' # ' . $excessao->getMessage();
}
?>