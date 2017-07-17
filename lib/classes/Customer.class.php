<?php

/**
 * Représentation d'un client.
 *
 * @author marechal
 */
class Customer {
    /**
     * Identifiant DB de l'utilisateur.
     * @var int 
     */
    public $id = 0;
    /**
     * Nom du client.
     * @var string 
     */
    public $lastname;
    /**
     * Prénom de l'utilisateur.
     * @var string 
     */
    public $firstname;
    /**
     * Identifiant de connexion de l'utilisateur.
     * @var string
     */
    public $login;
    /**
     * Mot de passe de l'utilisateur.
     * @var string 
     */
    private $password;
    /**
     * Email de l'utilisateur.
     * @var stirng 
     */
    public $email;
    /**
     * Date de naissance de l'utilisateur
     * @var DateTime 
     */
    public $birthDate;
    /**
     * Adresse du client.
     * @var Adresse 
     */
    public $address;
    /**
     * Téléphone du client.
     * @var string 
     */
    public $phone;
    
    public $timestamp_creation_fiche;

    /**
     * Constructeur.
     * @param string $lastname Nom du client.
     * @param string $firstname Prénom de l'utilisateur.
     * @param string $login Identifiant de connexion de l'utilisateur.
     * @param string $password Mot de passe de l'utilisateur.
     * @param string $email Email de l'utilisateur.
     * @param date $birthDate Date de naissance de l'utilisateur
     * @param Adresse $address Adresse du client.
     * @param string $phone Téléphone de l'utilisateur.
     */
    public function __construct($lastname, $firstname, $login, $password, $email, $birthDate, $address, $phone = null) {
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->address = $address;
        $this->phone = $phone;
    }
    
    /**
     * Sauvegarder l'utilisateur (gère l'insertion et la mise à jour)
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    public function save(){
        if ($this->id > 0){
            return $this->update();
        }
        else{
            return $this->insert();
        }
    }
    
    /**
     * Ajoute en DB l'utilisateur.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function insert(){       
        // On exécute la requête d'insertion, en récupérant l'id d'insertion
        $id = $_SESSION["DB_MANAGER"]->exec(
            // param 1: requête préparée
            "INSERT INTO wam_client (
                nom,
                prenom,
                identifiant,
                password,
                email,
                tel,
                date_naissance,
                adresse1,
                adresse2,
                code_postal,
                ville
            )
            VALUES(
                :nom,
                :prenom,
                :identifiant,
                :password,
                :email,
                :tel,
                :date_naissance,
                :adresse1,
                :adresse2,
                :code_postal,
                :ville
            )",
            // param 2: valeurs issues du formulaire
            $this->toSqlArray(false),
            // param 3: true = lecture, false = écriture
            false
        );

        // Si la création a réussi
        if ($id > 0){
            // On récupère l'id nouvellement inséré en DB
            $this->id = $id;
        }
        
        return $id > 0;
    }
    /**
     * Met à jour en DB l'utilisateur.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function update(){
        // On exécute la requête de mise à jour, en récupérant le nb de lignes modifiés
        $count = $_SESSION["DB_MANAGER"]->exec(
            // param 1: requête préparée
            "UPDATE wam_client SET
                nom = :nom,
                prenom = :prenom,
                identifiant = :identifiant,
                password = :password,
                email = :email,
                tel = :tel,
                date_naissance = :date_naissance,
                adresse1 = :adresse1,
                adresse2 = :adresse2,
                code_postal = :code_postal,
                ville = :ville
            WHERE id = :id",
            // param 2: valeurs issues du formulaire
            $this->toSqlArray(),
            // param 3: true = lecture, false = écriture
            false
        );
        // L'insertion s'est bien passé si on a exactement 1 ligne inséré
        return $count == 1;
    }
    
    /**
     * Récupérer le client sous forme de tableau pour mise à jour en BDD.
     * 
     * @param bool $addId Doit-on ajouter l'identifiant DB ?
     * @return Array Les attributs sous forme de tableau.
     */
    public function toSqlArray($addId = true){
        $result = array(
            "nom" => $this->lastname,
            "prenom" => $this->firstname,
            "identifiant" => $this->login,
            "password" => $this->password,
            "email" => $this->email,
            "tel" => $this->phone,
            "date_naissance" => $this->birthDate->format("Y-m-d"),
            "adresse1" => $this->address->line1,
            "adresse2" => $this->address->line2,
            "code_postal" => $this->address->zipCode,
            "ville" => $this->address->town
        );
        // Ajouter l'identifiant DB si demandé
        if ($addId){
            $result["id"] = $this->id;
        }
        return $result;
    }
    
