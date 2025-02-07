<?php
// Inclure la classe Database
include('POO.php');

// Créer une instance de la classe Database
$db = new Database();

// Récupérer toutes les questions
$questions = $db->getQuestions();

// Afficher chaque question et ses réponses possibles
foreach ($questions as $question) {
    echo "<h3>" . $question['question'] . "</h3>";
    echo "<p>Catégorie : " . $question['categorie'] . " | Difficulté : " . $question['difficulte'] . "</p>";

    // Récupérer les réponses pour cette question
    $reponses = $db->getReponses($question['id']);
    
    // Afficher chaque réponse
    foreach ($reponses as $reponse) {
        echo "<p>" . $reponse['reponse'] . " (" . ($reponse['est_correct'] ? "Correct" : "Incorrect") . ")</p>";
    }
}
?>
