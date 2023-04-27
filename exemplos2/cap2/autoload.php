<?php
# Fun��o de carga auto�tica
function __autoload($classe)
{
    # Busca classe no diret�rio de classes...
    require_once "classes/{$classe}.class.php";
}

# Instanciando novo Produto
$produto1 = new Produto;

// atribuir valores
$produto1->Codigo = 4001;
$produto1->Descricao = 'CD - The Best of Eric Clapton';

// imprime informa��es de etiqueta
$produto1->ImprimeEtiqueta();
?>