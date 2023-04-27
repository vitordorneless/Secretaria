<?php
function Abrir($file = null)
{
    if (!$file)
    {
        throw new Exception('Falta o parâmetro com o nome do Arquivo');
    }
    if (!file_exists($file))
    {
        throw new Exception('Arquivo não existente');
    }
    if (!$retorno = @file_get_contents($file))
    {
        throw new Exception('Impossível ler o arquivo');
    }
    return $retorno;
}

try // inicia tratamento de exceções
{
    // abrindo um arquivo
    $arquivo = Abrir('/tmp/arquivo.dat');
    echo $arquivo;
}
catch (Exception $excessao) // captura a exceção
{
    echo $excessao->getFile() . ' : ' . $excessao->getLine() . ' # ' . $excessao->getMessage();
}
?>