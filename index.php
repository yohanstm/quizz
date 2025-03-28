<?php
// Inclure la classe de gestion des pages
include("controleur.php");

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$monapp = new AppMVC();


switch ($page) {
    case 1:
        // Page principale où on choisit la catégorie
        $monapp->pagePrincipal();
        break;

    case 2:
        // Page où on affiche les questions pour la catégorie sélectionnée
        $monapp->page2();
        break;

    case 3: 

        $monapp -> page3();

    default:
        // Page par défaut (redirection vers la page principale si nécessaire)
        $monapp->pagePrincipal();
        break;
}
?>
