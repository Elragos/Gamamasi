<?php
    require_once 'tools.php';
    require_once 'variables.php';
    // Chargement des classes internes

    require_once 'classes/internal/DbManager.class.php';
    // Chargement des classes Objets Transverses
    require_once 'classes/Adresse.class.php';
    // Partie FrontOffice
    require_once 'classes/FrontOffice/Client.class.php';
    require_once 'classes/FrontOffice/Membre.class.php';
    require_once 'classes/FrontOffice/SecteurActivite.class.php';
    require_once 'classes/FrontOffice/TypeMembre.class.php';
    require_once 'classes/FrontOffice/TypeTva.class.php';
    // Partie BackOffice
    require_once 'classes/BackOffice/Admin.class.php';
    // Chargement du moteur de rendu
    require_once 'classes/render/RenderManager.class.php';
    