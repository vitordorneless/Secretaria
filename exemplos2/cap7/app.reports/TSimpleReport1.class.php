<?php
/**
 * Classe para constru��o de relat�rios tabulares simples
 * @author Pablo Dall'Oglio
 */
class TSimpleReport
{
    private $database;
    private $sql;
    private $writter;
    private $columns;
    
    /**
     * M�todo construtor
     */
    public function __construct()
    {
        $this->columns = array();
    }
    
    /**
     * Define o banco de dados para a consulta SQL
     * @param $database nome do banco de dados
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }
    
    /**
     * Define a consulta SQL para gera��o do relat�rio
     * @param $sql consulta em SQL
     */
    public function setQuery($sql)
    {
        $this->sql = $sql;
    }
    
    /**
     * Define um objeto "escritor" do relat�rio
     * @param $writter objeto que implementa a interface ITableWritter
     */
    public function setReportWritter($writter)
    {
        $this->writter = $writter;
    }
    
    /**
     * Adiciona uma coluna ao relat�rio
     * @param $alias nome da coluna na consulta SQL
     * @param $label r�tulo do campo (t�tulo da coluna)
     * @param $align alinhamento da coluna
     */
    public function addColumn($alias, $label, $align)
    {
        $this->columns[] = array('alias'=>$alias, 'label'=>$label, 'align'=>$align);
    }
    
    /**
     * Gera o relat�rio
     */
    public function generate()
    {
        // verifica se foi definido o banco de dados
        if (!isset($this->database))
        {
            throw new Exception('Banco de dados n�o definido');
        }
        
        // verifica se foi definida a consulta SQL
        if (!isset($this->sql))
        {
            throw new Exception('Consulta SQL n�o definida');
        }
        
        // verifica se foi definido o escritor de tabelas
        if (!isset($this->writter))
        {
            throw new Exception('Escritor de tabelas n�o definido');
        }
        
        // verifica se foram definidas as colunas do relat�rio
        if (count($this->columns) == 0)
        {
            throw new Exception('Colunas do relat�rio n�o definidas');
        }
        
        // adiciona uma linha para o cabe�alho (t�tulos das colunas)
        $this->writter->addRow();
        foreach ($this->columns as $column)
        {
            // adiciona as colunas de cabe�alho
            $this->writter->addCell($column['label'], $column['align'], 'title');
        }
        
        $conn = TConnection::open($this->database); // abre conex�o com a base de dados
        
        // executa a instru��o SQL
        $result = $conn->query($this->sql);
        
        $colore = FALSE;
        // percorre os resultados
        foreach ($result as $row)
        {
            // define o estilo a ser utilizado
            $style = $colore ? 'datai' : 'datap';
            
            // adiciona uma linha para os dados
            $this->writter->addRow();
            
            // adiciona as colunas com os dados
            foreach ($this->columns as $column)
            {
                $alias   = $column['alias'];
                $content = $row[$alias];
                $this->writter->addCell($content, $column['align'], $style);
            }
            
            // alterna vari�vel de controle para cor de fundo
            $colore = !$colore;
        }
    }
    
    /**
     * Armazena o relat�rio em um arquivo
     * @param $filename localiza��o do arquivo
     */
    public function save($filename)
    {
        $this->writter->save($filename);
    }
}
?>