<?php
namespace Mumux\Server;

class MySqlDatabase
{

    private static $_instance;
    private static $database;

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new MySqlDatabase();
        }
        return self::$_instance;
    }

    public static function getDatabase(){

        if (is_null(self::$_instance)) {
            self::$_instance = new MySqlDatabase();
        }
        return self::$database;
    }

    private function __construct()
    {
        // load the database informations
        $dsn = \Mumux\Configuration::get("dsn");
        $login = \Mumux\Configuration::get("login");
        $pwd = \Mumux\Configuration::get("pwd");

        // Create connection
        self::$database = new \PDO($dsn, $login, $pwd, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        self::$database->exec("SET CHARACTER SET utf8");
    }

}
