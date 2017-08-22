<?php

/**
 * Classe représenant la configuration du site.
 *
 * @author marechal
 */
class Config {
    /**
     * Tableau de données.
     * @var Array[Mixed]
     */
    private $datas;
    
    /**
     * Instance unique de la classe
     * @var Config 
     */
    private static $instance = null;
    
    /**
     * Constructeur privé. On fait une classe monoinstance.
     */
    private function __construct(){
        $this->datas = array();
    }
    
    /**
     * Récupérer la valeur d'une clé de configuration
     * @param string $configKey Nom de la clé de configuration.
     * 
     * @return Mixed La valeur correspondante si trouvé, NULL sinon.
     */
    public static function get($configKey){
        // Si la clé de config est défini
        if (isset(Config::getInstance()->datas[$configKey])){
            // Retourner la valeur correspondante
            return Config::getInstance()->datas[$configKey];
        }
        // Sinon on renvoi null
        return null;
    }
    
    /**
     * Ajoute ou écrase une clé de configuration.
     * @param string $configKey La clé de configuration.
     * @param Mixed $configValue La nouvelle valeur de cette clé.
     */
    public static function set($configKey, $configValue){        
        Config::getInstance()->datas[$configKey] = $configValue;
    }
    
    /**
     * Mise à jour de la configuration en fonction d'un tableau associatif de config (type clé => valeur).
     * @param Array[Mixed] $configArray
     */
    public static function setMutliple($configArray){
        // Pour chaque item du tableau
        foreach($configArray as $configKey => $configValue){
            // Ajouter dans la configuration
            Config::set($configKey, $configValue);
        }
    }
    
    /**
     * Récupérer l'instance objet de la configuration actuelle.
     * 
     * @return Config L'objet configuration actuel.
     */
    public static function getInstance(){
        // Si le singleton n'est pas initialisé
        if (Config::$instance == null){
            // On l'initialise
            Config::$instance = new Config();
        }
        // Renvoyer l'objet configuration
        return Config::$instance;
    }
}
