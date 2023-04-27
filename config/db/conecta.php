<?php
    $db['server']   = "192.168.0.8";
    $db['user']     = "root";
    $db['password'] = "4ZQu43fg3Hn79U";
    $db['dbname']   = 'simers';    
    $conn = mysql_connect($db['server'], $db['user'], $db['password']);
    mysql_select_db($db['dbname'], $conn);
?>
