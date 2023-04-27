<?php
/**
 * Classe NotaFiscalCompleta
 * Encapsula a gera��o de uma Nota Fiscal em PDF
 * @author Pablo Dall'Oglio <pablo@dalloglio.net>
 */
class NotaFiscalCompleta
{
    private $pdf;            // objeto PDF
    private $produtos;       // Vetor de Produtos
    private $data_emissao;   // Data de emiss�o
    private $data_saida;     // Data de sa�da
    private $hora_saida;     // Hora de sa�da
    private $total_produtos; // Valor total de produtos
    private $total_icms;     // Valor total de ICMS
    private $total_ipi;      // Valor total de IPI
    private $count_produtos; // Quantidade de produtos

    /**
     * M�todo construtor
     * Instancia o objeto FPDF
     */
    public function __construct($numero)
    {
        // Define o diret�rio das fontes
        define('FPDF_FONTPATH', getcwd() . '/app.util/pdf/font/');
        
        // Carrega a biblioteca FPDF
        include_once 'app.util/pdf/fpdf.php';
        
        // Cria um novo documento PDF
        $this->pdf = new FPDF('P', 'pt');
        $this->pdf->SetMargins(2,2,2); // define margins
        
        // Adiciona uma p�gina
        $this->pdf->AddPage();
        $this->pdf->Ln();
        
        $image  = 'header_nota.jpg';
        $size   = getimagesize($image);
        $width  = $size[0];
        $height = $size[1];
        
        // acrescenta a imagem de logo nestas coordenadas
        $this->pdf->Image($image, 0, 0, 300);
        
        // desenha um ret�ngulo para o n�mero da nota
        $this->pdf->SetLineWidth(1);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetFont('Arial','B',10);
        
        $this->pdf->SetXY(470, 27);
        $this->pdf->Cell(100, 20, 'NOTA FISCAL: ' . $numero, 1, 0, 'L');
        
        // inicializa vari�veis
        $this->total_produtos = 0;
        $this->total_icms = 0;
        $this->total_ipi = 0;
        $this->count_produtos = 0;
    }
    
    /**
     * Adiciona o cabe�alho da nota
     * @param $cfop C�digo fiscal da opera��o
     * @param $operacao Descri��o da opera��o
     * @param $cnpj C�digo do Cadastro Nacional de Pessoas Jur�dicas
     * @param $ie C�digo de Inscri��o Estadual
     */
    public function addCabecalhoNota($cfop, $operacao, $cnpj, $ie)
    {
        $this->pdf->SetY(100);
    
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(150, 12, 'Natureza da opera��o: ', 'LTR', 0, 'L');
        $this->pdf->Cell(50, 12, 'CFOP: ', 'LTR', 0, 'L');
        $this->pdf->Cell(125, 12, 'CNPJ: ', 'LTR', 0, 'L');
        $this->pdf->Cell(125, 12, 'IE: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(150, 16, $operacao, 'LBR', 0, 'L');
        $this->pdf->Cell(50,  16, $cfop, 'LBR', 0, 'L');
        $this->pdf->Cell(125, 16, $cnpj, 'LBR', 0, 'L');
        $this->pdf->Cell(125, 16, $ie, 'LBR', 0, 'L');
        
        $this->pdf->Ln(16);
    }

    /**
     * Atribui as datas e hor�rios
     * @param $data_emissao Data de emiss�o
     * @param $data_saida   Data de sa�da
     * @param $hora_saida   Hora de sa�da
     */
    public function setDatas($data_emissao, $data_saida, $hora_saida)
    {
        $this->data_emissao = $data_emissao;
        $this->data_saida   = $data_saida;
        $this->hora_saida   = $hora_saida;
    }

    /**
     * M�todo addCliente
     * Adiciona um cliente na nota
     * @param $cliente Objeto contendo os atributos do cliente
     */
    public function addCliente($cliente)
    {
        $this->pdf->SetY(130);
        
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'DESTINAT�RIO/REMETENTE: ', 0, 0, 'L');
        
        $this->pdf->Ln(12);
        
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'Nome/Raz�o Social: ', 'LTR', 0, 'L');
        $this->pdf->Cell(150, 12, 'CNPJ/CPF: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'Data de emiss�o: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 16, $cliente->nome, 'LBR', 0, 'L');
        $this->pdf->Cell(150, 16, $cliente->documento, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $this->data_emissao, 'LBR', 0, 'L');
        
