<?php

class Database {
    private $host = '192.168.56.10';
    private $username = 'user_quizz';
    private $password = 'P@ssw0rd';
    private $dbname = 'QUIZZ';
    private $port = 3306;
    private $connection;

    public function __construct() {
        $this->connexion();
    }

    public function connexion() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname, $this->port);
    
        // Vérifier si la connexion a échoué
        if ($this->connection->connect_error) {
            die(" Erreur de connexion : " . $this->connection->connect_error);
        }
    
        return $this->connection;
    }
    

    public function getConnection() {
        return $this->connection;
    }

    public function deconnexion() {
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
        $reponses = [];	//Servira a stocker la liste des reponses

		/* On crée la requete SQL et on lie les paramètres */
		$requete = $this -> connection-> prepare("SELECT r.id_reponse, r.intitule FROM Reponses r WHERE id_question=?");
		$requete -> bind_param('i', $question_id);
		
		/* On execute la requete et on récupère le résultat */
		$requete -> execute();
		$resultat = $requete -> get_result();
		
		/* On libère la requête */
		$requete -> close();
		
		
		/* On parcours les résultats pour les stocker */
		while ($enregistrement = $resultat -> fetch_object()) {
			$reponses[] = $enregistrement;	//On ajoute un element avec un l'id et l'intitule à la suite de nos réponses
		}
		
	
		return $reponses;		//On retourne les réponses de la question
	}

    public function getCategorie(){

        $req = "select ";
    }
}


?>
