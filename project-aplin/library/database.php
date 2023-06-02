<?php
class DB {
    
    private static $db = null;

    public static function getInstance(){
        if (!self::$db) {
            self::connectDatabase();
        }

        return self::$db;
    }

    private static function connectDatabase(){
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        try {
            self::$db = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASS, $options);
        } 
        catch (PDOException $e) {
            self::$db = null;
        }
    }
}