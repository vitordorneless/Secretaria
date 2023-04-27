<?php
class ContaCorrente extends Conta
{
    public $Limite;
    
    /* Método Construtor (Sobrescrito)
     * Agora, também inicializa a variável $Limite
     */
    function __construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo, $Limite)
    {
        // chamada do método construtor da classe pai.
        parent::__construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo);
        $this->Limite = $Limite;
    }
    
    /* Método Retirar (Sobrescrito)
     * Verifica se a $quantia retirada está dentro do Limite.
     */
    function Retirar($quantia)
    {
        // imposto sobre movimentação financeira
        $cpmf = 0.05;
        
        if ( ($this->Saldo + $this->Limite) >= $quantia )
        {
            // Executa método da classe pai.
            parent::Retirar($quantia);
            
            // Debita o Imposto
            parent::Retirar($quantia * $cpmf);
        }
        else
        {
            echo "Retirada não permitida... <br>\n";
            return false;
        }
        
        // retirada permitida
        return true;
    }
}
?>