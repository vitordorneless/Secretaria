<?php
class ContaPoupanca extends Conta
{
    public $Aniversario;
    
    /* Método Construtor (Sobrescrito)
     * Agora, também inicializa a variável $Aniversario
     */
    function __construct($Agencia, $Codigo, $DataDeCriacao,
                         $Titular, $Senha, $Saldo, $Aniversario)
    {
        // chamada do método construtor da classe pai.
        parent::__construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo);
        $this->Aniversario = $Aniversario;
    }
    
    /* Método Retirar (Sobrescrito)
     * Verifica se há Saldo para Retirar tal $quantia.
     */
    function Retirar($quantia)
    {
        if ($this->Saldo >= $quantia)
        {
            // Executa método da classe pai.
            parent::Retirar($quantia);
        }
        else
        {
            echo "Retirada não permitida...<br>\n";
            return false;
        }
        
        // retirada permitida
        return true;
    }
}
?>