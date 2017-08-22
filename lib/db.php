<?php
    // Identifiants pour la connexion à la DB, détruits après initialisation de DbManager
    $dbConfig = array(
        'DB_HOST' => "localhost",
        'DB_PORT' => "3306",
        'DB_NAME' => "wamco",
        'DB_TABLE_PREFIX' => "wam_",
        'DB_WRITING_USER' => "WamWriter",
        'DB_WRITING_PASSWORD' => "WamWriter",
        'DB_READING_USER' => "WamReader", // OPTIONNEL
        'DB_READING_PASSWORD' => "WamReader", // OPTIONNEL
    );
    
    // Initialiser le DbManager
    $dbManager = new DbManager(
        $dbConfig["DB_HOST"],
        $dbConfig["DB_PORT"],
        $dbConfig["DB_NAME"],
        $dbConfig["DB_WRITING_USER"],
        $dbConfig["DB_WRITING_PASSWORD"],
        $dbConfig["DB_READING_USER"],
        $dbConfig["DB_READING_PASSWORD"]
    );

    // Mise dans la configuration du préfixe de table
    Config::set("DB_TABLE_PREFIX", $dbConfig["DB_TABLE_PREFIX"]);
    
    // Détruire les variables de configuration de la DB
    unset($dbConfig);
    
    // Mise dans la configuration  de l'accès à la DB
    Config::set("DB_MANAGER", $dbManager);

    
    