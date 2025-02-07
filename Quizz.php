<?php
// Inclure la classe Database
include('Database.php');

// Créer une instance de la classe Database
$db = new Database();

// Vérifier si l'utilisateur a sélectionné une catégorie
if (isset($_GET['categorie_id'])) {
    $categorie_id = $_GET['categorie_id'];
    
    // Récupérer toutes les questions pour la catégorie sélectionnée
    $questions = $db->getConnection()->query("
        SELECT q.id, q.intitule AS question, q.difficulte
        FROM Question q
        WHERE q.id_cat = $categorie_id
    ");
    
    // Afficher le nom de la catégorie choisie
    $categorie = $db->getConnection()->query("SELECT * FROM Categorie WHERE id_cat = $categorie_id")->fetch_assoc();
    echo "<h2>Quiz - " . $categorie['nom'] . "</h2>";
    
    echo "<form action='resultat.php' method='POST'>";
    
    // Afficher les questions et les réponses
    while ($question = $questions->fetch_assoc()) {
        echo "<h3>" . $question['question'] . "</h3>";
        echo "<p>Difficulté : " . $question['difficulte'] . "</p>";
        
        // Récupérer les réponses pour cette question
        $reponses = $db->getReponses($question['id']);
        
        // Afficher chaque réponse sous forme de radio buttons
        foreach ($reponses as $reponse) {
            echo "<label>";
            echo "<input type='radio' name='reponse[" . $question['id'] . "]' value='" . $reponse['id_reponse'] . "'>";
            echo $reponse['reponse'];
            echo "</label><br>";
        }
    }

    echo "<button type='submit'>Soumettre</button>";
    echo "</form>";
} else {
    echo "Aucune catégorie sélectionnée.";
}
?>
