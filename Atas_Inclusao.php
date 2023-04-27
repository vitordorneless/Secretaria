<?php
    include "./config/db/conecta.php";
?>
<!DOCTYPE html>
<html>
    <head>        
        <meta http-equiv="Content-Type" content="text/html charset=UTF-8">        
        <title>Incluir Ata</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />        
    </head>
    <script type="text/javascript" language="javascript">        
    </script>
    <body>
        <div class="div-form">
            <h1>Inclusão de Atas</h1>
            <form action="class/Atas_Incluir.php" method="post">
                    <fieldset>
                        <label for="lbl_tipo_reuniao">
                            <legend>
                                Tipo de Reunião:
                            </legend>   
                        </label> 
                        <select class="width233" name="tipo_reuniao">
                            <option>
                                Selecione ...
                            </option>
                            <?php
                                $query = mysql_query("Select id, tipo_reuniao from Atas_Tipo_Reuniao");
                                while ($reuniao = mysql_fetch_array($query))
                                {
                            ?>
                            <option value="<?php echo utf8_decode($reuniao['id']) ?>">
                                <?php
                                    echo utf8_decode($reuniao['tipo_reuniao']);}                                            
                                ?>
                            </option>
                        </select>
                        <label for="lbl_data_reuniao">
                            Data da Reunião:
                        </label>
                        <input type="date" name='data_reuniao' size="30" class="width233" required="*"/>
                        <label for="lbl_participantes">
                            Participantes:
                        </label>
                        <input type="text" name="participantes" size='30' class="width233"/>
                        <label for="lbl_local">
                            Local:
                        </label>
                        <input type="text" name="local" size='30' class="width233" required="*"/>
                        <label for="lbl_status_ata">
                            Status da Ata:
                        </label>
                        <select class="width233" name="status_ata">
                            <option>
                                Selecione ...
                            </option>
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
                        <label for="lbl_relator">
                            Relator:
                        </label>
                        <input type="text" name="relator" size='30' class="width233" placeholder="Responsável pelo preenchimento" required="*"/>
                        <input type="submit" name="cadastrar" value="Cadastrar Ata"/>
                    </fieldset>                        
                </form>
        </div>
    </body>
</html>
