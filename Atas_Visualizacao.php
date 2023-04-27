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
    $sql = "SELECT id, tipo_reuniao, DATE_FORMAT(data_reuniao, '%d/%c/%Y') as data_reuniao, participantes, local, status_ata, relator_ata FROM Atas WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Atas</title>
        <meta charset=UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div align="center">
            <figure>
                <img src="images/logosimersweb_big.jpg" width="140" height="60" border="0" />
            </figure>
        </div>
        <div class="container">
            <div class="span10 offset1">
                <div class="row"><h4>Visualiza&ccedil;&atilde;o de Atas</h4></div>            
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Data da Reuni&atilde;o:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo $data['data_reuniao'];?></label>
                        </div>
                    </div>                
                    <div class="control-group">
                        <label class="control-label">Participantes:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo $data['participantes'];?></label>
                        </div>
                    </div>                
                    <div class="control-group">
                        <label class="control-label">Local:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo $data['local'];?></label>
                        </div>
                    </div>                
                    <div class="control-group">
                        <label class="control-label">Status da Ata:</label>
                        <div class="controls">
                            <label class="checkbox"><?php if ($data['status_ata'] == 1){ echo 'Aberta'; } else {echo 'Fechada';};?></label>
                        </div>
                    </div>                
                    <div class="control-group">
                        <label class="control-label">Relator:</label>
                        <div class="controls">
                            <label class="checkbox"><?php echo utf8_decode($data['relator_ata']);?></label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a class="btn" href="index.php">Voltar</a>                        
                        <?
                            $pdo2 = Database::connect();
                            $sql2 = "SELECT id FROM Atas WHERE id = '$id' ORDER BY id DESC";
                            foreach ($pdo2->query($sql2) as $row2)
                            {
                                echo '<a class="btn" href="Imprimir_Ata.php?id='.$row2['id'].'">Imprimir Ata</a>';
                                echo '<a class="btn" href="Atas_Inclusao_Problema.php?id='.$row2['id'].'">Inclus&atilde;o Problemas/A&ccedil;&otilde;es</a>';
                            }
                            Database::disconnect();
                        ?>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">                
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Cidade</th>
                            <th>Problema</th>
                            <th>A&ccedil;&atilde;o</th>
                            <th>Status</th>
                            <th>Data da Conclus&atilde;o</th>
                            <th>Respons&aacute;vel</th>
                            <th>A&ccedil&atildeo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $pdo1 = Database::connect();
                            $sql1 = "SELECT id, id_atas, cidade, problema, Classificacao_Problema, acao, status, DATE_FORMAT(data_conclusao, '%d/%c/%Y') as data_conclusao, responsavel FROM Atas_Problemas WHERE id_atas = '$id' ORDER BY id DESC";
                            foreach ($pdo1->query($sql1) as $row1)
                            {
                                echo '<tr>';
                                $cidade_convert = utf8_decode($row1['cidade']);
                                echo '<td>'.$cidade_convert.'</td>';
                                $problema_convert = utf8_decode($row1['problema']);
                                echo '<td>'.$problema_convert.'</td>';
                                $acao_convert = utf8_decode($row1['acao']);
                                echo '<td>'.$acao_convert.'</td>';
                                
                                if($row1['status'] == 1)
                                    echo '<td>'.'Aberto'.'</td>';                                
                                else                                 
                                    echo '<td>'.'Fechado'.'</td>';                                
                                
                                echo '<td>'.$row1['data_conclusao'].'</td>';
                                $responsavel_convert = utf8_decode($row1['responsavel']);
                                echo '<td>'.$responsavel_convert.'</td>';
                                echo '<td width=200>';
                                echo '<a class="btn btn-success" href="Atas_Visualizacao_Problemas.php?id='.$row1['id_atas'].'">Ver</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="Atas_Edicao_Problemas.php?id='.$row1['id'].'">Editar</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="delete_Problemas.php?id='.$row1['id'].'">Excluir</a>';                                
                                echo ' ';
                                echo '<a class="btn btn-danger" href="Atas_Mais_acoes.php?id='.$row1['id_atas'].'">+ A&ccedil;&otilde;es</a>';
                                echo ' ';
                                echo '</td>';
                                echo '</tr>';
                            }
                            Database::disconnect();
                        ?>
                    </tbody>
                </table>
            </div>
        </div> 
    </body>
</html>