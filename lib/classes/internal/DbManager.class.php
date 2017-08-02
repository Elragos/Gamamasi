<?php

/**
 * Classe utilisé pour faciliter la connexion à la DB.
 *
 * @author marechal
 */
class DbManager {
    /**
     * Hôte de la DB.
     * @var URL 
     */
    private $DbHost;
    /**
     * Port de connexion pour la DB.
     * @var int
     */
    private $DbPort;
    /**
     * Nom de la base de donnée.
     * @var string
     */
    private $DbName;
    /**
     * Utilisateur pour la connexion à la DB en lecture.
     * @var string 
     */
    private $DbReaderLogin;
    /**
     * Mot de passe pour la connexion à la DB en lecture.
     * @var string 
     */
    private $DbReaderPassword;
    /**
     * Utilisateur pour la connexion à la DB en écriture.
     * @var string 
     */
    private $DbWriterLogin;
    /**
     * Mot de passe pour la connexion à la DB en écriture.
     * @var string 
     */
    private $DbWriterPassword;
    
    /**
     * Constructeur. Prend 4 ou 6 paramères.
     * @param string $host Hôte de la DB. Requis.
     * @param int $port Port de connexion. Requis.
     * @param string $dbName Nom de la DB. Requis.
     * @param string $tablePrefix Préfixe des tables. Requis.
     * @param string $dbWriterLogin Utilisateur pour écriture. Requis.
     * @param string $dbWriterPassword Mot de passe pour écriture. Requis.
     * @param string $dbReaderLogin Utilisateur pour lecture. Optionnel.
     * @param string $dbReaderPassword Mot de passe pour lecture. Requis si $dbReaderLogin rempli.
     */
    public function __construct() {
        // Nombre d'arguments en paramètres.
        $ctp = func_num_args();
        // Arguments en paramètres
        $args = func_get_args();
        
        // On va regarder le nb de paramètres
        switch($ctp) {
            // 5 paramètres requis : hôte, port, nom, login écriture, password écriture
            case 5:
                $this->DbHost = $args[0];
                $this->DbPort = $args[1];
                $this->DbName = $args[2];
                $this->DbWriterLogin = $args[3];
                $this->DbWriterPassword = $args[4];       
                $this->DbReaderLogin = $args[3];
                $this->DbReaderPassword = $args[4];
                
                break;
            // 7 paramètres : ajout de login lecture et password lecture
            case 7:
                $this->DbHost = $args[0];
                $this->DbPort = $args[1];
                $this->DbName = $args[2];
                $this->DbWriterLogin = $args[3];
                $this->DbWriterPassword = $args[4];       
                $this->DbReaderLogin = $args[5];
                $this->DbReaderPassword = $args[6];
                
                break;
             default:
                break;
        }
    }
    
    /**
     * Connexion à la DB.
     * @param bool $reader Est-on en lecture ?
     */
    private function connectDB($reader = true){
        $user = $this->DbWriterLogin;
        $pass = $this->DbWriterPassword;
        
        // Si mode lecture
        if ($reader){
            $user = $this->DbReaderLogin;
            $pass = $this->DbReaderPassword;
        }
        // Sinon, mode écriture 
        
        // Ouverture de la connexion
        return new PDO('mysql:host=' . $this->DbHost . ":" . $this->DbPort . ";dbname=" . $this->DbName, $user, $pass, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));  // On indique qu'on travaille en UTF8
    }
    
    /**
     * Exécuter une requête.
     * @param string $request Requête à exécuter.
     * @param bool $reading Est-ce une requête de lecture ?
     * @return array Résultats de la requête.
     */
    public function exec($request, $requestParameters = array(), $reading = true){
        // Déclaration du résultat
        $result = false;
        // Connexion à la DB.
        $db = $this->connectDB($reading);      
        
        
        // On prépare la requête
        $statement = $db->prepare($request);
        // On l'exécute
        $statement->execute($requestParameters);

        // var_dump($statement->errorInfo());
        
        // On fait le matching si lecture
        if ($reading){
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);        
        }
        // Sinon 
        else{
            // On récupère le dernier ID inséré
            $result = $db->lastInsertId();
            // Si aucun
            if ($result == 0){
                // On compte le nb de lignes affectées par la requête
                $result = $statement->rowCount();
            }
        }
        // Fermeture de la DB
        unset($db);        
        // Renvoi du résultat
        return $result;
    }
    
    /**
     * A la destruction de l'objet, effacer le contenu des variables.
     */
    public function __destruct() {
        unset($this->DbHost);
        unset($this->DbPort);
        unset($this->DbWriterLogin);
        unset($this->DbWriterPassword);       
        unset($this->DbReaderLogin);
        unset($this->DbReaderPassword);
    }
}
