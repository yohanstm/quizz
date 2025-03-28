<?php

	include("POO.php");
	include("template/template.php");

	class AppMVC {

		private $bdd;

		public function __construct() {
			$this -> bdd = new Database();
		}

		public function pagePrincipal() {
			$categorie = $this->bdd->getCategorie();
			// $id_cat_test = $this -> bdd-> getIdCategorie();

			$vue = new Template("template/pagePrincipale.html");
			$htmlTexte = "";
			foreach($categorie as $cat) {
				$htmlTexte .=  '<li> <input type="radio" name="categorie" value="' . $cat['id_cat'] . '" required> ' . $cat['nom'] . ' </li>';
			}
			$vue->remplacer("#LESCATEGORIE", $htmlTexte);
			echo $vue->getSortie();
		}

		
		public function page1() {
			session_start();
			echo "ID Categorie recu ". ($_GET['categorie'] ?? 'aucune');
			$vue = new Template("template/question.html");
		
			// Récupérer l'ID de la catégorie depuis l'URL
			if (isset($_GET['categorie'])) {
				$id_categorie = $_GET['categorie']; 
				$_SESSION['categorie'] = $id_categorie; // Sauvegarde dans la session
			} 
			// Vérifier si une catégorie est déjà en session
			else if (isset($_SESSION['categorie'])) {
				$id_categorie = $_SESSION['categorie']; 
			} 
			else {
				echo "<h2>Veuillez choisir une catégorie avant de jouer.</h2>";
				echo '<a href="index.php?page=1"><button>Retour</button></a>';
				return;
			}
		
			// Récupérer la question de cette catégorie
			$question = $this->bdd->getQuestions(1, $id_categorie);
			if (!$question) {
				echo "<h2>Aucune question trouvée pour cette catégorie.</h2>";
				return;
			}
		
			// Récupérer les réponses associées
			$reponses = $this->bdd->getReponses($question->intitule);
		
			// Remplacer les placeholders dans le template
			$vue->remplacer('#TITRE_QUESTION', $question->intitule);
		
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
		public function pageTest(){
			session_start();

			// Vérifier si l'ID de la catégorie est passé dans l'URL
			if (isset($_GET['categorie'])) {
				$_GET['categorie'] =   
				$_SESSION['categorie']; 
			} else {
				echo "<h2>Veuillez choisir une catégorie avant de jouer.</h2>";
				echo '<a href="index.php?page=1"><button>Retour</button></a>';
				return;
			}

			// Utiliser l'ID pour récupérer les questions de la catégorie choisie
			$this->afficherQuestions($$_SESSION['categorie']); // Appel de la méthode pour afficher les questions en fonction de l'ID
		}

		public function page2() {
			session_start();
		
		

			if (!isset($_SESSION['categorie'])) {
				echo "<h2>Veuillez choisir une catégorie avant de continuer.</h2>";
				echo '<a href="index.php?page=1"><button>Retour</button></a>';
				return;
			}
		

			$id_categorie = $_SESSION['categorie'];
		
			echo "<h2>Catégorie sélectionnée : " . htmlspecialchars($id_categorie) . "</h2>";
		

			$questions = $this->bdd->getQuestions($id_categorie);
		

			if (empty($questions)) {
				echo "<h2>Aucune question trouvée pour cette catégorie.</h2>";
				return;
			}
		

			foreach ($questions as $question) {
				echo "<h3>Question : " . $question->intitule . "</h3>";
			}
		}
		
			
			

        public function page3(){
			session_start();
						
			if(isset($_POST['categorie'])){
				$_SESSION['categorie'] = $_POST['categorie'];
			}

			$id_categorie = $_SESSION['categorie'] ?? null; 

			if(!$id_categorie){
				echo('Probleme la categorie a pas pu etre selectionner correctement'); 
				echo('<a href="index.php?page=1"><button>Retour</button></a>');
			}

			echo '<h2> Categorie selectionner : '. htmlspecialchars($id_categorie) . '</h2>';

			// on va recup les question //

			$questions = $this -> bdd -> getQuestions($id_categorie);
			

			if (!$questions) {
				echo "<h2>Aucune question trouvée pour cette catégorie.</h2>";
				return;
			}
		
			// Affichage des questions et réponses
			foreach ($questions as $question) {
				echo "<h1>Numéro de la question : " . $question->id . "<br> " . $question->question . "</h1>";
				$reponses = $this->bdd->getReponses($question ->id);
				echo "<ul>";

				foreach($reponses as $reponse){
					echo"<li>";
					echo $reponse -> intitule;
					if ($reponse->est_correct) {
						echo " (Bonne réponse)";
					}
					echo "</li>";
				}
				echo "</ul>";
			}
		
		

		}

		public function afficherQuestions($id_categorie) {
			session_start(); 
		
			if (!isset($id_categorie)) {
				echo "<h2>Veuillez choisir une catégorie avant de jouer.</h2>";
				echo '<a href="index.php?page=1"><button>Retour</button></a>';
				return;
			}
		
			$questions = $this->bdd->getQuestions($id_categorie);
			if (!$questions) {
				echo "<h2>Aucune question trouvée pour cette catégorie.</h2>";
				return;
			}
		
			$vue = new Template("template/question.html");
		
			foreach ($questions as $question) {
				$reponses = $this->bdd->getReponses($question->id);
				
				$vue->remplacer('#TITRE_QUESTION#', $question->intitule);
				
				$html_texte = "";
				foreach ($reponses as $reponse) {
					if ($question->question_multiple) {
						$html_texte .= '<li><input type="checkbox" name="reponse[]" value="'.$reponse->id_reponse.'"> '.$reponse->intitule.'</li>';
					} else {
						$html_texte .= '<li><input type="radio" name="reponse" value="'.$reponse->id_reponse.'"> '.$reponse->intitule.'</li>';
					}
				}
		
				$vue->remplacer('#LISTE_REPONSES#', $html_texte);
			}
		
			echo $vue->getSortie();
		}
		
	}
?>

