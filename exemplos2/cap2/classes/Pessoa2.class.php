<?php
class Pessoa
{
    public $Codigo;
    public $Nome;
    public $Altura;
    public $Idade;
    public $Nascimento;
    public $Escolaridade;
    public $Salario;
    
    /* M�todo Construtor
     * Inicializa propriedades
     */
    function __construct($Codigo, $Nome, $Altura, $Idade, $Nascimento, $Escolaridade, $Salario)
    {
        $this->Codigo = $Codigo;
        $this->Nome = $Nome;
        $this->Altura = $Altura;
        $this->Idade = $Idade;
        $this->Nascimento = $Nascimento;
        $this->Escolaridade = $Escolaridade;
        $this->Salario = $Salario;
    }
    
    /* M�todo Crescer
     * Aumenta a altura em $centimetros
     */
    function Crescer($centimetros)
    {
        if ($centimetros > 0)
        {
            $this->Altura += $centimetros;
        }
    }
    
    /* M�todo Formar
     * Altera a Escolaridade para $titulacao
     */
    function Formar($titulacao)
    {
        $this->Escolaridade = $titulacao;
    }
    
    /* M�todo Envelhecer
     * Aumenta a Idade em $anos
     */
    function Envelhecer($anos)
    {
        if ($anos > 0)
        {
            $this->Idade += $anos;
        }
    }
    
    /* M�todo Destrutor
     * Finaliza Objeto
     */
    function __destruct()
    {
        echo "Objeto {$this->Nome} finalizado...<br>\n";
    }
}
?>