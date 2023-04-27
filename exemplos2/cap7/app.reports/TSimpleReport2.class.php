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
    private $group;
    private $total;
    
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
     * Define uma quebra no relat�rio
     * @param $alias nome da coluna de quebra na consulta SQL
     */
    public function setGroup($alias)
    {
        $this->group = $alias;
    }
    
    /**
     * Cria um totalizador no relat�rio
     * @param $alias   nome da coluna a ser totalizada
     * @param $formula f�rmula a ser aplicada
     */
    public function setTotal($alias, $formula)
    {
        $this->total[$alias] = $formula;
        $this->results[$alias] = 0;
    }
    
    /**
     * Gera o relat�rio
     */
    public function generate()
    {
        if (!isset($this->database)) // verifica se foi definido o banco de dados
        {
            throw new Exception('Banco de dados n�o definido');
        }
        if (!isset($this->sql)) // verifica se foi definida a consulta SQL
        {
            throw new Exception('Consulta SQL n�o definida');
        }
        if (!isset($this->writter)) // verifica se foi definido o escritor de tabelas
        {
            throw new Exception('Escritor de tabelas n�o definido');
        }
        if (count($this->columns) == 0) // verifica se foram definidas as colunas do relat�rio
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
        $result = $conn->query($this->sql); // executa a instru��o SQL
        
        // vari�vel para controle de troca de grupo
        $last_group = NULL;
        
        $colore = FALSE;
        // percorre os resultados
        foreach ($result as $row)
        {
            // define o estilo a ser utilizado
            $style = $colore ? 'datai' : 'datap';
            
            // verifica se o relat�rio tem agrupamento
            if (isset($this->group))
            {
                // verifica se a coluna de agrupamento trocou de valor
                if ($last_group !== $row[$this->group])
                {
                    // totaliza��o na troca de grupo
                    if (isset($this->total) AND $last_group !== NULL)
                    {
                        $this->printTotals();
                    }
                    
                    // acrescenta uma linha para o grupo
                    $this->writter->addRow();
                    
                    // exibe a c�lula de agrupamento
                    $this->writter->addCell($row[$this->group], 'left', 'group');
                    
                    // completa a linha com as demais c�lulas vazias
                    for ($n = 1; $n <= count($this->columns)-1; $n++)
                    {
                        $this->writter->addCell('', 'left', 'group');
                    }
                    
                    // atualiza a vari�vel de controle para troca de grupo
                    $last_group = $row[$this->group];
                }
            }
            
            // adiciona uma linha para os dados
            $this->writter->addRow();
            
            // adiciona as colunas com os dados
            foreach ($this->columns as $column)
            {
                $alias   = $column['alias'];
                $content = $row[$alias];
                $this->writter->addCell($content, $column['align'], $style);
                
                // realiza as totaliza��es da coluna se necess�rio
                if (isset($this->total[$alias]))
                {
                    $formula = $this->total[$alias];
                    if ($formula == 'count')
                    {
                        $this->results[$alias] ++;
                    }
                    else if ($formula == 'sum')
                    {
                        $this->results[$alias] += $content;
                    }
                }
            }
            
            // alterna vari�vel de controle para cor de fundo
            $colore = !$colore;
        }
        
        // totaliza��o final
        if (isset($this->total))
        {
            $this->printTotals();
        }
    }
    
    /**
     * Exibe os totais das f�rmulas
     */
    private function printTotals()
    {
        // adiciona uma linha
        $this->writter->addRow();
        
        // percorre as colunas
        foreach ($this->columns as $column)
        {
            $alias = $column['alias'];
            
            // verifica se h� totaliza��o para a coluna
            if (isset($this->results[$alias]))
            {
                // exibe a totaliza��o da coluna
                $formula = $this->total[$alias];
                $this->writter->addCell($formula . ': '. $this->results[$alias],
                                        $column['align'], 'total');
                                        
                // reinicializa os totais da coluna
                $this->results[$alias] = 0;
            }
            else
            {
                // exibe uma c�lula vazia
                $this->writter->addCell('', $column['align'], 'total');
            }
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