<?php
# Carrega as classes
require_once 'classes/Pessoa2.class.php';
require_once 'classes/Conta2.class.php';

# Cria��o do objeto $carlos
$carlos = new Pessoa(10, "Carlos da Silva", 1.85, 25, "10/04/1976", "Ensino M�dio", 650.00);

echo "Manipulando o objeto {$carlos->Nome}: <br>\n";

echo "{$carlos->Nome} � formado em: {$carlos->Escolaridade} <br>\n";
$carlos->Formar('T�cnico em Eletricidade');
echo "{$carlos->Nome} � formado em: {$carlos->Escolaridade} <br>\n";

echo "{$carlos->Nome} possui {$carlos->Idade} anos <br>\n";
$carlos->Envelhecer(1);
echo "{$carlos->Nome} possui {$carlos->Idade} anos <br>\n";

# Cria��o do objeto $conta_carlos
$conta_carlos = new Conta(6677, "CC.1234.56", "10/07/02", $carlos, 9876, 567.89);

echo "<br>\n";
echo "Manipulando a conta de: {$conta_carlos->Titular->Nome}: <br>\n";

echo "O saldo atual � R\$ {$conta_carlos->ObterSaldo()} <br>\n";
$conta_carlos->Depositar(20);
echo "O saldo atual � R\$ {$conta_carlos->ObterSaldo()} <br>\n";
$conta_carlos->Retirar(10);
echo "O saldo atual � R\$ {$conta_carlos->ObterSaldo()} <br>\n";
?>