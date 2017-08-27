<?php
// Si on a aucun client en session
if (! Client::sessionActiveExistante()){
    // Rediriger sur le profil client
    header("Location: " . getAbsoluteURL("espaceClient/index"));  
    // Fin du script
    exit();
}

Config::get("RENDER_MANAGER")->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Espace Client - Réserver un espace",
    "client" => Client::recupererSessionActive(),
    "activeMenu" => "reservation",
);
