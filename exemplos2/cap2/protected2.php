<?php
# carrega as classes
require 'classes/Funcionario3.class.php';
require 'classes/Estagiario.class.php';

$pedrinho = new Estagiario;
$pedrinho->SetSalario(248);
echo 'O Salário do Pedrinho é R$: ' . $pedrinho->GetSalario() . "<br>\n";
?>