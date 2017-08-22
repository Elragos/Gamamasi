<?php

// Si on a aucune session SuperAdmin active
if (!Admin::sessionActiveExistante()){
    // Rediriger sur la page de connexion admin
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

Config::get("RENDER_MANAGER")->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Espace Administration - Liste des clients",
    "admin" => Admin::recupererSessionActive(),
    "clients" => Client::chargerTout(),
    "activeMenu" => "listeClients",
);
