<?php

require 'lessc.inc.php';

/**
 * Classe permettant de gérer le rendu CSS d'une page.
 *
 * @author marechal
 */
class CssRenderer implements Renderer { 
   
    /**
     * Moteur de conversion LESS vers CSS.
     * @var lessc
     */
    public $lessc;
    
    /**
     * Constructeur.
     */
    public function __construct() {
        // Instatiation du moteur LessC
        $this->lessc = new lessc();
        // Indiquer où chercher les feuilles en import
        $this->lessc->setImportDir(STYLE_FOLDER);
    }
    
    /**
     * Indiquer la page à afficher et vérifie qu'elle peut être appelée.
     * @param string $pagePath Chemin souhaité.
     * @return bool <code>true</code> si initialisation réussie, <code>false</code> sinon.
     */
    public function setPage($pagePath){
        // Résoudre le chemin du répertoire du fichierLESS
        $realPagePath = realpath(STYLE_FOLDER . DIRECTORY_SEPARATOR . $pagePath . ".less");
        
        // Si le fichier existe
        if (file_exists($realPagePath)            
        // S'il est dans le répertoire styles
        && startsWith($realPagePath, STYLE_FOLDER)){
            // On peut appeler le fichier LESS
            return true;
        }
        // Echec de l'appel
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
        // On précise dans l'entête de renvoi qu'il s'agit d'un fichier css
        header("Content-Type: text/css");
        // Résoudre le chemin du fichier de style LESS
        $realPagePath = realpath(STYLE_FOLDER . DIRECTORY_SEPARATOR . $pagePath . ".less");
        
        // Générer le nom du fichier de cache
        $cacheFile = LESSC_CACHE_FOLDER . DIRECTORY_SEPARATOR . $pagePath . ".cache";

        // Cache de la feuille chargé en mémoire
        $cache = $realPagePath;
        
        // Si le fichier de cache existe
        if (file_exists($cacheFile)) {
            // Charger le fichier de cache;
            $cache = unserialize(file_get_contents($cacheFile));
        }

        // Compiler le cache actuel, en forçant sa régénération s'il le faut
        $newCache = $this->lessc->cachedCompile($cache, $reloadCache);

        // Si le cache n'existe pas où a été mis à jour
        if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
            // Ecraser le fichier de cache avec les nouvelles valeurs
            file_put_contents($cacheFile, serialize($newCache));
        }
        // Renvoyer le fichier LESS compilé
        return $newCache['compiled'];
    }
}
