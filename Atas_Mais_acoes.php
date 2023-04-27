<?php
    include "./config/db/database.php";
    $id = NULL;
    if (!empty($_GET['id'])) 
    {
        $id = $_REQUEST['id'];
    }
    
    if (NULL == $id) {
    header("Location: index.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM Atas_Problemas WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $id_ata = $data['id_atas'];
    $cidade = $data['cidade'];
    $problema = $data['problema'];
    $acao = $data['acao'];
    $Classificacao_Problema = $data['Classificacao_Problema'];
    $status = $data['status'];
    $data_conclusao = $data['data_conclusao'];
    $responsavel = $data['responsavel'];
    Database::disconnect();
}
?>
<!DOCTYPE html>
<html>
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <title>Editar problemas e a&ccedil;&otilde;es Ata</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />        
    </head>
    <script type="text/javascript" language="javascript">        
    </script>
    <body>
        <div class="div-form">
            <h1>Edição de Problemas</h1>
            <form action="class/Atas_Mais_Acoes.php" method="post">
                    <fieldset>
                        <input type="hidden" name="id_atas" size='30' class="width250" value="<?echo $id_ata?>"/>
                        <input type="hidden" name="id" size='30' class="width233" value="<?echo $id?>"/>
                        <label for="lbl_cidade">
                            <legend>
                                Cidade / Grupo:
                            </legend>
                        </label> 
                        <input type="text" name="cidade" size='30' value="<?echo $cidade?>" class="width233" readonly/>
                        <label for="lbl_problema">
                            Problema:
                        </label>
                        <textarea rows="5" cols="40" name='problema' class="width233" required="*"><?echo $problema?></textarea>
                        <select class="width233" name="status" id="Classificacao_Problema">
                            <option>Selecione ...</option>
                            <option value="1" <?if($Classificacao_Problema==1) echo("SELECTED=\"SELECTED\"");?>>Econômico</option>
                            <option value="2" <?if($Classificacao_Problema==2) echo("SELECTED=\"SELECTED\"");?>>Criminal</option>
                        </select>
                        <label for="lbl_acao">
                            Ação:
                        </label>
                        <textarea rows="5" cols="40" name='acao' class="width233" required="*" ><?echo $acao?></textarea>
                        <label for="lbl_status">
                            Status:
                        </label>
                        <select class="width233" name="status" id="status">
                            <option>Selecione ...</option>
                            <option value="1" <?if($status==1) echo("SELECTED=\"SELECTED\"");?>>Aberto</option>
                            <option value="2" <?if($status==2) echo("SELECTED=\"SELECTED\"");?>>Fechado</option>
                        </select>                        
                        <label for="lbl_data_conclusao">
                            Nova data da Conclusão:
                        </label>
                        <input type="date" name='data_conclusao' size="30" class="width233" required="*"/>                        
                        <label for="lbl_responsável">
                            Responsável(s):
                        </label>
                        <input type="text" name="responsavel" size='30' value="<?echo $responsavel?>" class="width233"/>
                        <input type="submit" name="editar" value="Editar Problema"/>
                    </fieldset>                        
                </form>
        </div>
    </body>
</html>