<?php
# carrega as classes
require 'classes/Funcionario3.class.php';
require 'classes/Estagiario.class.php';

$pedrinho = new Estagiario;
$pedrinho->SetSalario(248);
echo 'O Sal�rio do Pedrinho � R$: ' . $pedrinho->GetSalario() . "<br>\n";
?>