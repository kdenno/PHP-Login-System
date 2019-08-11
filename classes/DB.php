<?php
class DB
{
    private static $_instance = null;
    private $_pdO,
        $error = false,
        $_query,
        $_results,
        $count = 0;

    // connect to database
    private function __construct()
    {
        try {
            $this->_pdO = new PDO('mysql:host=' . Config::get('mysql/host') . '; dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        // check if already instantiated
        if (!isset(self::$_instance)) {
            // set it
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
}
