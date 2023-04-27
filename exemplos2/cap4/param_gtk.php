<?php
/**
 * função __autoload() 
 *  Carrega uma classe quando ela é necessária, 
 *  ou seja, quando ela é instancia pela primeira vez. 
 */ 
function __autoload($classe) 
{ 
    if (file_exists("app.ado/{$classe}.class.php")) 
    { 
        include_once "app.ado/{$classe}.class.php"; 
    } 
} 

/**
 * Exemplo de janela Gtk para
 * geração de relatório
 */
class ExemploParametro extends GtkWindow
{
    private $produto;
    private $fabricante;
    private $estoquemin;
    private $estoquemax;
    
    /**
     * Método construtor
     */
    public function __construct()
    {
        // excuta o método construtor e define características da janela
        parent::__construct();
        parent::set_title('Relatório de produtos');
        parent::connect_simple('destroy', array('Gtk', 'main_quit'));
        parent::set_default_size(400,-1);
        parent::set_border_width(10);
        parent::set_position(GTK::WIN_POS_CENTER);
        
        // cria uma caixa vertical para dispor o layout
        $vbox = new GtkVBox;
        
        // cria os rótulos dos campos
        $label_produto    = new GtkLabel('Produto');
        $label_fabricante = new GtkLabel('Fabricante');
        $label_estoquemin = new GtkLabel('Estoque Minimo');
        $label_estoquemax = new GtkLabel('Estoque Máximo');
        
        // define a largura dos rótulos
        $label_produto->set_size_request(200,-1);
        $label_fabricante->set_size_request(200,-1);
        $label_estoquemin->set_size_request(200,-1);
        $label_estoquemax->set_size_request(200,-1);
        
        // cria os campos de entrada de dados
        $this->produto    = new GtkEntry;
        $this->fabricante = new GtkEntry;
        $this->estoquemin = new GtkEntry;
        $this->estoquemax = new GtkEntry;
        
        // adiciona uma caixa com os campos para produto
        $hbox = new GtkHBox;
        $hbox->pack_start($label_produto, false, false);
        $hbox->pack_start($this->produto, false, false);
        $vbox->pack_start($hbox, false, false);
        
        // adiciona uma caixa com os campos para fabricante
        $hbox = new GtkHBox;
        $hbox->pack_start($label_fabricante, false, false);
        $hbox->pack_start($this->fabricante, false, false);
        $vbox->pack_start($hbox, false, false);
        
        // adiciona uma caixa com os campos para estoque mínimo
        $hbox = new GtkHBox;
        $hbox->pack_start($label_estoquemin, false, false);
        $hbox->pack_start($this->estoquemin, false, false);
        $vbox->pack_start($hbox, false, false);
        
        // adiciona uma caixa com os campos para estoque máximo
        $hbox = new GtkHBox;
        $hbox->pack_start($label_estoquemax, false, false);
        $hbox->pack_start($this->estoquemax, false, false);
        $vbox->pack_start($hbox, false, false);
        
        // cria uma caixa de botões
        $buttonbox= new GtkHButtonBox;
        $buttonbox->set_layout(Gtk::BUTTONBOX_END);
        
        // adiciona um botão para executar
        $botao = GtkButton::new_from_stock(Gtk::STOCK_EXECUTE);
        $botao->connect_simple('clicked', array($this, 'onGenerate'));
        $buttonbox->pack_start($botao, false, false);
        
        // adiciona um botão para fechar a janela 
        $botao = GtkButton::new_from_stock(Gtk::STOCK_QUIT);
        $botao->connect_simple('clicked', array('Gtk', 'main_quit'));
        $buttonbox->pack_start($botao, false, false);
        
        // adiciona a caixa de botões na caixa vertical
        $vbox->pack_start($buttonbox, false, false);
        
        // adiciona a caixa vertical na janela
        parent::add($vbox);
        // exibe a janela e todo seu conteúdo
        parent::show_all();
    }
    
