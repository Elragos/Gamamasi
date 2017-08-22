<?php

// Si on a aucune session SuperAdmin active
if (!Admin::sessionSuperAdminActive()){
    // Rediriger sur la page de connexion admin
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

Config::get("RENDER_MANAGER")->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Espace Administration - Paramètres globaux",
    "admin" => Admin::recupererSessionActive(),
    "activeMenu" => "parametres"
);
