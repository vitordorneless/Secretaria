<?php
class ContaCorrente extends Conta
{
    public $Limite;
    
    /* M�todo Construtor (Sobrescrito)
     * Agora, tamb�m inicializa a vari�vel $Limite
     */
    function __construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo, $Limite)
    {
        // chamada do m�todo construtor da classe pai.
        parent::__construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo);
        $this->Limite = $Limite;
    }
    
    /* M�todo Retirar (Sobrescrito)
     * Verifica se a $quantia retirada est� dentro do Limite.
     */
    function Retirar($quantia)
    {
        // imposto sobre movimenta��o financeira
        $cpmf = 0.05;
        
        if ( ($this->Saldo + $this->Limite) >= $quantia )
        {
            // Executa m�todo da classe pai.
            parent::Retirar($quantia);
            
            // Debita o Imposto
            parent::Retirar($quantia * $cpmf);
        }
        else
        {
            echo "Retirada n�o permitida... <br>\n";
            return false;
        }
        
        // retirada permitida
        return true;
    }
}
?>