        $this->pdf->Ln(16);
        
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(250, 12, 'Endere�o: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'Bairro: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'CEP: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'Data de sa�da: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(250, 16, $cliente->endereco, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $cliente->bairro, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $cliente->cep, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $this->data_saida, 'LBR', 0, 'L');
        
        $this->pdf->Ln(16);
        
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(200, 12, 'Munic�pio: ', 'LTR', 0, 'L');
        $this->pdf->Cell(50,  12, 'Fone/Fax: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'UF: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'Inscri��o Estadual: ', 'LTR', 0, 'L');
        $this->pdf->Cell(100, 12, 'Hora Sa�da: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(200, 16, $cliente->municipio, 'LBR', 0, 'L');
        $this->pdf->Cell(50,  16, $cliente->fone, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $cliente->uf, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $cliente->ie, 'LBR', 0, 'L');
        $this->pdf->Cell(100, 16, $this->hora_saida, 'LBR', 0, 'L');
        
        $this->pdf->Ln(16);
    }

    /**
     * Adiciona a linha de cabe�alho para os produtos
     */
    public function addCabecalhoProduto()
    {
        $this->pdf->SetY(220);
        
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'DADOS DO PRODUTO: ', 0, 0, 'L');
        
        $this->pdf->Ln(12);
        $this->pdf->SetX(20);
        $this->pdf->SetFillColor(230,230,230);
        $this->pdf->Cell(40,  12, 'C�digo',     1, 0, 'L', 1);
        $this->pdf->Cell(140, 12, 'Descri��o',  1, 0, 'L', 1);
        $this->pdf->Cell(30,  12, 'Classe',     1, 0, 'L', 1);
        $this->pdf->Cell(40,  12, 'Situa��o',   1, 0, 'L', 1);
        $this->pdf->Cell(40,  12, 'Unidade',    1, 0, 'L', 1);
        $this->pdf->Cell(45,  12, 'Quantidade', 1, 0, 'L', 1);
        $this->pdf->Cell(50,  12, 'Valor',      1, 0, 'L', 1);
        $this->pdf->Cell(55,  12, 'Total',      1, 0, 'L', 1);
        $this->pdf->Cell(30,  12, 'ICMS',       1, 0, 'L', 1);
        $this->pdf->Cell(30,  12, 'IPI',        1, 0, 'L', 1);
        $this->pdf->Cell(50,  12, 'Valor IPI',  1, 0, 'L', 1);
    }
    
    /**
     * Adiciona um produto na nota
     * @param $produto Objeto com os atributos do produto
     */
    public function addProduto($produto)
    {
        $this->pdf->Ln(12);
        $this->pdf->SetX(20);
        $this->pdf->SetFillColor(230,230,230);
        $total = $produto->valor * $produto->quantidade;
        
        $this->pdf->Cell(40,  12, $produto->codigo, 'LR', 0, 'C');
        $this->pdf->Cell(140, 12, $produto->descricao, 'LR', 0, 'L');
        $this->pdf->Cell(30,  12, $produto->classe, 'LR', 0, 'C');
        $this->pdf->Cell(40,  12, $produto->situacao, 'LR', 0, 'C');
        $this->pdf->Cell(40,  12, $produto->unidade, 'LR', 0, 'C');
        $this->pdf->Cell(45,  12, $produto->quantidade, 'LR', 0, 'C');
        $this->pdf->Cell(50,  12, number_format($produto->valor, 2), 'LR', 0, 'R');
        $this->pdf->Cell(55,  12, number_format($total, 2), 'LR', 0, 'R');
        $this->pdf->Cell(30,  12, $produto->icms, 'LR', 0, 'C');
        $this->pdf->Cell(30,  12, $produto->ipi, 'LR', 0, 'C');
        $this->pdf->Cell(50,  12, number_format($produto->ipi *
                                                $total / 100, 2), 'LR', 0, 'R');
        
        $this->total_produtos += $total;
        $this->total_icms     += ($produto->icms * $total / 100);
        $this->total_ipi      += ($produto->ipi * $total / 100);
        $this->count_produtos ++;
    }
    
