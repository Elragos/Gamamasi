<?php
    require 'config.php';
    require 'Template.class.php';
    

	
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