<?php
class Estagiario extends Funcionario
{
    /* M�todo GetSalario sobreescrito
     * Retorna o Sal�rio com 12% de b�nus.
     */
    function GetSalario()
    {
        return $this->Salario * 1.12;
    }
}
?>