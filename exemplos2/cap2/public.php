<?php
# carrega as classes
require 'classes/Funcionario3.class.php';
require 'classes/Estagiario.class.php';

// cria objeto Funcionario
$pedrinho = new Funcionario;
$pedrinho->Nome = 'Pedrinho';

// cria objeto Estagiario
$mariana = new Estagiario;
$mariana->Nome = 'Mariana';

// imprime propriedade nome
echo $pedrinho->Nome . "<br>\n";
echo $mariana->Nome . "<br>\n";
?>