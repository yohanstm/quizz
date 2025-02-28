<?php

	include("POO.php");


	class AppMVC {

		private $bdd;

		public function __construct() {
			$this -> bdd = new Database();
		}

		public function afficherPage($mapage) {
			if(!$this -> bdd -> connexion()) {//Connexion à la BDD
				echo "Une erreur est survenue à la connexion";
				return;
			}
			
			if($mapage == 1) $this -> page1();
			else if($mapage == 2) $this -> page2();
			else $this -> page1();
			
			$this -> bdd -> deconnexion();
		}
		
		public function page1() {
			echo "<h1> Bienvenue dans le Quizz </h1>";


            echo '<a href="index.php?page=2"><button>Aller à la page 2</button></a>';
			
		}
		
		public function page2() {
            $categories = $this -> bdd -> getCategorie();
			echo "Deuxieme page";
			
            echo "<h1> choissssssssssssir la categorie ! </h1>";
            echo '<ul>';
            foreach($categories as $categorie){
				echo '<li><input type="radio" name="reponses" value="'.$categorie['id_cat'].'"> '.$categorie['nom'].'</li>';
            }
            echo '</ul>';
        }
			

        public function page3(){

            $reponses  = $this -> bdd -> getReponses(1);
			$questions = $this -> bdd -> getQuestions(1);
            foreach($questions as $question){
				echo '<h1> Numéro de la question :'.$question -> id . "<br> " . $question -> question.'</h1>';
            }
            
            
			echo '<ul>';
			foreach($reponses as $reponse) {
				echo '<li><input type="radio" name="reponses" value="'.$reponse -> id.'"> '.$reponse -> intitule.'</li>';
			}
			echo '</ul>';			
			
		}

	}
?>