    /**
     * Récupérer un utilisateur par son identifiant et son mot de passe.
     * 
     * @param type $login L'identifiant du client.
     * @param type $password Le mot de passe du client.
     * @return Customer Le client trouvé, ou <code>null</code> si non trouvé.
     */
    public static function loginCustomer($login, $password){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $clientDatas = $_SESSION["DB_MANAGER"]->exec(
            "SELECT * FROM wam_client WHERE
                identifiant = :identifiant
                AND password = :password",
            array(
                "identifiant" => $login,
                "password" => $password
            )
        );
       
        // Si on a des résultats
        if (isset($clientDatas) && !empty($clientDatas)){
            // Charger depuis le premier résultat
           $result = Customer::loadFromDbResults($clientDatas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger un utilisateur depuis son Identifiant DB.
     * 
     * @param int $id Identifiant DB du client.
     */
    public static function load($id){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $clientDatas = $_SESSION["DB_MANAGER"]->exec(
            "SELECT * FROM wam_client WHERE IdClient = :id",
            array(
                "id" => $id
            )
        );
       
        // Si on a des résultats
        if (isset($clientDatas) && !empty($clientDatas)){
            // Charger depuis le premier résultat
           $result = Customer::loadFromDbResults($clientDatas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger la liste complète des clients.
     * 
     * @return Array[Customer] La liste des clients dans la DB.
     */
    public static function loadAll(){
        // Déclaration du résultat
        $result = array();
        
        // Récupération des données du client
        $clientListDatas = $_SESSION["DB_MANAGER"]->exec("SELECT * FROM wam_client");
       
        // Pour chaque résultat
        foreach ($clientListDatas as $clientDatas){
            // Charger depuis les résultats
           $result[] = Customer::loadFromDbResults($clientDatas);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Créer un client à partir des données d'un tableau associatif.
     * 
     * @param Array[String] $clientDatas Le tableau associatif contenant les données à charger.
     * @return Customer Le client ainsi créé.
     */
    private static function loadFromDbResults($clientDatas){        
        // On créé l'objet adresse
        $address = new Address(
            $clientDatas["adresse1"],
            $clientDatas["code_postal"],
            $clientDatas["ville"],
            $clientDatas["adresse2"]
        );

        // On créé l'objet client
        $result = new Customer(
            $clientDatas["nom"],
            $clientDatas["prenom"],
            $clientDatas["identifiant"],
            $clientDatas["password"],
            $clientDatas["email"],
            DateTime::createFromFormat("Y-m-d", $clientDatas["date_naissance"]),
            $address,
            $clientDatas["phone"]
        );

        // On lui assigne son id
        $result->id = $clientDatas["id"];
        
        $result->timestamp_creation_fiche =  $clientDatas["timestamp_creation_fiche"];
        
        // On retourne l'objet client ainsi créé
        return $result;
    }
    /**
     * Est-ce qu'un client est enregistré dans la session courante ?
     * 
     * @return bool <code>true</code> si oui, <code>false</code> si non.
     */
    public static function hasActiveSession(){
        // On a une session client si la variable session "customer" est définie
        return isset($_SESSION["customer"])
            // Et qu'elle n'est pas vide.
            && !empty($_SESSION["customer"]);
    }
    
    /**
     * Récupérer le client actuellement en session.
     * 
     * @return Customer Le client trouvé, ou <code>null</code> si non trouvé.
     */
    public static function getActiveSession(){
        // Si on a aucune session client active
        if (!Customer::hasActiveSession()){
            // On ne renvoie rien
            return null;
        }
        // Renvoyer le client en session
        return $_SESSION["customer"];
    }
    
    /**
     * Merge les données du client avec celles enregistrées en session.
     * 
     * @param Customer $customer Objet client à merger.
     */
    public static function mergeWithActiveSession($customer){
        $sessionCustomer = Customer::getActiveSession();
        
        // Récupérer l'identifiant du client
        $customer->id = $sessionCustomer->id;
        
        // Si le mot de passe n'a pas été renseigné
        if (empty($customer->password)){
            // Récupérer celui de la session
            $customer->password = $sessionCustomer->password;
        }
    }
    
    /**
     * Créer un objet client à partir d'un formulaire.
     * 
     * @param bool $isPostForm Le formulaire est-il envoyé en POST ?
     * @return Customer Le client ainsi généré.
     */
    public static function getFromHtmlForm($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);
        
        $result =  new Customer(
            $requestParameters["lastname"],
            $requestParameters["firstname"],
            $requestParameters["login"],
            $requestParameters["password"],
            $requestParameters["email"],
            DateTime::createFromFormat("Y-m-d", $requestParameters["birthdate"]),
            new Address(
                $requestParameters["addressLine1"],
                $requestParameters["zipCode"],
                $requestParameters["town"],
                empty($requestParameters["addressLine2"]) ? null : $requestParameters["addressLine2"],
                empty($requestParameters["addressLine3"]) ? null : $requestParameters["addressLine3"]
            ),
            empty($requestParameters["phone"]) ? null : $requestParameters["phone"]
        );
        
        // Si on a une session active
        if (Customer::hasActiveSession()){
            // Merger avec les données de la session
            Customer::mergeWithActiveSession($result);
        }
        // Renvoyer le client ainsi créé
        return $result;
    }
    
    /**
     * Renvoie une représentation du client sous forme de chaîne de caractères.
     * 
     * @return string Le client sous forme de chaîne de caractères.
     */
    public function __toString() {
        return $this->firstname . " " . $this->lastname . "(" . $this->login . ")" . "n"
            . "Né le " . $this->birthDate->format("d/m/Y") . " à " . $this->birthDate->format("h/i/s") . '\n'
            . "Email : " . $this->email . "\n"
            . "Adresse : " . $this->address . "\n"
            . "Téléphone : " . $this->phone;
    }
}
