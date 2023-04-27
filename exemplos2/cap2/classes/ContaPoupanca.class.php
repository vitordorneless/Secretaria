<?php
class ContaPoupanca extends Conta
{
    public $Aniversario;
    
    /* M�todo Construtor (Sobrescrito)
     * Agora, tamb�m inicializa a vari�vel $Aniversario
     */
    function __construct($Agencia, $Codigo, $DataDeCriacao,
                         $Titular, $Senha, $Saldo, $Aniversario)
    {
        // chamada do m�todo construtor da classe pai.
        parent::__construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo);
        $this->Aniversario = $Aniversario;
    }
    
    /* M�todo Retirar (Sobrescrito)
     * Verifica se h� Saldo para Retirar tal $quantia.
     */
    function Retirar($quantia)
    {
        if ($this->Saldo >= $quantia)
        {
            // Executa m�todo da classe pai.
            parent::Retirar($quantia);
        }
        else
        {
            echo "Retirada n�o permitida...<br>\n";
            return false;
        }
        
        // retirada permitida
        return true;
    }
}
?>