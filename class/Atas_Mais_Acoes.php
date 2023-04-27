<?php
    include "../config/db/conecta.php";    
    $id_ata = $_POST["id_atas"];
    $cidade = $_POST["cidade"];
    $problema = $_POST["problema"];
    $Classificacao_Problema = $_POST['classificacao_problema'];
    $acao = $_POST["acao"];
    $status = $_POST["status"];
    $data_conclusao = $_POST["data_conclusao"];
    $responsavel = $_POST["responsavel"];    
    $inserirmaisacoes = mysql_query("INSERT INTO Atas_Problemas VALUES('','$id_ata','$cidade','$problema','$Classificacao_Problema','$acao','$status','$data_conclusao','$responsavel')");        
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Inclus&atilde;o de Atas</title>
        <meta charset=UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="span10 offset1">
            <div class="row">
                <h3>Inclus&atilde;o de Problemas</h3>
            </div> 
            <form class="form-horizontal">
                <p class="alert alert-error">
                    Inclus&atilde;o de problema gerado com sucesso!!
                </p>
                <div class="form-actions">                    
                    <a class="btn" href="http://pessoal3.simers.org.br/index.php">Voltar</a>
                </div>            
            </form> 
        </div>
    </body>
</html>    
