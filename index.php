<?php

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
        <div class="top" align="center">
            <figure>
                <img src="images/logosimersweb_big.jpg" width="140" height="60" border="0" />
            </figure>
        </div>
        <div class="container">
            <div class="row">
                <div class="row"><h4>Visualiza&ccedil;&atilde;o de Atas</h4></div>            
                <div class="row">
                    <p>
                        <a href="Atas_Inclusao.php" class="btn btn-success">Criar Ata</a>
                        <a href="listar_Problemas.php" class="btn btn-success">Ver Problemas</a>
                        <a href="login.php" class="btn btn-success">Sair</a>
                    </p>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tipo de Reuni&atildeo</th>
                            <th>Data da Reuni&atildeo</th>
                            <th>Participantes</th>
                            <th>Local</th>
                            <th>Status</th>
                            <th>Relator</th>
                            <th>A&ccedil&atildeo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include './config/db/database.php';
                            $pdo = Database::connect();
                            $sql = "SELECT ReunionType.tipo_reuniao as tipo_reuniao, DATE_FORMAT(Paper.data_reuniao, '%d/%c/%Y') as data_reuniao,
                                        Paper.participantes as participantes, Paper.local as local, Statuss.status as status_ata, Paper.relator_ata as relator_ata,
                                        Paper.id as id
                                    FROM Atas Paper
                                    INNER JOIN Atas_Tipo_Reuniao ReunionType on ReunionType.id = Paper.tipo_reuniao
                                    INNER JOIN Status Statuss on Statuss.id = Paper.status_ata
                                    ORDER BY Paper.id DESC";
                            foreach ($pdo->query($sql) as $row)
                            {
                                echo '<tr>';
                                echo '<td>'.$row['tipo_reuniao'].'</td>';
                                echo '<td>'.$row['data_reuniao'].'</td>';
                                echo '<td>'.$row['participantes'].'</td>';
                                echo '<td>'.$row['local'].'</td>';
                                echo '<td>'.$row['status_ata'].'</td>';
                                echo '<td>'.utf8_decode($row['relator_ata']).'</td>';
                                echo '<td width=280>';
                                echo '<a class="btn btn-success" href="Atas_Visualizacao.php?id='.$row['id'].'">Ver</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="Atas_Edicao.php?id='.$row['id'].'">Editar</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="delete.php?id='.$row['id'].'">Excluir</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="Imprimir_Ata.php?id='.$row['id'].'">Imprimir</a>';
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