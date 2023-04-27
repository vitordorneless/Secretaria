<?php 
/** 
 * classe TTable 
 * respons�vel pela exibi��o de tabelas 
 */ 
class TTable extends TElement 
{ 
    /** 
     * m�todo construtor 
     * Instancia uma nova tabela 
     */ 
    public function __construct() 
    { 
        parent::__construct('table'); 
    } 

    /** 
     * m�todo addRow 
     * Agrega um novo objeto linha (TTableRow) na tabela 
     */ 
    public function addRow() 
    { 
        // instancia objeto linha 
        $row = new TTableRow; 
        // armazena no aray de linhas 
        parent::add($row); 
        return $row; 
    } 
} 
?>