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
    $grupo = $data['grupo'];
    $problema = $data['problema'];
    $Classificacao_Problema = $data['Classificacao_Problema'];
    $acao = $data['acao'];
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
            <form action="class/Atas_Editar_Problema.php" method="post">
                    <fieldset>
                        <input type="hidden" name="id_atas" size='30' class="width250" value="<?echo $id_ata?>"/>
                        <input type="hidden" name="id" size='30' class="width233" value="<?echo $id?>"/>
                        <label for="lbl_cidade">
                            <legend>
                                Cidade / Grupo:
                            </legend>
                        </label> 
                        <input type="text" name="cidade" size='30' value="<?echo $cidade?>" class="width233"/>
                        <label for="lbl_grupo">
                            <legend>
                                Grupo:
                            </legend>
                        </label> 
                        <input type="text" name="grupo" size='30' value="<?echo $grupo?>" class="width233"/>
                        <label for="lbl_problema">
                            Problema:
                        </label>
                        <textarea rows="5" cols="40" name='problema' class="width233" required="*"><?echo $problema?></textarea>
                        <select class="width233" name="status" id="Classificacao_Problema">
                            <option>Selecione ...</option>                            
                            <option value="8" <?if($Classificacao_Problema==8) echo("SELECTED=\"SELECTED\"");?>>Ação parlamentar</option>
                            <option value="9" <?if($Classificacao_Problema==9) echo("SELECTED=\"SELECTED\"");?>>Ações MPE</option>
                            <option value="10" <?if($Classificacao_Problema==10) echo("SELECTED=\"SELECTED\"");?>>Ações MPT</option>
                            <option value="11" <?if($Classificacao_Problema==11) echo("SELECTED=\"SELECTED\"");?>>Acordo Coletivo de Trabalho</option>
                            <option value="12" <?if($Classificacao_Problema==12) echo("SELECTED=\"SELECTED\"");?>>Amrigs</option>
                            <option value="13" <?if($Classificacao_Problema==13) echo("SELECTED=\"SELECTED\"");?>>Aplicação EC29</option>
                            <option value="14" <?if($Classificacao_Problema==14) echo("SELECTED=\"SELECTED\"");?>>Brigada Militar</option>
                            <option value="15" <?if($Classificacao_Problema==15) echo("SELECTED=\"SELECTED\"");?>>CAPS (todos os tipos)</option>
                            <option value="16" <?if($Classificacao_Problema==16) echo("SELECTED=\"SELECTED\"");?>>Casas de Parto</option>
                            <option value="17" <?if($Classificacao_Problema==17) echo("SELECTED=\"SELECTED\"");?>>CBHPM</option>
                            <option value="18" <?if($Classificacao_Problema==18) echo("SELECTED=\"SELECTED\"");?>>CFC Detran</option>
                            <option value="19" <?if($Classificacao_Problema==19) echo("SELECTED=\"SELECTED\"");?>>Conselho Estadual de Saúde</option>
                            <option value="20" <?if($Classificacao_Problema==20) echo("SELECTED=\"SELECTED\"");?>>Conselho Municipal da Saúde (por cidade)</option>
                            <option value="21" <?if($Classificacao_Problema==21) echo("SELECTED=\"SELECTED\"");?>>Contratualização</option>
                            <option value="22" <?if($Classificacao_Problema==22) echo("SELECTED=\"SELECTED\"");?>>Convenções Coletivas de Trabalho</option>
                            <option value="23" <?if($Classificacao_Problema==23) echo("SELECTED=\"SELECTED\"");?>>Cremers</option>
                            <option value="24" <?if($Classificacao_Problema==24) echo("SELECTED=\"SELECTED\"");?>>Datasus</option>
                            <option value="25" <?if($Classificacao_Problema==25) echo("SELECTED=\"SELECTED\"");?>>Delegacia do Trabalho (capital)</option>
                            <option value="26" <?if($Classificacao_Problema==26) echo("SELECTED=\"SELECTED\"");?>>Delegacia do Trabalho (interior, município)</option>
                            <option value="27" <?if($Classificacao_Problema==27) echo("SELECTED=\"SELECTED\"");?>>Departamento Médico Legal - DML</option>
                            <option value="28" <?if($Classificacao_Problema==28) echo("SELECTED=\"SELECTED\"");?>>Departamento Médico Legal (capital)</option>
                            <option value="29" <?if($Classificacao_Problema==29) echo("SELECTED=\"SELECTED\"");?>>Departamento Médico Legal (interior, município)</option>
                            <option value="30" <?if($Classificacao_Problema==30) echo("SELECTED=\"SELECTED\"");?>>EccoSalva</option>
                            <option value="31" <?if($Classificacao_Problema==31) echo("SELECTED=\"SELECTED\"");?>>Empregado Público</option>
                            <option value="32" <?if($Classificacao_Problema==32) echo("SELECTED=\"SELECTED\"");?>>ESF (para todos os municípios menos POA)</option>
                            <option value="33" <?if($Classificacao_Problema==33) echo("SELECTED=\"SELECTED\"");?>>ESF POA</option>
                            <option value="34" <?if($Classificacao_Problema==34) echo("SELECTED=\"SELECTED\"");?>>Farmácia</option>
                            <option value="35" <?if($Classificacao_Problema==35) echo("SELECTED=\"SELECTED\"");?>>Farmácia Estadual</option>
                            <option value="36" <?if($Classificacao_Problema==36) echo("SELECTED=\"SELECTED\"");?>>Farmácia Municipal</option>
                            <option value="37" <?if($Classificacao_Problema==37) echo("SELECTED=\"SELECTED\"");?>>Farmácia Popular</option>
                            <option value="38" <?if($Classificacao_Problema==38) echo("SELECTED=\"SELECTED\"");?>>Fehosul</option>
                            <option value="39" <?if($Classificacao_Problema==39) echo("SELECTED=\"SELECTED\"");?>>Fundação de Saúde Canoas</option>
                            <option value="40" <?if($Classificacao_Problema==40) echo("SELECTED=\"SELECTED\"");?>>Grupo Hospitalar Conceição - GHC</option>
                            <option value="41" <?if($Classificacao_Problema==41) echo("SELECTED=\"SELECTED\"");?>>Guarda Municipal (município)</option>
                            <option value="42" <?if($Classificacao_Problema==42) echo("SELECTED=\"SELECTED\"");?>>Guarda Municipal (POA)</option>
                            <option value="43" <?if($Classificacao_Problema==43) echo("SELECTED=\"SELECTED\"");?>>HMIPV</option>
                            <option value="44" <?if($Classificacao_Problema==44) echo("SELECTED=\"SELECTED\"");?>>HNSG Canoas</option>
                            <option value="45" <?if($Classificacao_Problema==45) echo("SELECTED=\"SELECTED\"");?>>Hospitais POA (categoria genérica para os demais hospitais)</option>
                            <option value="46" <?if($Classificacao_Problema==46) echo("SELECTED=\"SELECTED\"");?>>Hospital Centenário</option>
                            <option value="47" <?if($Classificacao_Problema==47) echo("SELECTED=\"SELECTED\"");?>>Hospital de Alvorada</option>
                            <option value="48" <?if($Classificacao_Problema==48) echo("SELECTED=\"SELECTED\"");?>>Hospital de Clínicas de Porto Alegre – HCPA</option>
                            <option value="49" <?if($Classificacao_Problema==49) echo("SELECTED=\"SELECTED\"");?>>Hospital de Pronto Socorro (municípios)</option>
                            <option value="50" <?if($Classificacao_Problema==50) echo("SELECTED=\"SELECTED\"");?>>Hospital de Viamão</option>
                            <option value="51" <?if($Classificacao_Problema==51) echo("SELECTED=\"SELECTED\"");?>>Hospital Eernesto Dorneles – HED</option>
                            <option value="52" <?if($Classificacao_Problema==52) echo("SELECTED=\"SELECTED\"");?>>Hospital Filantrópico</option>
                            <option value="53" <?if($Classificacao_Problema==53) echo("SELECTED=\"SELECTED\"");?>>Hospital Getúlio Vargas</option>
                            <option value="54" <?if($Classificacao_Problema==54) echo("SELECTED=\"SELECTED\"");?>>Hospital Mãe de Deus</option>
                            <option value="55" <?if($Classificacao_Problema==55) echo("SELECTED=\"SELECTED\"");?>>Hospital Padre Geremia</option>
                            <option value="56" <?if($Classificacao_Problema==56) echo("SELECTED=\"SELECTED\"");?>>Hospital Porto Alegre</option>
                            <option value="57" <?if($Classificacao_Problema==57) echo("SELECTED=\"SELECTED\"");?>>Hospital Privado</option>
                            <option value="58" <?if($Classificacao_Problema==58) echo("SELECTED=\"SELECTED\"");?>>Hospital Público (município)</option>
                            <option value="59" <?if($Classificacao_Problema==59) echo("SELECTED=\"SELECTED\"");?>>Hospital São Camilo</option>
                            <option value="60" <?if($Classificacao_Problema==60) echo("SELECTED=\"SELECTED\"");?>>Hospital São Lucas (da PUC)</option>
                            <option value="61" <?if($Classificacao_Problema==61) echo("SELECTED=\"SELECTED\"");?>>HPS</option>
                            <option value="62" <?if($Classificacao_Problema==62) echo("SELECTED=\"SELECTED\"");?>>HPS Canoas</option>
                            <option value="63" <?if($Classificacao_Problema==63) echo("SELECTED=\"SELECTED\"");?>>HU Canoas</option>
                            <option value="64" <?if($Classificacao_Problema==64) echo("SELECTED=\"SELECTED\"");?>>Imesf POA</option>
                            <option value="65" <?if($Classificacao_Problema==65) echo("SELECTED=\"SELECTED\"");?>>Insalubridade</option>
                            <option value="66" <?if($Classificacao_Problema==66) echo("SELECTED=\"SELECTED\"");?>>IPERGS</option>
                            <option value="67" <?if($Classificacao_Problema==67) echo("SELECTED=\"SELECTED\"");?>>Lei de Responsabilidade Fiscal</option>
                            <option value="68" <?if($Classificacao_Problema==68) echo("SELECTED=\"SELECTED\"");?>>Médico Plantonista</option>
                            <option value="69" <?if($Classificacao_Problema==69) echo("SELECTED=\"SELECTED\"");?>>Médico Residente</option>
                            <option value="70" <?if($Classificacao_Problema==70) echo("SELECTED=\"SELECTED\"");?>>Médico Rotineiro</option>
                            <option value="71" <?if($Classificacao_Problema==71) echo("SELECTED=\"SELECTED\"");?>>Mesa de Negociação do SUS</option>
                            <option value="72" <?if($Classificacao_Problema==72) echo("SELECTED=\"SELECTED\"");?>>Ministério da Saúde</option>
                            <option value="73" <?if($Classificacao_Problema==73) echo("SELECTED=\"SELECTED\"");?>>Municipalizados POA</option>
                            <option value="74" <?if($Classificacao_Problema==74) echo("SELECTED=\"SELECTED\"");?>>Municipários (para todos os municípios menos POA)</option>
                            <option value="75" <?if($Classificacao_Problema==75) echo("SELECTED=\"SELECTED\"");?>>Municipários POA</option>
                            <option value="76" <?if($Classificacao_Problema==76) echo("SELECTED=\"SELECTED\"");?>>Negociações coletivas de trabalho (por cidade e/ou especialidades, vínculos formais ou informais)</option>
                            <option value="77" <?if($Classificacao_Problema==77) echo("SELECTED=\"SELECTED\"");?>>PACS</option>
                            <option value="78" <?if($Classificacao_Problema==78) echo("SELECTED=\"SELECTED\"");?>>Periculosidade</option>
                            <option value="79" <?if($Classificacao_Problema==79) echo("SELECTED=\"SELECTED\"");?>>Perito Médico (DML)</option>
                            <option value="80" <?if($Classificacao_Problema==80) echo("SELECTED=\"SELECTED\"");?>>Perito Médico (INSS)</option>
                            <option value="81" <?if($Classificacao_Problema==81) echo("SELECTED=\"SELECTED\"");?>>Peritos INSS</option>
                            <option value="82" <?if($Classificacao_Problema==82) echo("SELECTED=\"SELECTED\"");?>>Planos de Saúde</option>
                            <option value="83" <?if($Classificacao_Problema==83) echo("SELECTED=\"SELECTED\"");?>>Policia Civil</option>
                            <option value="84" <?if($Classificacao_Problema==84) echo("SELECTED=\"SELECTED\"");?>>Política de Medicamento</option>
                            <option value="85" <?if($Classificacao_Problema==85) echo("SELECTED=\"SELECTED\"");?>>Pronto Atendimento</option>
                            <option value="86" <?if($Classificacao_Problema==86) echo("SELECTED=\"SELECTED\"");?>>Radimagem</option>
                            <option value="87" <?if($Classificacao_Problema==87) echo("SELECTED=\"SELECTED\"");?>>Regulação Municipal POA</option>
                            <option value="88" <?if($Classificacao_Problema==88) echo("SELECTED=\"SELECTED\"");?>>Regulação Município</option>
                            <option value="89" <?if($Classificacao_Problema==89) echo("SELECTED=\"SELECTED\"");?>>Residência Multiprofissional</option>
                            <option value="90" <?if($Classificacao_Problema==90) echo("SELECTED=\"SELECTED\"");?>>SAMU (municipal)</option>
                            <option value="91" <?if($Classificacao_Problema==91) echo("SELECTED=\"SELECTED\"");?>>SAMU Estadual</option>
                            <option value="92" <?if($Classificacao_Problema==92) echo("SELECTED=\"SELECTED\"");?>>SAMU POA</option>
                            <option value="93" <?if($Classificacao_Problema==93) echo("SELECTED=\"SELECTED\"");?>>Santa Casa</option>
                            <option value="94" <?if($Classificacao_Problema==94) echo("SELECTED=\"SELECTED\"");?>>Santa Casa POA</option>
                            <option value="95" <?if($Classificacao_Problema==95) echo("SELECTED=\"SELECTED\"");?>>Saúde Mental</option>
                            <option value="96" <?if($Classificacao_Problema==96) echo("SELECTED=\"SELECTED\"");?>>Secreataria de Saúde (interior)</option>
                            <option value="97" <?if($Classificacao_Problema==97) echo("SELECTED=\"SELECTED\"");?>>Secretaria Estadual de Saúde</option>
                            <option value="98" <?if($Classificacao_Problema==98) echo("SELECTED=\"SELECTED\"");?>>Secretaria Muncipal de Saúde (região metropolitana)</option>
                            <option value="99" <?if($Classificacao_Problema==99) echo("SELECTED=\"SELECTED\"");?>>Secretaria Muncipal de Saúde de POA</option>
                            <option value="100" <?if($Classificacao_Problema==100) echo("SELECTED=\"SELECTED\"");?>>Serviço de Apoio Diagnóstico</option>
                            <option value="101" <?if($Classificacao_Problema==101) echo("SELECTED=\"SELECTED\"");?>>Serviço de Saúde (descrever os principais)</option>
                            <option value="102" <?if($Classificacao_Problema==102) echo("SELECTED=\"SELECTED\"");?>>Sindiberf</option>
                            <option value="103" <?if($Classificacao_Problema==103) echo("SELECTED=\"SELECTED\"");?>>Sindihospa</option>
                            <option value="104" <?if($Classificacao_Problema==104) echo("SELECTED=\"SELECTED\"");?>>Sobreaviso</option>
                            <option value="105" <?if($Classificacao_Problema==105) echo("SELECTED=\"SELECTED\"");?>>SUS Capital</option>
                            <option value="106" <?if($Classificacao_Problema==106) echo("SELECTED=\"SELECTED\"");?>>Tribunal de Contas da União</option>
                            <option value="107" <?if($Classificacao_Problema==107) echo("SELECTED=\"SELECTED\"");?>>Tribunal Regional do Trabalho</option>
                            <option value="108" <?if($Classificacao_Problema==108) echo("SELECTED=\"SELECTED\"");?>>Tribunal de Contas do Estado</option>
                            <option value="109" <?if($Classificacao_Problema==109) echo("SELECTED=\"SELECTED\"");?>>Unicred</option>
                            <option value="110" <?if($Classificacao_Problema==110) echo("SELECTED=\"SELECTED\"");?>>Unidade Básica de Saúde (capital)</option>
                            <option value="111" <?if($Classificacao_Problema==111) echo("SELECTED=\"SELECTED\"");?>>Unidade Básica de Saúde (interior, município)</option>
                            <option value="112" <?if($Classificacao_Problema==112) echo("SELECTED=\"SELECTED\"");?>>Unidade Básica de Saúde (metropolitana exceto POA)</option>
                            <option value="113" <?if($Classificacao_Problema==113) echo("SELECTED=\"SELECTED\"");?>>Unidade de Tratamento Intensivo</option>
                            <option value="114" <?if($Classificacao_Problema==114) echo("SELECTED=\"SELECTED\"");?>>Unimed</option>
                            <option value="115" <?if($Classificacao_Problema==115) echo("SELECTED=\"SELECTED\"");?>>UPA</option>
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
                        <label for="lbl_data_conclusao_old">
                            Data da Conclusão:
                        </label>
                        <input type="text" name='data_conclusao_old' size="30" class="width233" value="<?echo $data_conclusao?>" readonly/>                        
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