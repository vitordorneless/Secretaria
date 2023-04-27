<?php
class Estagiario extends Funcionario
{
    /* Método GetSalario sobreescrito
     * Retorna o Salário com 12% de bônus.
     */
    function GetSalario()
    {
        return $this->Salario * 1.12;
    }
}
?>