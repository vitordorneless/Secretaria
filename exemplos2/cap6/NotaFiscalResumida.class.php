<?php
/**
 * Classe NotaFiscalResumida
 * Encapsula a gera��o de uma Nota Fiscal em PDF
 */
class NotaFiscalResumida
{
    private $pdf;            // objeto PDF
    private $produtos;       // Vetor de Produtos
    private $total_produtos; // Valor total de produtos
    private $count_produtos; // Quantidade de produtos

    /**
     * M�todo construtor
     * Instancia o objeto FPDF
     * @param $numero numero da nota fiscal
     * @param $data data de emiss�o
     */
    public function __construct($numero, $data)
    {
        // Define o diret�rio das fontes
        define('FPDF_FONTPATH', getcwd() . '/app.util/pdf/font/');
        
        // Carrega a biblioteca FPDF
        include_once 'app.util/pdf/fpdf.php';
        
        // Cria um novo documento PDF
        $this->pdf = new FPDF('P', 'pt');
        $this->pdf->SetMargins(2,2,2); // define margens
        
        // Adiciona uma p�gina
        $this->pdf->AddPage();
        $this->pdf->Ln();
        
        // acrescenta a imagem de logo nestas coordenadas
        $image  = 'header_nota.jpg';
        $this->pdf->Image($image, 0, 0, 300);
        
        // desenha um ret�ngulo para o n�mero da nota
        $this->pdf->SetLineWidth(1);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetFont('Arial','B',10);
        
        $this->pdf->SetXY(370, 27);
        $this->pdf->Cell(100, 20, 'Nota fiscal: ' . $numero, 1, 0, 'L');
        $this->pdf->SetXY(370, 47);
        $this->pdf->Cell(100, 20, 'Data: ' . $data, 1, 0, 'L');
        
        // inicializa vari�veis
        $this->total_produtos = 0;
        $this->count_produtos = 0;
    }

    /**
     * M�todo addCliente
     * Adiciona um cliente na nota
     * @param $cliente Objeto contendo os atributos do cliente
     */
    public function addCliente($cliente)
    {
        $this->pdf->SetY(100);
        
        // exibe o t�tulo da se��o
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'DADOS DO CLIENTE: ', 0, 0, 'L');
        
        $this->pdf->Ln(12);
        
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'Nome/Raz�o Social: ', 'LTR', 0, 'L');
        $this->pdf->Cell(150, 12, 'CNPJ/CPF: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 16, $cliente->nome, 'LBR', 0, 'L');
        $this->pdf->Cell(150, 16, $cliente->cpf_cnpj, 'LBR', 0, 'L');
        
        $this->pdf->Ln(16);
        
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(250, 12, 'Endere�o: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'Bairro: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'CEP: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(250, 16, $cliente->endereco, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $cliente->bairro, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $cliente->cep, 'LBR', 0, 'L');
        
        $this->pdf->Ln(16);
        
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(150, 12, 'Munic�pio: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'Fone/Fax: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'UF: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'Inscri��o Estadual: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(150, 16, $cliente->municipio, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $cliente->telefone, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $cliente->estado, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $cliente->rg_ie, 'LBR', 0, 'L');
        
        $this->pdf->Ln(16);
    }

    /**
     * Adiciona a linha de cabe�alho para os produtos
     */
    public function addCabecalhoProduto()
    {
        $this->pdf->SetY(190);
        
        // exibe o t�tulo da se��o
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'DADOS DOS PRODUTOS: ', 0, 0, 'L');
        
        // exibe os t�tulos das colunas
        $this->pdf->Ln(12);
        $this->pdf->SetX(20);
        $this->pdf->SetFillColor(230,230,230);
        $this->pdf->Cell(50,  12, 'C�digo',     1, 0, 'C', 1);
        $this->pdf->Cell(200, 12, 'Descri��o',  1, 0, 'L', 1);
        $this->pdf->Cell(50,  12, 'Unidade',    1, 0, 'C', 1);
        $this->pdf->Cell(50,  12, 'Quantidade', 1, 0, 'C', 1);
        $this->pdf->Cell(50,  12, 'Valor',      1, 0, 'R', 1);
        $this->pdf->Cell(50,  12, 'Total',      1, 0, 'R', 1);
    }
    
    /**
     * Adiciona um produto na nota
     * @param $produto Objeto com os atributos do produto
     */
    public function addProduto($produto)
    {
        $this->pdf->Ln(12);
        $this->pdf->SetX(20);
        $total = $produto->valor * $produto->quantidade;
        
        $this->pdf->Cell(50,  12, $produto->id, 'LR', 0, 'C');
        $this->pdf->Cell(200, 12, $produto->descricao, 'LR', 0, 'L');
        $this->pdf->Cell(50,  12, $produto->unidade, 'LR', 0, 'C');
        $this->pdf->Cell(50,  12, $produto->quantidade, 'LR', 0, 'C');
        $this->pdf->Cell(50,  12, number_format($produto->valor, 2), 'LR', 0, 'R');
        $this->pdf->Cell(50,  12, number_format($total, 2), 'LR', 0, 'R');
        
        $this->total_produtos += $total;
        $this->count_produtos ++;
    }
    
    /**
     * Adiciona o rodap� ao final da lista de produtos
     * Este m�todo completa o espa�o da listagem
     */
    public function addRodapeProduto()
    {
        if ($this->count_produtos < 10)
        {
            for ($n=0; $n< 10-$this->count_produtos; $n++)
            {
                $this->pdf->Ln(12);
                $this->pdf->SetX(20);
                $this->pdf->Cell(50,  12, '', 'LR', 0, 'C');
                $this->pdf->Cell(200, 12, '', 'LR', 0, 'L');
                $this->pdf->Cell(50,  12, '', 'LR', 0, 'C');
                $this->pdf->Cell(50,  12, '', 'LR', 0, 'C');
                $this->pdf->Cell(50,  12, '', 'LR', 0, 'R');
                $this->pdf->Cell(50,  12, '', 'LR', 0, 'R');
            }
        }
        $this->pdf->Ln(12);
        $this->pdf->Line(20, $this->pdf->GetY(), 470, $this->pdf->GetY());
    }
    
    /**
     * Adiciona o rodap� da nota
     */
    public function addRodapeNota()
    {
        $this->pdf->Ln(4);
        
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'TOTAIS DA NOTA: ', 0, 0, 'L');
        
        $this->pdf->Ln(12);
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(340, 12, 'Informa��es complementares:', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'Valor total dos produtos: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(340, 16, '', 'LBR', 0, 'R');
        $this->pdf->Cell(110, 16, number_format($this->total_produtos, 2), 'LBR', 0, 'R');
    }
    
    /**
     * Salva a nota fiscal em um arquivo
     * @param $arquivo localiza��o do arquivo de sa�da
     */
    public function gerar($arquivo)
    {
        // salva o PDF
        $this->pdf->Output($arquivo);
    }
}
?>
