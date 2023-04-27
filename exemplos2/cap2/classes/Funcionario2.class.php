<?php
class Funcionario
{
    private $Codigo;
    public  $Nome;
    private $Nascimento;
    private $Salario;
    
    /* Método SetSalario
     * Atribui o Parâmetro Salario à propriedade Salario
     */
    function SetSalario($Salario)
    {
        // verifica se é numérico e positivo
        if (is_numeric($Salario) and ($Salario > 0))
        {
            $this->Salario = $Salario;
        }
    }
    
    /* Método GetSalario
     * Retorna o valor da propriedade Salario
     */
    function GetSalario()
    {
        return $this->Salario;
    }
}
?>