    /**
     * Adiciona o rodap� ao final da lista de produtos
     * Este m�todo completa o espa�o da listagem
     */
    public function addRodapeProduto()
    {
        if ($this->count_produtos < 20)
        {
            for ($n=0; $n< 20-$this->count_produtos; $n++)
            {
                $this->pdf->Ln(12);
                $this->pdf->SetX(20);
                $this->pdf->Cell(40,  12, '', 'LR', 0, 'C');
                $this->pdf->Cell(140, 12, '', 'LR', 0, 'L');
                $this->pdf->Cell(30,  12, '', 'LR', 0, 'C');
                $this->pdf->Cell(40,  12, '', 'LR', 0, 'C');
                $this->pdf->Cell(40,  12, '', 'LR', 0, 'C');
                $this->pdf->Cell(45,  12, '', 'LR', 0, 'C');
                $this->pdf->Cell(50,  12, '', 'LR', 0, 'R');
                $this->pdf->Cell(55,  12, '', 'LR', 0, 'R');
                $this->pdf->Cell(30,  12, '', 'LR', 0, 'C');
                $this->pdf->Cell(30,  12, '', 'LR', 0, 'C');
                $this->pdf->Cell(50,  12, '', 'LR', 0, 'R');
            }
        }
        $this->pdf->Ln(12);
        $this->pdf->Line(20, $this->pdf->GetY(), 570, $this->pdf->GetY());
    }
    
    /**
     * Adiciona os totais da nota
     * @param $frete valor do frete
     * @param $seguro valor do seguro
     * @param $despesas valor das despesas
     */
    public function addTotaisNota($frete, $seguro, $despesas)
    {
        $this->pdf->Ln(4);
        
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'C�LCULO DO IMPOSTO: ', 0, 0, 'L');
        
