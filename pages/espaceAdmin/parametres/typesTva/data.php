<?php

// Si on a aucune superadmin en session
if (!Admin::sessionSuperAdminActive()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

Config::get("RENDER_MANAGER")->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Espace Administration - Gestion des types de TVA",
    "admin" => Admin::recupererSessionActive(),
    "typesTva" => TypeTva::chargerTout(),
    "activeMenu" => "parametres",
    "activeSubMenu" => "typesTva",
);
