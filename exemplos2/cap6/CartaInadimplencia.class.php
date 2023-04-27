<?php
/**
 * Classe CartaInadimplencia
 * Encapsula a geração de uma carta de inadimplência
 */
class CartaInadimplencia
{
    private $rtf;
    private $tabela;
    private $secao;
    private $colore;
    private $total;
    private $row;
    
    /**
     * Método construtor
     * Instancia o objeto PHPRtfLite
     */
    public function __construct()
    {
        // inclui a classe Rtf
        require 'app.util/rtf/PHPRtfLite.php';
        
        // registra o class loader
        PHPRtfLite::registerAutoloader();
        
        // instancia a classe Rtf
        $this->rtf = new PHPRtfLite;
        
        // adiciona uma seção ao documento
        $this->secao = $this->rtf->addSection();
    }
    
    /**
     * Adiciona um título ao documento
     * @param $title título da carta
     */
    public function addTitulo($title)
    {
        // escreve o tí­tulo em Arial 16 negrito, sublinhado e centralizado
        $this->secao->writeText("<b><u>{$title}</b></u>",
                                new PHPRtfLite_Font(16, 'Arial'),
                                new PHPRtfLite_ParFormat('center'));
    }
    
    /**
     * Adiciona um texto à carta
     * @param $body texto da carta
     */
    public function addTexto($texto, $substituicoes)
    {
        $paragrafo = new PHPRtfLite_ParFormat('justify');
        $paragrafo->setIndentFirstLine(1);
        $paragrafo->setSpaceBefore(1);
        $paragrafo->setSpaceAfter(1);
        
        if ($substituicoes)
        {
            foreach ($substituicoes as $chave => $conteudo)
            {
                $texto = str_replace('$' . $chave, $conteudo, $texto);
            }
        }
        $this->secao->writeText($texto, new PHPRtfLite_Font(10, 'Verdana'), $paragrafo);
    }
    
    /**
     * Adiciona a tabela de detalhamento
     * @param $titulos títulos das colunas da tabela
     * @param $larguras larguras dos títulos
     */
    public function addTabela($titulos, $larguras)
    {
        // adiciona a tabela
        $this->tabela = $this->secao->addTable();
        
        // fonte do título
        $fonte_tit   = new PHPRtfLite_Font(10, 'Arial', '#000000');
        $fonte_tit->setBold(TRUE);
        
        // cria o cabeçalho da tabela
        $i = 1;
        $this->tabela->addRow(0.5);
        foreach ($titulos as $titulo)
        {
            $this->tabela->addColumn($larguras[$i -1]);
            $this->tabela->writeToCell(1, $i, $titulo, $fonte_tit, new PHPRtfLite_ParFormat('center'));
            $i++;
        }
        // define a cor de fundo da linha 1
        $this->tabela->setBackgroundForCellRange('#ffff88', 1, 1, 1, $this->tabela->getColumnsCount());
        
        // variável de controle para cor de fundo das linhas
        $this->colore = FALSE;
        
        // linha atual da tabela
        $this->row = 2;
        
        // variável de totalização
        $this->total = 0;
    }
    
    /**
     * Adiciona uma linha de detalhamento
     * @param $detalhe objeto contendo o detalhamento
     */
    public function addDetalhe($detalhe)
    {
        // define a fonte para os dados da tabela
        $fonte_dados = new PHPRtfLite_Font(10, 'Arial', '#000000');
        
        // adiciona uma linha à tabela
        $this->tabela->addRow(0.5);
        
        // alterna a cor de fundo da linha de dados
        $color = $this->colore ? '#dedede' : '#ffffff';
        
        $this->tabela->setBackgroundForCellRange($color, $this->row, 1, $this->row,
                                                 $this->tabela->getColumnsCount());
        // calcula o total do item
        $total = $detalhe->quantidade * $detalhe->valor;
        
        $this->tabela->writeToCell($this->row, 1, $detalhe->dt_venda,
                                   $fonte_dados, new PHPRtfLite_ParFormat('center'));
        $this->tabela->writeToCell($this->row, 2, $detalhe->descricao,
                                   $fonte_dados, new PHPRtfLite_ParFormat('left'));
        $this->tabela->writeToCell($this->row, 3, $detalhe->quantidade,
                                   $fonte_dados, new PHPRtfLite_ParFormat('center'));
        $this->tabela->writeToCell($this->row, 4, number_format($detalhe->valor, 2, ',', '.'),
                                   $fonte_dados, new PHPRtfLite_ParFormat('right'));
        $this->tabela->writeToCell($this->row, 5, number_format($total, 2, ',', '.'),
                                   $fonte_dados, new PHPRtfLite_ParFormat('right'));
        
        $this->colore =! $this->colore; // inverte cor de fundo
        $this->total += $total;
        $this->row ++;
    }
    
    /**
     * Adiciona uma linha de totalização
     */
    public function addTotal()
    {
        // define a fonte para os dados da tabela
        $fonte_total = new PHPRtfLite_Font(10, 'Arial', '#000000');
        $fonte_total->setBold(TRUE);
        
        // adiciona linha com totais
        $this->tabela->addRow(0.5);
        $this->tabela->mergeCellRange($this->row, 1, $this->row, 4);
        $this->tabela->writeToCell($this->row, 1, 'Total',
                                   $fonte_total, new PHPRtfLite_ParFormat('left'));
        $this->tabela->writeToCell($this->row, 5, number_format($this->total, 2, ',', '.'),
                                   $fonte_total, new PHPRtfLite_ParFormat('right'));
        
        // define cor de fundo da última linha
        $this->tabela->setBackgroundForCellRange('#a0a0a0', $this->row, 1,
                                                 $this->row, $this->tabela->getColumnsCount());
        
        // define bordas para toda a tabela
        $this->tabela->setBorderForCellRange(PHPRtfLite_Border::create(0.7, '#000000'), 1, 1,
                                             $this->tabela->getRowsCount(), $this->tabela->getColumnsCount());
    }
    
    /**
     * Salvar o arquivo RTF
     * @param $filename localização do arquivo
     */
    public function gerar($filename)
    {
        $this->rtf->save($filename);
    }
}
?>