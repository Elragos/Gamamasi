<?php

// On récupère les identifiants de connexion
$login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);

// On récupère le client correspondant
$customer = Customer::loginCustomer($login, $password);

// Si non trouvé
if ($customer == null){
    // On redirige vers la page de connexion, en indiquant l'erreur
    header("Location: " . getAbsoluteURL("espaceClient/index") . "?error=1");  
    // Fin du script
    exit();
}

// Sinon, on enregistre le client en session
$_SESSION["customer"] = $customer;
// On redirige vers son profil
header("Location: " . getAbsoluteURL("espaceClient/profil"));  
// Fin du script
exit();

