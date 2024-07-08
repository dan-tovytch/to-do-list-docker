<?php

define('DB_HOST', 'db');
define('DB_NAME', 'tolist');
define('DB_USER', 'root');
define('DB_PASS', '12345bf');
define('DB_CHARSET', 'utf8mb4');

class Database
{
    private $host = DB_HOST;
    private $db = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $charset = DB_CHARSET;
    private $pdo;
    private $error;

    public function __construct(){
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function getConnection(){
        return $this->pdo;
    }
}

$db = new Database();
$connection = $db->getConnection();

if ($connection) {
//    echo "Conectou ao banco de dados com sucesso!";
} else {
    echo " Deu merda em algo";
}