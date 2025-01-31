<?php 

$password = 'P@ssw0rd';
$username = 'user_quizz';
$servername = '192.168.56.10';
$dbname = 'QUIZZ';
$port = 3306;


$mysqli = new mysqli($servername, $username, $password, $dbname, $port);


if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}


// header("accueil.php");
echo "Let's gooo, connexion réussie !";


// $mysqli -> close();
// echo "vous etes deconnecter";



?>
