<?php
// Si on a un client en session
if (Customer::hasActiveSession()){
    // Rediriger sur le profil client
    header("Location: " . getAbsoluteURL("espaceClient/profil"));  
    // Fin du script
    exit();
}

$error = !empty(filter_input(INPUT_GET, "error"));

$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    // Indiquer le titre de la page
    "title" => "Espace Client - Authentification",
    "error" => $error
);
