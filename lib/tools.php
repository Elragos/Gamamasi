<?php
    /**
     * Vérifier si la chaîne spécifiée commence par une autre chaîne.
     * 
     * @param string $haystack Chaîne où chercher.
     * @param string $needle Chaîne à trouver.
     * @return bool <code>true</code> si trouvé, <code>false</code> sinon.
     */
    function startsWith($haystack, $needle) {
        $length = strlen($needle);
        
        return (substr($haystack, 0, $length) === $needle);
    }
    
    /**
     * Logger une exception dans les fichiers de logs.
     * 
     * @param Exception $exception Exception générée
     */
    function logException($exception){
        // Récupérer la date du jour
        $today = new DateTime();
        
        // Récupérér la page concernée
        $formattedError = "{$today->format("Y-m-d H:i:s")} : Error executing {$exception->getFile()} line {$exception->getLine()}" . PHP_EOL;

        // Rajouter l'erreur en elle-même
        $formattedError .= $exception->getMessage() . PHP_EOL . $exception->getTraceAsString() . PHP_EOL;
        
        // Générer le nom du fichier de logs en fonction de la date du jour
        $logFile = ERRORS_LOGS_FOLDER . DIRECTORY_SEPARATOR . $today->format("Ymd") . ".log";
        
        // Ajouter à la fin du fichier, ou le créer si inexistant
        file_put_contents($logFile, $formattedError, FILE_APPEND);
    }
    
    /**
     * Renvoie l'URL absolue de la page demandée.
     * 
     * @param string $page La page demandée.
     * @param bool $action Est-ce l'URL d'action sur la page ?
     * @return URL L'URL ainsi générée.
     */
    function getAbsoluteURL($page, $action = false){        
        return BASE_URL . $page . ($action ? ".do" : ".html");
    }
    
    /**
     * Détruire la session active, pour une déconnexion complète et propre.
     */
    function destroySession(){
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
    }