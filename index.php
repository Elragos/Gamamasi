<?php
// Charger les librairies
require("lib/includes.php");

// Initialiser la session PHP
session_start();

// Charger la configuration
require("lib/config.php");
require("lib/db.php");

/* Utile pour debugger les formulaires 
echo("paramètres GET : ");
var_dump($_GET);

echo("paramètres POST : ");
var_dump($_POST);
 */

// initialisation du moteur de template
Config::set("RENDER_MANAGER", new RenderManager());

// Récupérer la page demandée
$userPage = filter_input(INPUT_GET, "page", FILTER_SANITIZE_URL);
// Récupérer la demande AJAX
$ajaxPage = filter_input(INPUT_GET, "ajax", FILTER_SANITIZE_URL);
// Récupérer la demande CSS
$cssPage = filter_input(INPUT_GET, "css", FILTER_SANITIZE_URL);

// Initialiser la page par défaut (index)
$pageToShow = "index";
// Indiquer par défaut que l'on a pas de demande AJAX
$isAjaxRequest = false;

// Si la page est spécifiée
if (isset($userPage) && !empty($userPage)){
    // Afficher cette page
    $pageToShow = $userPage;
    // Indiquer l'utilisation du moteur HTML
    Config::get("RENDER_MANAGER")->currentRenderEngine = RenderManager::RENDER_HTML;
}

// Si demande AJAX
if (isset($ajaxPage) && !empty($ajaxPage)){
    // Utiliser cette page
    $pageToShow = $ajaxPage;
    // Instancier le template JSON
    Config::get("RENDER_MANAGER")->currentRenderEngine = RenderManager::RENDER_JSON;
}

// Si demande CSS
if (isset($cssPage) && !empty($cssPage)){
    // Utiliser cette page
    $pageToShow = $cssPage;
    // Instancier le template JSON
    Config::get("RENDER_MANAGER")->currentRenderEngine = RenderManager::RENDER_CSS;
}

try{
    // Si l'initialisation du template a échoué
    if (!Config::get("RENDER_MANAGER")->setPage($pageToShow)){
        // Afficher une page d'erreur 404
        Config::get("RENDER_MANAGER")->setPage("internal/erreur404");
    }
}
// En cas d'erreur
catch(Exception $ex){
    // Logger l'erreur
    logException($ex, $pageToShow);
    
    // Indiquer l'utilisation du moteur HTML
    Config::get("RENDER_MANAGER")->currentRenderEngine = RenderManager::RENDER_HTML;

    Config::get("RENDER_MANAGER")->setPage("internal/erreur500");
}

// Afficher le résultat
echo(Config::get("RENDER_MANAGER")->render());

