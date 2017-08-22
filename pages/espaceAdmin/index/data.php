<?php
// Si on a un client en session
if (Admin::sessionActiveExistante()){
    // Rediriger sur le profil client
    header("Location: " . getAbsoluteURL("espaceAdmin/profil"));  
    // Fin du script
    exit();
}

$error = !empty(filter_input(INPUT_GET, "error"));

Config::get("RENDER_MANAGER")->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Espace Administration - Authentification",
    "error" => $error
);
