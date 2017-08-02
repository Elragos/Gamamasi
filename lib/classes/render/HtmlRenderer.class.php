<?php

require 'smarty/Smarty.class.php';

/**
 * Classe permettant de gérer le rendu HTML d'une page.
 *
 * @author marechal
 */
class HtmlRenderer implements Renderer {
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
     * Constructeur.
     */
    public function __construct() {
        // Instatiation du moteur Smarty
        $this->smarty = new Smarty();
        // Activer le cache Smarty
        $this->smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
        // Spécifier le répertoire de cache
        $this->smarty->setCacheDir(SMARTY_CACHE_FOLDER . DIRECTORY_SEPARATOR . "result");
        // Spécifier l'endroi où mettre les pages compilés 
        $this->smarty->setCompileDir(SMARTY_CACHE_FOLDER . DIRECTORY_SEPARATOR ."compile");
        // Rajouter la fonction générant le chemin absolut d'une page
    }
    
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
        && file_exists($realPagePath . DIRECTORY_SEPARATOR . 'data.php')){
            // Assigner le layout par défaut
            $this->pageLayout = realpath(PAGE_FOLDER . DIRECTORY_SEPARATOR . "layout.tpl");            

            // Charger les spécifications de la page
            require($realPagePath . DIRECTORY_SEPARATOR . 'data.php');

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
        // Résoudre le chemin du répertoire demandée
        $realPagePath = realpath(PAGE_FOLDER . DIRECTORY_SEPARATOR . $pagePath) . DIRECTORY_SEPARATOR;
        
        // Si on doit recharger le cache ou que la page n'a pas été mise en cache
        if ($reloadCache){            
            // Nettoyer le cache pour ce fichier
            $this->smarty->clearCache($realPagePath . 'content.tpl');
        }
        
        // Assigner les données au template si elles existent
        if (!empty($pageDatas)){
            foreach($pageDatas as $dataName => $dataValue){
                $this->smarty->assign($dataName, $dataValue, true);
            }            
        }
        
        // Assigner le js relatif à la page s'il existe
        $this->smarty->assign("js", file_exists($realPagePath . "script.js") 
            ? file_get_contents($realPagePath . "script.js") : "", true);

        $this->smarty->assign("menuContent", $this->getMenuFromPage($realPagePath), true);

        // Assigner le corps de page
        $this->smarty->assign("bodyContent", $realPagePath . "content.tpl");

        // Assigner la racine du site
        $this->smarty->assign("rootURL", BASE_URL);

        // Afficher le template
        return $this->smarty->fetch($this->pageLayout);
    }
    
    /**
     * Récupérer le chemin vers le menu de la page.
     * @param string $realPagePath Le chemin de la page à afficher
     * @return string Le chemin vers le menu de la page, ou NULL si aucun.
     */
    private function getMenuFromPage($realPagePath){
        $result = null;
        // On initialise la recherche du menu la page courante
        $menuDirectory = $realPagePath;
        
        // On remonte dans l'arborescence pour trouver le menu correspondant
        while (file_exists($menuDirectory) && $result == null){
            // Si un menu est trouvé
            if(file_exists( $menuDirectory . DIRECTORY_SEPARATOR . "menu.tpl")){
                // On le récupère
                $result = $menuDirectory . DIRECTORY_SEPARATOR . "menu.tpl";
            }
            
            // Sinon
            else{
                // On remonte d'un répertoire
                $menuDirectory =  realpath($menuDirectory . DIRECTORY_SEPARATOR . "..");
                // Si on sort du répertoire de page
                if (!startsWith($menuDirectory, PAGE_FOLDER)){
                    // On arrête la recherche de répertoire
                    $menuDirectory = null;
                    break;
                }
            }
        }        
        return $result;
    }
}
/**
 * Fonction de transition pour récupérer l'URL de la page demandée.
 * 
 * @param Array $params Les paramètres définis dans le template.
 * @throws InvalidArgumentException Si la page n'est pas défini.
 */
function smarty_function_absoluteURL($params){
    // Récupérer les paramètres
    extract($params);
    
    // Si la page n'est pas défini
    if(!isset($page) || empty($page)){
        // Erreur 
        throw new InvalidArgumentException("Page must be specified");
    }
    // Si l'action n'est pas défini
    if(!isset($action) || empty($action)){
        // On la défini à false
        $action = false;
    }
    
    return getAbsoluteURL($page, $action);
}