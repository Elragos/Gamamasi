<?php
    // Racine du site
    define("ROOT_FOLDER", realpath(__DIR__  . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".."));
    // Répertoire des pages du site
    define("PAGE_FOLDER", realpath(ROOT_FOLDER . DIRECTORY_SEPARATOR . 'pages' ));
    // Répertoire de cache
    define("CACHE_FOLDER", realpath(ROOT_FOLDER . DIRECTORY_SEPARATOR . 'cache'));
    // Répertoire de cache Smarty
    define("SMARTY_CACHE_FOLDER", realpath(CACHE_FOLDER . DIRECTORY_SEPARATOR . 'smarty'));
    // Répertoire de cache LessC
    define("LESSC_CACHE_FOLDER", realpath(CACHE_FOLDER . DIRECTORY_SEPARATOR . 'lessc'));
    // Répertoire de style (images, CSS ...)
    define("STYLE_FOLDER", realpath(ROOT_FOLDER . DIRECTORY_SEPARATOR . 'style'));
    // Répertoire de logs
    define("LOGS_FOLDER", realpath(ROOT_FOLDER . DIRECTORY_SEPARATOR . 'logs'));
    // Répertoire de logs d'erreurs
    define("ERRORS_LOGS_FOLDER", realpath(LOGS_FOLDER . DIRECTORY_SEPARATOR . 'errors'));
    
    // Calculer l'URL racine du site
    DEFINE('HTTP_TYPE', filter_input(INPUT_SERVER, "REQUEST_SCHEME", FILTER_SANITIZE_URL));
    DEFINE('HTTP_ROOT',filter_input(INPUT_SERVER, "HTTP_HOST", FILTER_SANITIZE_URL));
    DEFINE('HTTP_FOLDER', dirname(filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_URL)) . '/');
    DEFINE('BASE_URL', HTTP_TYPE . "://" . HTTP_ROOT . HTTP_FOLDER);