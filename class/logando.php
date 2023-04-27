<?php
    include "../config/db/conecta.php";
    $login = $_POST["login"];
    $senha = $_POST["senha"];    
    $verifyUser = mysql_query("select count(*) from usuarios where ldap_user = '$login' and senha = '$senha'");        
    $loguei = mysql_num_rows($verifyUser);
    
    if($loguei === 1)
    {
        header ("Location: http://pessoal3.simers.org.br/index.php");
        exit(0);
    }
    else
    {
        header("Location: http://pessoal3.simers.org.br/login.php");    
        exit(0);
    }
?>