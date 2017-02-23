<?php
require 'Renderer.php';
require 'CssRenderer.class.php';
require 'HtmlRenderer.class.php';
require 'JsonRenderer.class.php';

class RenderManager {
    /**
     * Données de la page
     * @var array.
     */
    public $pageDatas;
    
    /**
     * Chemin vers le répertoire de la page.
     * @var string
     */
    public $pageDir;
    
    /**
     * Moteur de rendu HTML.
     * @var HtmlRenderer
     */
    private $htmlRenderer;
    
    /**
     * Moteur de rendu JSON.
     * @var JsonRenderer
     */
    private $jsonRenderer;
    
    /**
     * Moteur de rendu CSS.
     * @var CssRenderer
     */
    private $cssRenderer;
    
    /**
     * Moteur de rendu courant, par défaut HTML.
     * @var int
     */
    public $currentRenderEngine = 0;
    
    /**
     * Constante pour indiquer l'utilisation du moteur de rendu HTML.
     */
    const RENDER_HTML = 0;
    /**
     * Constante pour indiquer l'utilisation du moteur de rendu JSON.
     */
    const RENDER_JSON = 1;
    /**
     * Constante pour indiquer l'utilisation du moteur de rendu CSS.
     */
    const RENDER_CSS = 2;
    
    /**
     * Initialiser le moteur de rendu courant et le renvoi.
     * @return Renderer Le moteur de rendu initialisé.
     */
    public function initCurrentEngine() {
        switch ($this->currentRenderEngine){
            case RenderManager::RENDER_HTML:
                $this->htmlRenderer = new HtmlRenderer();
                return $this->htmlRenderer;
            case RenderManager::RENDER_JSON:
                $this->jsonRenderer = new JsonRenderer();
                return $this->jsonRenderer;
            case RenderManager::RENDER_CSS:
                $this->cssRenderer = new CssRenderer();
                return $this->cssRenderer;
        }        
    }
   
    /**
     * Récupérer le moteur de rendu courant.
     * @return BasicRenderer Le moteur de rendu courant.
     */
    private function getCurrentRenderEngine(){        
        switch ($this->currentRenderEngine){
            case RenderManager::RENDER_HTML:
                return $this->htmlRenderer;
            case RenderManager::RENDER_JSON:
                return $this->jsonRenderer;
            case RenderManager::RENDER_CSS:
                return $this->cssRenderer;
        }      
    }
    
    /**
     * Indiquer au moteur de rendu courant la page à charger.
     * @param string $pagePath Le fichier à utiliser
     * @return bool <code>true</code> si initialisation réussie, <code>false</code> sinon.
     */
    public function setPage($pagePath){        
        // Récupérer le moteur de rendu courant
        $currentEngine = $this->getCurrentRenderEngine();
        // Si le moteur n'est pas initialisé
        if (!isset($currentEngine)){
            // On l'initialise
            $currentEngine = $this->initCurrentEngine();
        }
        
        // Si l'initialisation du moteur de rendu a réussi
        if($currentEngine->setPage($pagePath)){                
            // Mémoriser le chemin vers la page
            $this->pageDir = $pagePath;
            // L'initialisation a réussi
            return true;
        }
        // Echec de l'initialisation
        return false;
    }
    
    /**
     * Générer le rendu en fonction du moteur et des données.
     * @return string Le rendu en fonction du moteur et des données.
     */
    public function render(){
        $currentEngine = $this->getCurrentRenderEngine();
        
        return $currentEngine->render($this->pageDir, $this->pageDatas);
    }
}