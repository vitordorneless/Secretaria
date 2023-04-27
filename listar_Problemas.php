<?php
require './config/db/conecta.php';
require './config/db/database.php';
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
                <div class="row"><h4>Listagem de problemas</h4></div>            
                <div class="form-horizontal">
                    <form action="listar_Problemas.php" method="post">
                    <fieldset>                        
                        <label for="lbl_cidade">Cidade:</label> 
                        <input type="text" name="grupo" size='30' class="width233"/>
                        <label for="lbl_grupo">Grupo:</label> 
                        <input type="text" name="grupo" size='30' class="width233"/>
                        <label for="lbl_classification">Classifica&ccedil;&atilde;o problema:</label> 
                        <select class="width233" name="status" id="Classificacao_Problema">
                            <option>Selecione ...</option>
                            <option value="1">A&ccedil;&atilde;o parlamentar</option>
                            <option value="2">A&ccedil;&otilde;es MPE</option>
                            <option value="3">A&ccedil;&otilde;es MPT</option>
                            <option value="4">Acordo Coletivo de Trabalho</option>
                            <option value="5">Amrigs</option>
                            <option value="6">Aplica&ccedil;&atilde;o EC29</option>
                            <option value="7">Brigada Militar</option>
                            <option value="8">CAPS (todos os tipos)</option>
                            <option value="9">Casas de Parto</option>
                            <option value="10">CBHPM</option>
                            <option value="11">CFC Detran</option>
                            <option value="12">Conselho Estadual de Sa&uacute;de</option>
                            <option value="13">Conselho Municipal da Sa&uacute;de (por cidade)</option>
                            <option value="14">Contratualiza&ccedil;&atilde;o</option>
                            <option value="15">Conven&ccedil;&otilde;es Coletivas de Trabalho</option>
                            <option value="16">Cremers</option>
                            <option value="17">Datasus</option>
                            <option value="18">Delegacia do Trabalho (capital)</option>
                            <option value="19">Delegacia do Trabalho (interior, munic&iacute;pio)</option>
                            <option value="20">Departamento M&eacute;dico Legal - DML</option>
                            <option value="21">Departamento M&eacute;dico Legal (capital)</option>
                            <option value="22">Departamento M&eacute;dico Legal (interior, munic&iacute;pio)</option>
                            <option value="23">EccoSalva</option>
                            <option value="24">Empregado P&uacute;blico</option>
                            <option value="25">ESF (para todos os munic&iacute;pios menos POA)</option>
                            <option value="26">ESF POA</option>
                            <option value="27">Farm&aacute;cia</option>
                            <option value="28">Farm&aacute;cia Estadual</option>
                            <option value="29">Farm&aacute;cia Municipal</option>
                            <option value="30">Farm&aacute;cia Popular</option>
                            <option value="31">Fehosul</option>
                            <option value="32">Funda&ccedil;&atilde;o de Sa&uacute;de Canoas</option>
                            <option value="33">Grupo Hospitalar Concei&ccedil;&atilde;o - GHC</option>
                            <option value="34">Guarda Municipal (munic&iacute;pio)</option>
                            <option value="35">Guarda Municipal (POA)</option>
                            <option value="36">HMIPV</option>
                            <option value="37">HNSG Canoas</option>
                            <option value="38">Hospitais POA (categoria gen&eacute;rica para os demais hospitais)</option>
                            <option value="39">Hospital Centen&aacute;rio</option>
                            <option value="40">Hospital de Alvorada</option>
                            <option value="41">Hospital de Cl&iacute;nicas de Porto Alegre – HCPA</option>
                            <option value="42">Hospital de Pronto Socorro (munic&iacute;pios)</option>
                            <option value="43">Hospital de Viam&atilde;o</option>
                            <option value="44">Hospital Eernesto Dorneles – HED</option>
                            <option value="45">Hospital Filantr&oacute;pico</option>
                            <option value="46">Hospital Get&uacute;lio Vargas</option>
                            <option value="47">Hospital M&atilde;e de Deus</option>
                            <option value="48">Hospital Padre Geremia</option>
                            <option value="49">Hospital Porto Alegre</option>
                            <option value="50">Hospital Privado</option>
                            <option value="51">Hospital P&uacute;blico (munic&iacute;pio)</option>
                            <option value="52">Hospital S&atilde;o Camilo</option>
                            <option value="53">Hospital S&atilde;o Lucas (da PUC)</option>
                            <option value="54">HPS</option>
                            <option value="55">HPS Canoas</option>
                            <option value="56">HU Canoas</option>
                            <option value="57">Imesf POA</option>
                            <option value="58">Insalubridade</option>
                            <option value="59">IPERGS</option>
                            <option value="60">Lei de Responsabilidade Fiscal</option>
                            <option value="61">M&eacute;dico Plantonista</option>
                            <option value="62">M&eacute;dico Residente</option>
                            <option value="63">M&eacute;dico Rotineiro</option>
                            <option value="64">Mesa de Negocia&ccedil;&atilde;o do SUS</option>
                            <option value="65">Minist&eacute;rio da Sa&uacute;de</option>
                            <option value="66">Municipalizados POA</option>
                            <option value="67">Municip&aacute;rios (para todos os munic&iacute;pios menos POA)</option>
                            <option value="68">Municip&aacute;rios POA</option>
                            <option value="69">Negocia&ccedil;&otilde;es coletivas de trabalho (por cidade e/ou especialidades, v&iacute;nculos formais ou informais)</option>
                            <option value="70">PACS</option>
                            <option value="71">Periculosidade</option>
                            <option value="72">Perito M&eacute;dico (DML)</option>
                            <option value="73">Perito M&eacute;dico (INSS)</option>
                            <option value="74">Peritos INSS</option>
                            <option value="75">Planos de Sa&uacute;de</option>
                            <option value="76">Policia Civil</option>
                            <option value="77">Pol&iacute;tica de Medicamento</option>
                            <option value="78">Pronto Atendimento</option>
                            <option value="79">Radimagem</option>
                            <option value="80">Regula&ccedil;&atilde;o Municipal POA</option>
                            <option value="81">Regula&ccedil;&atilde;o Munic&iacute;pio</option>
                            <option value="82">Residência Multiprofissional</option>
                            <option value="83">SAMU (municipal)</option>
                            <option value="84">SAMU Estadual</option>
                            <option value="85">SAMU POA</option>
                            <option value="86">Santa Casa</option>
                            <option value="87">Santa Casa POA</option>
                            <option value="88">Sa&uacute;de Mental</option>
                            <option value="89">Secreataria de Sa&uacute;de (interior)</option>
                            <option value="90">Secretaria Estadual de Sa&uacute;de</option>
                            <option value="91">Secretaria Muncipal de Sa&uacute;de (regi&atilde;o metropolitana)</option>
                            <option value="92">Secretaria Muncipal de Sa&uacute;de de POA</option>
                            <option value="93">Servi&ccedil;o de Apoio Diagn&oacute;stico</option>
                            <option value="94">Servi&ccedil;o de Sa&uacute;de (descrever os principais)</option>
                            <option value="95">Sindiberf</option>
                            <option value="96">Sindihospa</option>
                            <option value="97">Sobreaviso</option>
                            <option value="98">SUS Capital</option>
                            <option value="99">Tribunal de Contas da Uni&atilde;o</option>
                            <option value="100">Tribunal Regional do Trabalho</option>
                            <option value="101">Tribunal de Contas do Estado</option>
                            <option value="102">Unicred</option>
                            <option value="103">Unidade B&aacute;sica de Sa&uacute;de (capital)</option>
                            <option value="104">Unidade B&aacute;sica de Sa&uacute;de (interior, munic&iacute;pio)</option>
                            <option value="105">Unidade B&aacute;sica de Sa&uacute;de (metropolitana exceto POA)</option>
                            <option value="106">Unidade de Tratamento Intensivo</option>
                            <option value="107">Unimed</option>
                            <option value="108">UPA</option>
                        </select>                        
                        <label for="lbl_status">Status:</label>
                        <select class="width233" name="status" id="status">
                            <option>Selecione ...</option>
                            <option value="1">Aberto</option>
                            <option value="2">Fechado</option>
                        </select>
                        <label for="lbl_data_conclusao_old">Data da Conclus&atilde;o:</label>
                        <input type="text" name='data_conclusao_old' size="30" class="width233"/>                        
                        <label for="lbl_responsavel">Respons&aacute;vel(s):</label>
                        <input type="text" name="responsavel" size='30' class="width233"/>
                        <input type="submit" name="editar" value="Buscar"/>
                    </fieldset>                        
                </form>
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
                            $sql1 = "SELECT id, id_atas, cidade, grupo, problema, Classificacao_Problema, acao, status, DATE_FORMAT(data_conclusao, '%d/%c/%Y') as data_conclusao, responsavel 
                                FROM Atas_Problemas 
                                WHERE cidade like '%$cidade%' and 
                                    grupo like '%$grupo%' and
                                      Classificacao_Problema = '$Classificacao_Problema' and
                                          status = '$status' and
                                              data_conclusao = '$data_conclusao' and
                                                  responsavel like '%$responsavel%'
                                ORDER BY id DESC";
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
                                echo '<td width=220>';
                                echo '<a class="btn btn-success" href="Atas_Visualizacao_Problemas.php?id='.$row1['id_atas'].'">Ver</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="Atas_Edicao_Problemas.php?id='.$row1['id'].'">Editar</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="delete_Problemas.php?id='.$row1['id'].'">Excluir</a>';                                                                
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