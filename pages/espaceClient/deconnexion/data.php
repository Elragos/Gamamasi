<?php

// Vider la session
session_unset();
$_SESSION = array();

// Détruie le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger sur la page de connexion client
header("Location: " . getAbsoluteURL("espaceClient/index"));  
// Fin du script
exit();
