<?php
    include "./config/db/conecta.php";
    $id = NULL;
    if (!empty($_GET['id'])) 
    {
        $id = $_REQUEST['id'];
    }
?>
<!DOCTYPE html>
<html>
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">         
       <title>Incluir Ata</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />        
    </head>
    <script type="text/javascript" language="javascript">        
    </script>
    <body>
        <div class="div-form">
            <h1>Inclusão de Problemas</h1>
            <form action="class/Atas_Incluir_Problema.php" method="post">
                    <fieldset>
                        <input type="hidden" name="id_atas" size='30' class="width233" value="<?echo $id;?>"/>
                        <label for="lbl_cidade">
                            <legend>
                                Cidade:
                            </legend>
                        </label> 
                        <input type="text" name="cidade" size='30' class="width233"/>
                        <label for="lbl_grupo">
                            <legend>
                                Grupo:
                            </legend>
                        </label> 
                        <input type="text" name="grupo" size='30' class="width233"/>
                        <label for="lbl_problema">
                            Problema:
                        </label>
                        <textarea rows="5" cols="40" name='problema' class="width233" required="*" placeholder="Descrição dos problemas..."></textarea>
                        <label for="lbl_classificacao">
                            Classificação:
                        </label>
                        <select class="width233" name="classificacao_problema">
                            <option>Selecione ...</option>
                            <?php
                                $queryClassificacao = mysql_query("Select id, classificacao from Atas_Classificacao_Problemas where Ativo = 'A'");
                                while ($classification = mysql_fetch_array($queryClassificacao))
                                {
                            ?>
                            <option value="<?php echo $classification['id'] ?>">
                                <?php
                                    echo utf8_decode($classification['classificacao']);}                                            
                                ?>
                            </option>                            
                        </select>
                        <label for="lbl_acao">
                            Ação:
                        </label>
                        <textarea rows="5" cols="40" name='acao' class="width233" required="*" placeholder="Descrição das ações..."></textarea>
                        <label for="lbl_status">
                            Status:
                        </label>
                        <select class="width233" name="status">
                            <option>Selecione ...</option>
                            <?php
                                $qquery = mysql_query("Select id, status from Status");
                                while ($status = mysql_fetch_array($qquery))
                                {
                            ?>
                            <option value="<?php echo $status['id'] ?>">
                                <?php
                                    echo utf8_decode($status['status']);}                                            
                                ?>
                            </option>                            
                        </select>
                        <label for="lbl_data_conclusao">
                            Data da Conclusão:
                        </label>
                        <input type="date" name='data_conclusao' size="30" class="width233" required="*"/>                        
                        <label for="lbl_responsável">
                            Responsável(s):
                        </label>
                        <input type="text" name="responsavel" size='30' class="width233"/>
                        <input type="submit" name="incluir" value="Incluir Problema"/>
                    </fieldset>                        
                </form>
        </div>
    </body>
</html>