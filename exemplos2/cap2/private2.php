<?php
# carrega a classe
require_once 'classes/Funcionario2.class.php';

// instancia novo Funcionario
$pedro = new Funcionario;

// atribui novo Sal�rio
$pedro->SetSalario(876);

// obt�m o Sal�rio
echo 'Sal�rio : (R$) ' . $pedro->GetSalario();
?>