<?php 

// Utilisation de la classe Database
$database = new Database();
$conn = $database->getConnection();

// Redirection vers la page d'accueil
header("Location: page_test.php");
exit();
?>