    /**
     * Acionado pelo botão "Executar"
     * Gera o relatório de produtos em PDF
     */
    public function onGenerate()
    {
        // obtém os parâmetros
        $produto    = strtoupper($this->produto->get_text());
        $fabricante = strtoupper($this->fabricante->get_text());
        $estoquemin = $this->estoquemin->get_text();
        $estoquemax = $this->estoquemax->get_text();
        
        try 
        { 
            $conn = TConnection::open('exemplos'); // abre uma conexão 
            
            // define a consulta
            $sql = 'SELECT p.id, p.descricao, p.estoque, p.preco_custo,
                           p.preco_venda, f.nome as fabricante'.
                   ' FROM produto p, fabricante f'.
                   ' WHERE p.id_fabricante=f.id';
                   
            // detecta filtro por descricao do produto
            if (!empty($produto))
            {
                $sql .= " AND p.descricao like '%{$produto}%'";
            }
            
            // detecta filtro por nome do fabricante
            if (!empty($fabricante))
            {
                $sql .= " AND f.nome like '%{$fabricante}%'";
            }
            
            // detecta filtro por estoque minimo
            if (!empty($estoquemin))
            {
                $sql .= " AND p.estoque >= {$estoquemin}";
            }
            
            // detecta filtro por estoque maximo
            if (!empty($estoquemax))
            {
                $sql .= " AND p.estoque <= {$estoquemax}";
            }
            
            $sql .= ' ORDER BY p.descricao'; 
             
            $result = $conn->query($sql); // executa a instrução SQL
            
            require_once 'app.util/pdf/fpdf.php'; // inclui a classe FPDF
            $pdf = new FPDF('P', 'pt', 'A4'); // instancia a classe FPDF
            $pdf->AddPage(); // adiciona uma página
            $pdf->SetFont('Arial','B',10); // define a fonte
            
            // define cor de preenchimento, cor de texto e espessura da linha
            $pdf->SetFillColor(130,80,70);
            $pdf->SetTextColor(255);
            $pdf->SetLineWidth(1);
            
            // adiciona células
            $pdf->Cell( 40, 20, 'Código',    1, 0, 'C', true);
            $pdf->Cell(220, 20, 'Descrição', 1, 0, 'C', true);
            $pdf->Cell( 50, 20, 'Estoque',   1, 0, 'C', true);
            $pdf->Cell( 70, 20, '$ Custo',   1, 0, 'C', true);
            $pdf->Cell( 70, 20, '$ Venda',   1, 0, 'C', true);
            $pdf->Cell( 70, 20, 'Fabricante',1, 0, 'C', true);
            
            $pdf->Ln(); // quebra de linha
            
            // define cor de fundo, do texto e fonte dos dados
            $pdf->SetFillColor(200,200,200);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial', '', 8);
            
            // inicializa variáveis de controle e totalização
            $colore = FALSE;
            
            // percorre os resultados
            foreach ($result as $row)
            {
                // formata numericamente os preços
                $row['preco_custo'] = number_format($row['preco_custo'], 2, ',', '.');
                $row['preco_venda'] = number_format($row['preco_venda'], 2, ',', '.');
                
                $pdf->Cell( 40, 14, $row['id'],          'LR',0,'C',$colore);
                $pdf->Cell(220, 14, $row['descricao'],   'LR',0,'L',$colore);
                $pdf->Cell( 50, 14, $row['estoque'],     'LR',0,'C',$colore);
                $pdf->Cell( 70, 14, $row['preco_custo'], 'LR',0,'R',$colore);
                $pdf->Cell( 70, 14, $row['preco_venda'], 'LR',0,'R',$colore);
                $pdf->Cell( 70, 14, $row['fabricante'],  'LR',0,'L',$colore);
                
                $pdf->Ln(); // quebra de linha
                $colore = !$colore; // inverte cor de fundo
            }
            // desenha a linha final
            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(520, 20, '',  'T', 0, 'L', true);
            
            // salva o PDF em arquivo
            $pdf->Output('app.output/output-gtk.pdf', 'F');
            
            // abre o PDF na tela conforme o sistema operacional
            if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
                exec('Acrord32.exe app.output/output-gtk.pdf >NULL &');
            else
                exec('evince app.output/output-gtk.pdf >/dev/null &');
        } 
        catch (Exception $e) 
        {
            $dialog = new GtkMessageDialog(null, Gtk::DIALOG_MODAL,
                      Gtk::MESSAGE_INFO, Gtk::BUTTONS_OK, $e->getMessage() );
            $dialog->run();
            $dialog->destroy();
        } 
    }
}

// instancia um objeto da classe ExemploParametro
new ExemploParametro;
Gtk::Main();
?>