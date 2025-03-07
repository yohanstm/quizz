<?php

	include("POO.php");
	include("template/template.php");

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
			
			if($mapage == 1) $this -> pagePrincipal();
			else if($mapage == 2) $this -> page1();
			else $this -> pagePrincipal();
			
			$this -> bdd -> deconnexion();
		}
		public function pagePrincipal(){

			$categorie = $this -> bdd -> getCategorie();
			$vue = new Template("template/pagePrincipale.html");

			$htmlTexte ="";
			foreach($categorie as $cat){
				$htmlTexte .= '<form action="index.php?page=2" method="POST">
                        <input type="hidden" name="categorie" value="' . $cat['id_cat'] . '">
                        <button type="submit">' . $cat['nom'] . '</button>
                    </form>';
			}
			$vue -> remplacer("#LESCATEGORIE", $htmlTexte);

			echo $vue -> getSortie();
		}
		public function page1() {
			session_start(); 
		

			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categorie'])) {
				$id_categorie = $_POST['categorie'];
				$_SESSION['categorie'] = $id_categorie; 
				echo "<p>Catégorie sélectionnée : $id_categorie</p>";

			} else if (isset($_SESSION['categorie'])) {
				$id_categorie = $_SESSION['categorie']; 
			} else {
				echo "<h2>Veuillez choisir une catégorie avant de jouer.</h2>";
				echo '<a href="index.php?page=1"><button>Retour</button></a>';
				return;
			}
		
			$question = $this->bdd->getQuestions(1, $id_categorie);
			if (!$question) {
				echo "<h2>Aucune question trouvée pour cette catégorie.</h2>";
				return;
			}
		
			$reponses = $this->bdd->getReponses($question->id);
			$vue = new Template("template/question.html");
		
			$vue->remplacer('#TITRE_QUESTION#', $question->intitule);
		
			$html_texte = "";
			foreach ($reponses as $reponse) {
				if ($question->question_multiple) {
					$html_texte .= '<li><input type="checkbox" name="reponse" value="'.$reponse->id_reponse.'"> '.$reponse->intitule.'</li>';
				} else {
					$html_texte .= '<li><input type="radio" name="reponse" value="'.$reponse->id_reponse.'"> '.$reponse->intitule.'</li>';
				}
			}
		
			$vue->remplacer('#LISTE_REPONSES#', $html_texte);
			echo $vue->getSortie();
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
			$questions = $this -> bdd -> getQuestions(1,1);
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