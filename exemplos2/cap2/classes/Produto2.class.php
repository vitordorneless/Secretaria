<?php
class Produto
{
    public $Codigo;
    public $Descricao;
    public $Preco;
    public $Quantidade;
    
    function ImprimeEtiqueta()
    {
        print 'C�digo:    ' . $this->Codigo . "<br>\n";
        print 'Descri��o: ' . $this->Descricao . "<br>\n";
    }
}
?>