        $this->pdf->Ln(12);
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(110, 12, 'Base c�lculo ICMS', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'Valor do ICMS: ', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'Base c�luclo ICMS subst: ', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'Valor do ICMS subs: ', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'Valor total dos produtos: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(110, 16, number_format($this->total_produtos, 2), 'LBR', 0, 'R');
        $this->pdf->Cell(110, 16, number_format($this->total_icms, 2), 'LBR', 0, 'R');
        $this->pdf->Cell(110, 16, 0, 'LBR', 0, 'R');
        $this->pdf->Cell(110, 16, 0, 'LBR', 0, 'R');
        $this->pdf->Cell(110, 16, number_format($this->total_produtos, 2), 'LBR', 0, 'R');
        
        $this->pdf->Ln(16);
        
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(110, 12, 'Valor do frete', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'Valor do seguro: ', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'Outras despesas: ', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'Valor do IPI: ', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'Valor total da nota: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $total_nota = $this->total_produtos + $frete + $seguro + $despesas;
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(110, 16, number_format($frete, 2), 'LBR', 0, 'R');
        $this->pdf->Cell(110, 16, number_format($seguro, 2), 'LBR', 0, 'R');
        $this->pdf->Cell(110, 16, number_format($despesas, 2), 'LBR', 0, 'R');
        $this->pdf->Cell(110, 16, number_format($this->total_ipi, 2), 'LBR', 0, 'R');
        $this->pdf->Cell(110, 16, number_format($total_nota, 2), 'LBR', 0, 'R');
    }

    /**
     * Adiciona os dados de transporte na nota
     * @param $transporte objeto com os dados de transporte como atributos
     */
    public function addDadosTransportadora($transporte)
    {
        $this->pdf->Ln(20);
        
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'TRANSPORTADOR/VOLUMES TRANSPORTADOS: ', 0, 0, 'L');
        
        $this->pdf->Ln(12);
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(240, 12, 'Nome/Raz�o Social', 'LTR', 0, 'L');
        $this->pdf->Cell(70, 12, 'Frete por conta: ', 'LTR', 0, 'L');
        $this->pdf->Cell(70, 12, 'Placa do ve�culo: ', 'LTR', 0, 'L');
        $this->pdf->Cell(60, 12, 'UF: ', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'CNPJ/MF: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(240, 16, $transporte->nome, 'LBR', 0, 'L');
        $this->pdf->Cell(70, 16, $transporte->conta, 'LBR', 0, 'L');
        $this->pdf->Cell(70, 16, $transporte->placa, 'LBR', 0, 'L');
        $this->pdf->Cell(60, 16, $transporte->uf_veic, 'LBR', 0, 'L');
        $this->pdf->Cell(110, 16, $transporte->cnpj, 'LBR', 0, 'L');
        
        $this->pdf->Ln(16);
        
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(240, 12, 'Endere�o', 'LTR', 0, 'L');
        $this->pdf->Cell(140, 12, 'Munic�pio: ', 'LTR', 0, 'L');
        $this->pdf->Cell(60, 12, 'UF: ', 'LTR', 0, 'L');
        $this->pdf->Cell(110, 12, 'IE: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(240, 16, $transporte->endereco, 'LBR', 0, 'L');
        $this->pdf->Cell(140, 16, $transporte->municipio, 'LBR', 0, 'L');
        $this->pdf->Cell(60, 16, $transporte->uf, 'LBR', 0, 'L');
        $this->pdf->Cell(110, 16, $transporte->ie, 'LBR', 0, 'L');
        
        $this->pdf->Ln(16);
        
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(92, 12, 'Quantidade', 'LTR', 0, 'L');
        $this->pdf->Cell(92, 12, 'Esp�cie: ', 'LTR', 0, 'L');
        $this->pdf->Cell(92, 12, 'Marca: ', 'LTR', 0, 'L');
        $this->pdf->Cell(92, 12, 'N�mero: ', 'LTR', 0, 'L');
        $this->pdf->Cell(92, 12, 'Peso bruto: ', 'LTR', 0, 'L');
        $this->pdf->Cell(90, 12, 'Peso l�quido: ', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(92, 16, $transporte->quantidade, 'LBR', 0, 'L');
        $this->pdf->Cell(92, 16, $transporte->especie, 'LBR', 0, 'L');
        $this->pdf->Cell(92, 16, $transporte->marca, 'LBR', 0, 'L');
        $this->pdf->Cell(92, 16, $transporte->numero, 'LBR', 0, 'L');
        $this->pdf->Cell(92, 16, number_format($transporte->peso_bruto, 2), 'LBR', 0, 'R');
        $this->pdf->Cell(90, 16, number_format($transporte->peso_liquido, 2), 'LBR', 0, 'R');
    }
    
    /**
     * Adiciona o rodap� da nota
     * @param $razao raz�o social
     */
    public function addRodapeNota($razao)
    {
        $this->pdf->Ln(20);
        
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'DADOS ADICIONAIS: ', 0, 0, 'L');
        
        $this->pdf->Ln(12);
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(280, 12, 'Informa��es complementares', 'LTR', 0, 'L');
        $this->pdf->Cell(270, 12, 'Reservado ao fisco', 'LTR', 0, 'L');
        
        $this->pdf->Ln(8);
        
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetX(20);
        $this->pdf->Cell(280, 48, '', 'LBR', 0, 'L');
        $this->pdf->Cell(270, 48, '', 'LBR', 0, 'L');
        
        $this->pdf->Ln(52);
        
        $this->pdf->SetX(20);
        $this->pdf->Cell(300, 12, 'INFORMA��ES DE RECEBIMENTO: ', 0, 0, 'L');
        
        $this->pdf->Ln(12);
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->SetX(20);
        $this->pdf->Cell(400, 12, 'Recebemos de '.$razao.' os produtos constantes na nota fiscal indicada ao lado', 'LTR', 0, 'L');
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->Cell(150, 12, 'NOTA FISCAL', 'LTR', 0, 'C');
        
        $this->pdf->Ln(12);
        
        $this->pdf->SetX(20);
        $this->pdf->SetTextColor(100,100,100);
        $this->pdf->Cell(200, 12, 'Data do recebimento', 'LTR', 0, 'L');
        $this->pdf->Cell(200, 12, 'Identifica��o e assinatura do recebedor', 'LTR', 0, 'L');
        $this->pdf->Cell(150, 12, '', 'LR', 0, 'L');
        
        $this->pdf->Ln(8);
        $this->pdf->SetX(20);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->Cell(200, 30, '', 'LBR', 0, 'L');
        $this->pdf->Cell(200, 30, '', 'LBR', 0, 'L');
        $this->pdf->Cell(150, 30, '', 'LBR', 0, 'L');
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