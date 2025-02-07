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
        try{
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname, $this->port);
        }catch (Exception $e){
            die("Erreur de connexion : " . $e->getMessage());
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

    public function requete(){
        $req = ("select * from Quizz;");
        $result = $this->connection->query($req); // Exécution de la requête
        return $result -> fetch_all(MYSQLI_ASSOC);;

    }

    public function getQuestions() {
        // Récupérer toutes les questions et leurs catégories
        $req = "
            SELECT q.id, q.intitule AS question, c.nom AS categorie, q.difficulte
            FROM Question q
            JOIN Categorie c ON q.id_cat = c.id_cat;
        ";
        $result = $this->connection->query($req);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getReponses($question_id) {
        // Récupérer toutes les réponses pour une question donnée
        $req = "
            SELECT r.intitule AS reponse, r.est_correct
            FROM Reponses r
            WHERE r.id_question = $question_id;
        ";
        $result = $this->connection->query($req);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategorie(){
        $req = "select ";
    }
}


?>
