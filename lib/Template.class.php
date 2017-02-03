<?php

require 'smarty/Smarty.class.php';

/**
 * Classe simplifiant la gestion du templating.
 *
 * @author marechal
 */
class Template {
    /**
     * Instance de Smarty.
     * @var type Smarty.
     */
    private $smarty;
    
    /**
     * Layout utilisé.
     * @var string.
     */
    public $pageLayout;
    
    /**
     * Chemin vers le contenu utilisé.
     * @var string.
     */
    public $pageBody;
    
    /**
     * Titre de la page
     * @var string.
     */
    public $pageTitle;

    /**
     * Constructeur.
     */
    public function __construct() {
        // Instatiation du moteur Smarty
        $this->smarty = new Smarty();
        $this->smarty->setCacheDir(CACHE_FOLDER . DIRECTORY_SEPARATOR . "result");
        $this->smarty->setCompileDir(CACHE_FOLDER . DIRECTORY_SEPARATOR ."compile");
    }
    
    /**
     * Indiquer la page à afficher.
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
        // Si le fichier data.php existe
        && file_exists($realPagePath . DIRECTORY_SEPARATOR . 'data.php')){            
            // Assigner le layout par défaut
            $this->pageLayout = PAGE_FOLDER . DIRECTORY_SEPARATOR . "layout.tpl";            
            
            // Charger les spécifications de la page
            require($realPagePath . DIRECTORY_SEPARATOR . 'data.php');
            
            // La page a été initialisée
            return true;
        }
        // Echec de l'initialisation de la page
        return false;
    }
    
    /**
     * Afficher le rendu HTML.
     */
    public function render(){
        $this->smarty->assign("title", $this->pageTitle);
        $this->smarty->assign("body", $this->pageBody);
        $this->smarty->display($this->pageLayout);
    }
}
