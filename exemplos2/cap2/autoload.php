<?php
# Função de carga autoática
function __autoload($classe)
{
    # Busca classe no diretório de classes...
    require_once "classes/{$classe}.class.php";
}

# Instanciando novo Produto
$produto1 = new Produto;

// atribuir valores
$produto1->Codigo = 4001;
$produto1->Descricao = 'CD - The Best of Eric Clapton';

// imprime informações de etiqueta
$produto1->ImprimeEtiqueta();
?>