<?php 

class Database {

    private string $dsn ="mysql:dbname=api_rest;host=localhost";
    private string $username = "root";
    private $password = "";
    protected static $_instance =null;
    public $conn = null;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->username, $this->password);
        } catch (PDOException $e) {
           echo "Erreur de connexion :" . $e->getMessage();
        }
    }

    public static function getInstance(){
        if (self::$_instance == null) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function getConnetion(){
        return $this->conn;
    }

}

