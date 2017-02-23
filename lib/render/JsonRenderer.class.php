<?php

/**
 * Classe permettant de gérer le rendu JSON d'une page.
 *
 * @author marechal
 */
class JsonRenderer implements Renderer {
 
    /**
     * Indiquer la page à afficher et vérifie qu'elle peut être appelée.
     * @param string $pagePath Chemin souhaité.
     * @return bool <code>true</code> si initialisation réussie, <code>false</code> sinon.
     */
    public function setPage($pagePath){
        // Résoudre le chemin du répertoire demandée
        $realPagePath = realpath(PAGE_FOLDER . DIRECTORY_SEPARATOR . $pagePath);
        
        // Si le répertoire existe
        if (file_exists($realPagePath)            
        // S'il est dans le répertoire pages
        && startsWith($realPagePath, PAGE_FOLDER)
        // Et que le fichier data.php existe 
        && file_exists($realPagePath . DIRECTORY_SEPARATOR . 'ajax.php')){
            // Charger les spécifications de la page
            require($realPagePath . DIRECTORY_SEPARATOR . 'ajax.php');

            // La page a été initialisée
            return true;                
        }

        // Echec de l'initialisation de la page
        return false;
    }
    
   /**
     * Renvoi le rendu du template en fonction des données envoyés.
     * @param string $pagePath Chemin souhaité.
     * @param array $pageDatas Données du template.
     * @param bool $reloadCache Doit-on recharger le cache ?
     * @return string Le rendu généré par le moteur.
     */
    public function render($pagePath, $pageDatas, $reloadCache = false){
        return json_encode($pageDatas);
    }
}
