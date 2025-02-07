<?php

class Database {
    private $host = '192.168.56.10';
    private $username = 'user_quizz';
    private $password = 'P@ssw0rd';
    private $dbname = 'QUIZZ';
    private $port = 3306;
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname, $this->port);
        if ($this->connection->connect_error) {
            die("Erreur de connexion : " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}


// Utilisation de la classe Database
$database = new Database();
$conn = $database->getConnection();

// Redirection vers la page d'accueil
header("Location: page_test.php");
exit();


?>
