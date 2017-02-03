<?php
    // Initialiser la session PHP
    session_start();
    
    // Charger les librairies
    require("lib/tools.php");

    // Initialiser la page par défaut
    $pageToShow = filter_input(INPUT_GET, "page", FILTER_SANITIZE_URL);
    // Si la page n'est pas spécifiée
    if (!isset($pageToShow) || empty($pageToShow)){
        // Afficher la page d'index
        $pageToShow = "index";
    }
    // Initialiser le moteur de template
    $template = new Template();
    
    try{
        // Si l'initialisation du template a échoué
        if (!$template->setPage($pageToShow)){
            // Afficher une page d'erreur 404
            $template->setPage("erreur404");
        }

        $template->render();
    }
    // En cas d'erreur
    catch(Exception $ex){
        // Afficher la page spécifique
        $template->setPage("erreur500");
        $template->render();
    }