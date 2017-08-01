<?php
    require 'tools.php';
    // Chargement des classes internes
    require 'internal/variables.php';
    require 'internal/DbManager.class.php';
    // Chargement des classes Objets    
    require 'classes/Adresse.class.php';
        // Partie client
    require 'classes/Client/Client.class.php';
    require 'classes/Client/Membre.class.php';
    require 'classes/Client/SecteurActivite.class.php';
    require 'classes/Client/TypeMembre.class.php';
    // Chargement du moteur de rendu
    require 'render/RenderManager.class.php';
    