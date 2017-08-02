<?php

// Si on a pas d'administrateur en session
if (!Admin::sessionActiveExistante()){
    // On récupère les identifiants de connexion
    $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);

    // On récupère le client correspondant
    $admin = Admin::authentfication($login, $password);

    // Si non trouvé
    if ($admin == null){
        // On redirige vers la page de connexion, en indiquant l'erreur
        header("Location: " . getAbsoluteURL("espaceAdmin/index") . "?error=1");  
        // Fin du script
        exit();
    }

    // Sinon, on enregistre le client en session
    $admin->mettreEnSession();
}

// On redirige vers son profil
header("Location: " . getAbsoluteURL("espaceAdmin/profil"));  
// Fin du script
exit();

