<?php
    require_once 'tools.php';
    require_once 'variables.php';
    // Chargement des classes internes
    require_once 'classes/internal/Config.class.php';
    require_once 'classes/internal/DbManager.class.php';
    // Partie Front Office & Back Office
    require_once 'classes/Office/Adresse.class.php';
    require_once 'classes/Office/Admin.class.php';
    require_once 'classes/Office/Bureau.class.php';
    require_once 'classes/Office/Client.class.php';
    require_once 'classes/Office/Membre.class.php';
    require_once 'classes/Office/Option.class.php';
    require_once 'classes/Office/Salle.class.php';    
    require_once 'classes/Office/SecteurActivite.class.php';
    require_once 'classes/Office/TypeMembre.class.php';
    require_once 'classes/Office/TypeTva.class.php';
    // Chargement du moteur de rendu
    require_once 'classes/render/RenderManager.class.php';
    