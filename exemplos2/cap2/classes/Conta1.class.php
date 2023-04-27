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
    
    /* M�todo Retirar
     * Diminui o Saldo em $quantia
     */
    function Retirar($quantia)
    {
        if ($quantia > 0)
        {
            $this->Saldo -= $quantia;
        }
    }
    
    /* M�todo Depositar
     * Aumenta o Saldo em $quantia
     */
    function Depositar($quantia)
    {
        if ($quantia > 0)
        {
            $this->Saldo += $quantia;
        }
    }
    
    /* M�todo ObterSaldo
     * Retorna o Saldo Atual
     */
    function ObterSaldo()
    {
        return $this->Saldo;
    }
}
?>