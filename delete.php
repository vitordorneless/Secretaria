<?php
    require './config/db/database.php';
    $id = 0;
    
    if (!empty($_GET['id']))
    {
        $id = $_REQUEST['id'];        
    }
    
    if (!empty($_POST))
    {
        $id = $_POST['id'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM Atas WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Exclusão Segura de Atas</title>
        <meta charset=UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="span10 offset1">
            <div class="row">
                <h3>Exclusao de Atas</h3>
            </div>
            <form class="form-horizontal" action="delete.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id;?>"/>
                <p class="alert alert-error">
                    Tem certeza de deletar esta Ata?
                </p>
                <div class="form-actions">
                    <button type="submit" class="btn btn-danger">Sim</button>
                    <a class="btn" href="index.php">N&atilde;o</a>
                </div>
            </form>
        </div>
    </body>
</html>    