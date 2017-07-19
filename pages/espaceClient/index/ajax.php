<?php

// Si on a pas de client en session
if (!Client::sessionActiveExistante()){
    // On récupère les identifiants de connexion
    $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);

    // On récupère le client correspondant
    $client = Client::authentfication($login, $password);

    // Si non trouvé
    if ($client == null){
        // On redirige vers la page de connexion, en indiquant l'erreur
        header("Location: " . getAbsoluteURL("espaceClient/index") . "?error=1");  
        // Fin du script
        exit();
    }

    // Sinon, on enregistre le client en session
    $client->mettreEnSession();
}

// On redirige vers son profil
header("Location: " . getAbsoluteURL("espaceClient/profil"));  
// Fin du script
exit();

