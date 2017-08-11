<?php

// Si on a aucune superadmin en session
if (!Admin::sessionSuperAdminActive()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Espace Administration - Gestion des types de membre",
    "admin" => Admin::recupererSessionActive(),
    "typesMembre" => TypeMembre::chargerTout(),
    "activeMenu" => "parametres",
    "activeSubMenu" => "typesMembre",
);
