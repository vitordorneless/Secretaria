<?php
class Funcionario
{
    private $Codigo;
    public  $Nome;
    private $Nascimento;
    private $Salario;
    
    /* M�todo SetSalario
     * Atribui o Par�metro Salario � propriedade Salario
     */
    function SetSalario($Salario)
    {
        // verifica se � num�rico e positivo
        if (is_numeric($Salario) and ($Salario > 0))
        {
            $this->Salario = $Salario;
        }
    }
    
    /* M�todo GetSalario
     * Retorna o valor da propriedade Salario
     */
    function GetSalario()
    {
        return $this->Salario;
    }
}
?>