<?php
require './config/db/database.php';
$id = NULL;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (NULL == $id) {
    header("Location: index.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT Atas_Problemas.id, Atas_Problemas.id_atas, Atas_Problemas.cidade, Atas_Problemas.grupo, Atas_Problemas.problema, Atas_Classificacao_Problemas.classificacao as Classificacao_Problema, Atas_Problemas.acao, Atas_Problemas.status, DATE_FORMAT(data_conclusao, '%d/%c/%Y') as data_conclusao, Atas_Problemas.responsavel 
        FROM Atas_Problemas 
        INNER JOIN Atas_Classificacao_Problemas on Atas_Classificacao_Problemas.id = Atas_Problemas.Classificacao_Problema
        WHERE Atas_Problemas.id_atas = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Atas Visualização de Problemas</title>
        <meta charset=UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="span10 offset1">
                <div class="row">
                    <h3>Visualizar Problemas</h3>
                </div>
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Cidade:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo $data['cidade'] ?></label>
                        </div>
                    </div>               
                    <div class="control-group">
                        <label class="control-label">Grupo:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo $data['grupo'] ?></label>
                        </div>
                    </div>               
                    <div class="control-group">
                        <label class="control-label">Problema:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo $data['problema'] ?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Classifica&ccedil;&atilde;o:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo $data['Classificacao_Problema'] ?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">A&ccedil;&atilde;o:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo $data['acao'] ?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Status:</label>
                        <div class="controls">
                            <label class="checkbox"><?php if($data['status'] == 1){echo 'Aberto';}else{echo 'Fechado';} ?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Data da Conclus&atilde;o:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo $data['data_conclusao'] ?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Respons&aacute;vel:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo $data['responsavel'] ?></label>
                        </div>
                    </div>                
                    <div class="form-actions">
                        <a class="btn" href="index.php">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>