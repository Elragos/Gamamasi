<?php

// Si on a aucune session administration active
if (!Admin::sessionActiveExistante()){
    // Rediriger sur la page de connexion admin
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

Config::get("RENDER_MANAGER")->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Espace Administration - Mon Profil",
    "admin" => Admin::recupererSessionActive(),
    "activeMenu" => "profil"
);
