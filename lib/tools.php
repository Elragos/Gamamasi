<?php
    require 'config.php';
    require 'render/RenderManager.class.php';

    /**
     * Vérifier si la chaîne spécifiée commence par une autre chaîne.
     * @param string $haystack Chaîne où chercher.
     * @param string $needle Chaîne à trouver.
     * @return bool <code>true</code> si trouvé, <code>false</code> sinon.
     */
    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        
        return (substr($haystack, 0, $length) === $needle);
    }
    
    /**
     * Logger une exception dans les fichiers de logs.
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