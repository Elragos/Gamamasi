<?php

// Si on a aucune session SuperAdmin active
if (!Admin::sessionActiveExistante()){
    // Rediriger sur la page de connexion admin
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Espace Administration - Paramètres globaux",
    "admin" => Admin::recupererSessionActive(),
    "secteurs" => SecteurActivite::chargerTout(),
    "activeMenu" => "secteursActivites",
);
