<?php
# carrega a classe
require_once 'classes/Funcionario2.class.php';

// instancia novo Funcionario
$pedro = new Funcionario;

// atribui novo Salário
$pedro->SetSalario(876);

// obtém o Salário
echo 'Salário : (R$) ' . $pedro->GetSalario();
?>