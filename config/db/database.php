<?php
class Database
{
    private static $dbname = 'simers';
    private static $dbHost = '192.168.0.8';
    private static $dbUsername = 'root';
    private static $dbUserPassword = '4ZQu43fg3Hn79U';
    private static $cont = null;
    
    public function __construct() {
        die('não rolou');
    }
    
    public static function connect()
    {
        if (null == self::$cont)
        {
            try
            {
                self::$cont = new PDO("mysql:host=".self::$dbHost.";"."dbname=".self::$dbname,self::$dbUsername,self::$dbUserPassword);
            }
            catch (PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }
    
    public static function disconnect()
    {
        self::$cont = null;
    }           
}
?>
