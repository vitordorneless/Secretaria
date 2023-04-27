<?php
class Conta
{
    public $Agencia;
    public $Codigo;
    public $DataDeCriacao;
    public $Titular;
    public $Senha;
    public $Saldo;
    public $Cancelada;
    
    /* Método Construtor
     * Inicializa propriedades
     */
    function __construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo)
    {
        $this->Agencia = $Agencia;
        $this->Codigo = $Codigo;
        $this->DataDeCriacao = $DataDeCriacao;
        $this->Titular = $Titular;
        $this->Senha = $Senha;
        
        // chamada a outro método da classe
        $this->Depositar($Saldo);
        $this->Cancelada = false;
    }
    
    /* Método Retirar
     * Diminui o Saldo em $quantia
     */
    function Retirar($quantia)
    {
        if ($quantia > 0)
        {
            $this->Saldo -= $quantia;
        }
    }
    
    /* Método Depositar
     * Aumenta o Saldo em $quantia
     */
    function Depositar($quantia)
    {
        if ($quantia > 0)
        {
            $this->Saldo += $quantia;
        }
    }
    
    /* Método ObterSaldo
     * Retorna o Saldo Atual
     */
    function ObterSaldo()
    {
        return $this->Saldo;
    }
    
    /* Método Destrutor
     * Finaliza Objeto
     */
    function __destruct()
    {
        echo "Objeto Conta {$this->Codigo} de {$this->Titular->Nome} finalizada... <br>\n";
    }
}
?>