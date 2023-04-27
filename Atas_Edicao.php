<?php
    include "./config/db/conecta.php";
    include './config/db/database.php';    
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
    $sql = "SELECT * FROM Atas WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $tipo_reuniao = $data['tipo_reuniao'];
    $data_reuniao = $data['data_reuniao'];
    $participantes = $data['participantes'];
    $local = $data['local'];
    $status_ata = $data['status_ata'];
    $relator = $data['relator_ata'];
    Database::disconnect();
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
            <h1>Edição de Atas</h1>
            <form action="class/Atas_Editar.php" method="post">
                    <fieldset>
                        <input type="hidden" name="id" size='30' class="width233" value="<?echo $id;?>"/>
                        <label for="lbl_tipo_reuniao">
                            <legend>
                                Tipo de Reunião:
                            </legend>
                        </label> 
                        <select class="width233" name="tipo_reuniao" id="tipo_reuniao">                            
                            <option value="Reunião"></option>
                            <option value="1" <?if($tipo_reuniao==1)echo("SELECTED=\"SELECTED\"");?>>Assembl&eacute;ia</option>
                            <option value="2" <?if($tipo_reuniao==2)echo("SELECTED=\"SELECTED\"");?>>Interior</option>
                            <option value="3" <?if($tipo_reuniao==3)echo("SELECTED=\"SELECTED\"");?>>Metropolitana</option>
                        </select>
						<label >
                            <? echo "<br/>"; ?><br/>
                        </label>
                        <label for="lbl_data_reuniao_old">
                            Data da Reunião:
                        </label>
                        <input type="text" name='data_reuniao_old' size="30" class="width233" value="<? echo $data_reuniao; ?>" readonly />
						<label >
                            <? echo "<br/>"; ?><br/>
                        </label>						
                        <label for="lbl_data_reuniao">
                            Nova Data da Reunião:
                        </label>
                        <input type="date" name='data_reuniao' size="30" class="width233" required="*"/>
						<label >
                            <? echo "<br/>"; ?><br/>
                        </label>
                        <label for="lbl_participantes">
                            Participantes:                            
                        </label>
                        <input type="text" name="participantes" size='30' class="width233" value="<?echo $participantes;?>" required="*"/>
						<label >
                            <? echo "<br/>"; ?><br/>
                        </label>
                        <label for="lbl_local">
                            Local:
                        </label>
                        <input type="text" name="local" size='30' class="width233" value="<?echo $local?>" required="*"/>
						<label >
                            <? echo "<br/>"; ?><br/>
                        </label>
                        <label for="lbl_status_ata">
                            Status da Ata:
                        </label>
                        <select class="width233" name="status_ata" id="status_ata">                            
                            <option value="Status"></option>
                            <option value="1" <?if($status_ata==1)echo("SELECTED=\"SELECTED\"");?>>Aberto</option>
                            <option value="2" <?if($status_ata==2)echo("SELECTED=\"SELECTED\"");?>>Fechado</option>
                        </select>
						<label >
                            <? echo "<br/>"; ?><br/>
                        </label>
                        <label for="lbl_relator">
                            Relator:
                        </label>
                        <input type="text" name="relator" size='30' class="width233" value="<?echo $relator?>" required="*"/>
						<label >
                            <? echo "<br/>"; ?><br/>
                        </label>
                        <input type="submit" name="editar" value="Editar Ata" align="center"/>                        
                    </fieldset>                        
                </form>
        </div>
    </body>
</html>