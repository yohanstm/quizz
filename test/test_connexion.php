

<?php

// test connexion bases de donnée 

include("POO.php"); // Assure-toi que le chemin est correct

// Créer une instance de la base de données
$bdd = new Database();

// Vérifier si la connexion est établie
if ($bdd->connexion()) {
    echo " Connexion réussie à la base de données !";
} else {
    echo " Échec de la connexion à la base de données.";
}

?>
