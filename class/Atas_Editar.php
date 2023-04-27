<?php
    include "../config/db/conecta.php";
    
    $id = $_POST["id"];
    $tipo_reuniao = $_POST["tipo_reuniao"];
    $data_reuniao = $_POST["data_reuniao"];
    $participantes = $_POST["participantes"];
    $local = $_POST["local"];
    $status_ata = $_POST["status_ata"];
    $relator = $_POST["relator"];
    
    $editarAta = mysql_query("UPDATE Atas SET tipo_reuniao = '$tipo_reuniao', data_reuniao = '$data_reuniao',
        participantes = '$participantes', local = '$local', status_ata = '$status_ata', relator_ata = '$relator' WHERE id = '$id'");    
    
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
                <h3>Edi&ccedil;&atilde;o de Atas</h3>
            </div> 
            <form class="form-horizontal">
                <p class="alert alert-error">
                    Edi&ccedil;&atilde;o de ata gerado com sucesso!!
                </p>
                <div class="form-actions">                    
                    <a class="btn" href="http://pessoal3.simers.org.br/index.php">Voltar</a>
                </div>            
            </form> 
        </div>
    </body>
</html>     