<?php
    include "../config/db/conecta.php";
    
    $id = $_POST["id"];
    $id_ata = $_POST["id_atas"];
    $cidade = $_POST["cidade"];
    $grupo = $_POST["grupo"];
    $problema = $_POST["problema"];
    $Classificacao_Problema = $_POST['Classificacao_Problema'];
    $acao = $_POST["acao"];
    $status = $_POST["status"];
    $data_conclusao = $_POST["data_conclusao"];
    $responsavel = $_POST["responsavel"];
    
    $editarAta = mysql_query("UPDATE Atas_Problemas SET id_atas = '$id_ata', cidade = '$cidade', grupo = '$grupo',
        problema = '$problema',Classificacao_Problema = '$Classificacao_Problema', acao = '$acao', status = '$status', data_conclusao = '$data_conclusao', responsavel = '$responsavel'
            WHERE id = '$id'");    
    
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edição de problemas e ações</title>
        <meta charset=UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="span10 offset1">
            <div class="row">
                <h3>Edi&ccedil;&atilde;o de Problemas</h3>
            </div> 
            <form class="form-horizontal">
                <p class="alert alert-error">
                    Edi&ccedil;&atilde;o de Problemas e A&ccedil;&otilde;es gerado com sucesso!!
                </p>
                <div class="form-actions">                    
                    <a class="btn" href="http://pessoal3.simers.org.br/index.php">Voltar</a>
                </div>            
            </form> 
        </div>
    </body>
</html> 