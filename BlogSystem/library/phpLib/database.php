<?php

namespace Lib;

class Database {
    private static $db = NULL;
    
    private function __construct() {
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASS;
        $dbName = DB_NAME;
        
        $db = new \mysqli($host, $username, $password, $dbName);
        
        self::$db = $db;
    }
    
    public static function get_instance() {
        static $instance = NULL;
        
        if ($instance === NULL) {
            $instance = new static();
        }
        
        return $instance;
    }
    
    public static function getDb() {
        return self::$db;
    }
}