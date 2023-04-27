<?php 
// inclui classes necess�rias 
include_once 'app.widgets/TElement.class.php'; 
include_once 'app.widgets/TTable.class.php'; 
include_once 'app.widgets/TTableRow.class.php'; 
include_once 'app.widgets/TTableCell.class.php'; 

// constr�i matriz com os dados 
$dados[] = array(1, 'Maria do Ros�rio', 'http://www.maria.com.br',  1200); 
$dados[] = array(2, 'Pedro Cardoso',    'http://www.pedro.com.br',   800); 
$dados[] = array(3, 'Jo�o de Barro',    'http://www.joao.com.br',   1500); 
$dados[] = array(3, 'Joana Pereira',    'http://www.joana.com.br',   700); 
$dados[] = array(3, 'Erasmo Carlos',    'http://www.erasmo.com.br', 2500); 

// instancia objeto tabela 
$tabela = new TTable; 

// define algumas propriedades 
$tabela->width = 600; 
$tabela->border= 1; 

// instancia uma linha para o cabe�alho 
$cabecalho = $tabela->addRow(); 
// define a cor de fundo 
$cabecalho->bgcolor = '#a0a0a0'; // cor de fundo 

// adiciona c�lulas 
$cabecalho->addCell('C�digo'); 
$cabecalho->addCell('Nome'); 
$cabecalho->addCell('Site'); 
$cabecalho->addCell('Sal�rio'); 

$i = 0;
$total = 0;
// percorre os dados 
foreach ($dados as $pessoa) 
{ 
    // verifica qual cor ir� utilizar para o fundo 
    $bgcolor = ($i % 2) == 0 ? '#d0d0d0' : '#ffffff'; 
    
    // adiciona uma linha para os dados 
    $linha = $tabela->addRow(); 
    $linha->bgcolor = $bgcolor; 
    
    // adiciona as c�lulas 
    $linha->addCell($pessoa[0]); 
    $linha->addCell($pessoa[1]); 
    $linha->addCell($pessoa[2]); 
    $x = $linha->addCell($pessoa[3]); 
    $x->align = 'right'; 
    
    $total += $pessoa[3]; 
    $i++; 
} 

// instancia um alinha para o totalizador 
$linha = $tabela->addRow(); 

// adiciona c�lulas 
$celula= $linha->addCell('Total'); 
$celula->colspan = 3; 

$celula = $linha->addCell($total); 
$celula->bgcolor = "#a0a0a0"; 
$celula->align   = "right"; 

// exibe tabela 
$tabela->show(); 
?>