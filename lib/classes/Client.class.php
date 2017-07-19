<?php

/**
 * Représentation d'un client.
 *
 * @author marechal
 */
class Client {
    /**
     * Identifiant DB de l'utilisateur.
     * @var int 
     */
    public $id = 0;
    /**
     * Nom du client.
     * @var string 
     */
    public $nom;
    /**
     * Prénom de l'utilisateur.
     * @var string 
     */
    public $prenom;
    /**
     * Email de l'utilisateur.
     * @var string 
     */
    public $mail;
    /**
     * Mot de passe de l'utilisateur.
     * @var string 
     */
    private $password;
    /**
     * Date de naissance de l'utilisateur
     * @var DateTime 
     */
    public $dateNaissance;
    /**
     * Adresse du client.
     * @var Adresse 
     */
    public $adresse;
    /**
     * Téléphone du client.
     * @var string 
     */
    public $telephone;
    /**
     * SIRET de l'entreprise
     * @var string
     */
    public $SIRET;
    /**
     * Raison Sociale de l'entreprise
     * @var string
     */
    public $raisonSociale;
    /**
     * Date de création du client.
     * @var DateTime
     */
    public $dateCreation;
    /**
     * Date de dernière modification du client.
     * @var DateTime
     */
    public $dateModification;
    /**
     * Est-ce que le client est visible ? Si faux, alors il est logiquement supprimé.
     * @var bool 
     */
    public $visible;
    /**
     * Secteur d'activié du client.
     * @var SecteurActivite
     */
    public $secteurActivite;
    
    /**
     * Nom de l'index dans le tableau de session
     * @var string 
     */
    private static $NOM_VARIABLE_SESSION = "client";
   
    /**
     * Constructeur.
     * @param string $nom Nom du client.
     * @param string $prenom Prénom de l'utilisateur.
     * @param string $mail Email de l'utilisateur.
     * @param string $password Mot de passe de l'utilisateur.
     * @param DateTime $dateNaissance Date de naissance de l'utilisateur
     * @param Adresse $adresse Adresse du client.
     * @param string $telephone Téléphone de l'utilisateur.
     * @param int $id Identifiant de l'utilisateur.
     * @param string $SIRET Téléphone de l'utilisateur.
     * @param string $raisonSociale Téléphone de l'utilisateur.
     * @param DateTime $dateCreation Date de création du client.
     * @param DateTime $dateModification Date de dernière modification du client.
     * @param bool $visible Téléphone de l'utilisateur.
     * @param SecteurActivite $secteurActivite Secteur d'activié du client.
     */
    public function __construct($nom, $prenom, $mail, $password, $dateNaissance, $adresse, $telephone = null, $id = 0,
            $SIRET = null, $raisonSociale = null, $dateCreation = null, $dateModification = null, $visible = true, $secteurActivite = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
        $this->password = $password;
        $this->dateNaissance = $dateNaissance;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
        $this->SIRET = $SIRET;
        $this->raisonSociale = $raisonSociale;
        $this->dateCreation = $dateCreation;
        $this->dateModification = $dateModification;
        $this->visible = $visible;
        $this->secteurActivite = $secteurActivite;
    }
    
    /**
     * Sauvegarder l'utilisateur (gère l'insertion et la mise à jour)
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    public function sauvegarde(){
        // Si l'identifiant est défini
        if ($this->id > 0){
            // On met à jour la DB
            return $this->miseAJour();
        }
        // Sinon
        else{
            // On insert en DB
            return $this->insertion();
        }
    }
    
    /**
     * Ajoute en DB l'utilisateur.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function insertion(){       
        // On exécute la requête d'insertion, en récupérant l'id d'insertion
        $id = $_SESSION["DB_MANAGER"]->exec(
            // param 1: requête préparée
            "INSERT INTO wam_client("
                . "Nom, Prenom, DateNaissance, Password, Telephone, Mail, Adresse1, Adresse2, Adresse3, CodePostal, Ville,"
                . "DateCreation, DateModification, SIRET, raison_sociale, visible, Id_secteur_activite"
            . ") VALUES ("
                . ":Nom, :Prenom, :DateNaissance, :Password, :Telephone, :Mail, :Adresse1, :Adresse2, :Adresse3, :CodePostal, :Ville,"
                . ":DateCreation, :DateModification, :SIRET, :raison_sociale, :visible, :Id_secteur_activite"
            . ");",
            // param 2: valeurs issues du formulaire
            $this->parametresSQL(false),
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
    private function miseAJour(){
        // On exécute la requête de mise à jour, en récupérant le nb de lignes modifiés
        $count = $_SESSION["DB_MANAGER"]->exec(
            // param 1: requête préparée
            "UPDATE `wam_client` SET"
                . "Nom = :Nom,"
                . "Prenom = :Prenom,"
                . "DateNaissance = :DateNaissance,"
                . "Password = :Password,"
                . "Telephone = :Telephone,"
                . "Mail = :Mail,"
                . "Adresse1 = :Adresse1,"
                . "Adresse2 = :Adresse2,"
                . "Adresse3 = :Adresse3,"
                . "CodePostal = :CodePostal,"
                . "Ville = :Ville,"
                . "DateCreation = :DateCreation, "
                . "DateModification = :DateModification,"
                . "SIRET = :SIRET,"
                . "raison_sociale = :raison_sociale,"
                . "visible = visible,"
                . "Id_secteur_activite = :Id_secteur_activite"
            . "WHERE`IdClient`= :id;",
            // param 2: valeurs issues du formulaire
            $this->parametresSQL(),
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
    public function parametresSQL($addId = true){        
        $result = array(
            "Nom" => $this->nom,
            "Prenom" => $this->prenom,
            "Mail" => $this->mail,
            "Password" => $this->password,
            "Telephone" => $this->telephone,
            "DateNaissance" => $this->dateNaissance->format("Y-m-d"),
            "Adresse1" => $this->adresse->ligne1,
            "Adresse2" => $this->adresse->ligne2,
            "Adresse3" => $this->adresse->ligne3,
            "CodePostal" => $this->adresse->codePostal,
            "Ville" => $this->adresse->ville,
            "SIRET" => $this->SIRET,
            "raison_sociale" => $this->raisonSociale,
            "DateCreation" => $this->dateCreation->format("Y-m-d H:i:s"),
            "DateModification" => $this->dateModification->format("Y-m-d H:i:s"),
            "visible" => $this->visible,
            "Id_secteur_activite" => $this->secteurActivite->ID
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
     * @param string $mail Le mail du client.
     * @param string $password Le mot de passe du client.
     * @return Client Le client trouvé, ou <code>null</code> si non trouvé.
     */
    public static function authentfication($mail, $password){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $datas = $_SESSION["DB_MANAGER"]->exec(
            "SELECT * FROM wam_client WHERE
                mail = :mail
                AND password = :password",
            array(
                "mail" => $mail,
                "password" => $password
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = Client::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger un utilisateur depuis son Identifiant DB.
     * 
     * @param int $id Identifiant DB du client.
     */
    public static function charger($id){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $datas = $_SESSION["DB_MANAGER"]->exec(
            "SELECT * FROM wam_client WHERE IdClient = :id",
            array(
                "id" => $id
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = Client::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger la liste complète des clients.
     * 
     * @return Array[Client] La liste des clients dans la DB.
     */
    public static function chargerTout(){
        // Déclaration du résultat
        $result = array();
        
        // Récupération des données du client
        $datasList = $_SESSION["DB_MANAGER"]->exec("SELECT * FROM wam_client");
       
        // Pour chaque résultat
        foreach ($datasList as $datas){
            // Charger depuis les résultats
           $result[] = Client::chargerDepuisRetourSQL($datas);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Créer un client à partir des données d'un tableau associatif.
     * 
     * @param Array[String] $datas Le tableau associatif contenant les données à charger.
     * @return Client Le client ainsi créé.
     */
    private static function chargerDepuisRetourSQL($datas){        
        // On créé l'objet adresse
        $adresse = new Address(
            $datas["Adresse1"],
            $datas["CodePostal"],
            $datas["Ville"],
            $datas["Adresse2"],
            $datas["Adresse3"]
        );

        // On créé l'objet client et on le renvoie
        return new Client(
            $datas["Nom"],
            $datas["Prenom"],
            $datas["Mail"],
            $datas["Password"],
            DateTime::createFromFormat("Y-m-d", $datas["DateNaissance"]),
            $adresse,
            $datas["Telephone"],
            $datas["IdClient"],
            $datas["SIRET"],
            $datas["raison_sociale"],
            DateTime::createFromFormat("Y-m-d H:i:s", $datas["DateCreation"]),
            DateTime::createFromFormat("Y-m-d H:i:s", $datas["DateModification"]),
            $datas["visible"],
            SecteurActivite::charger($datas["Id_secteur_activite"])
        );
    }
    
    /**
     * Mettre le client dans la session courante.
     */
    public function mettreEnSession(){
        $_SESSION[Client::$NOM_VARIABLE_SESSION] = $this;
    }
    
    /**
     * Est-ce qu'un client est enregistré dans la session courante ?
     * 
     * @return bool <code>true</code> si oui, <code>false</code> si non.
     */
    public static function sessionActiveExistante(){
        // On a une session client si la variable session "customer" est définie
        return isset($_SESSION[Client::$NOM_VARIABLE_SESSION])
            // Et qu'elle n'est pas vide.
            && !empty($_SESSION[Client::$NOM_VARIABLE_SESSION]);
    }
    
    /**
     * Récupérer le client actuellement en session.
     * 
     * @return Client Le client trouvé, ou <code>null</code> si non trouvé.
     */
    public static function recupererSessionActive(){
        // Si on a aucune session client active
        if (!Client::sessionActiveExistante()){
            // On ne renvoie rien
            return null;
        }
        // Renvoyer le client en session
        return $_SESSION[Client::$NOM_VARIABLE_SESSION];
    }
    
    /**
     * Merge les données du client avec celles enregistrées en session.
     * 
     * @param Client $client Objet client à merger.
     */
    public static function mergerAvecSessionActive($client){
        // Si on a un client en session
        if (Client::sessionActiveExistante()){
            // Récupérer la session courante
            $sessionClient = Client::recupererSessionActive();
        
            // Récupérer l'identifiant du client
            $client->id = $sessionClient->id;

            // Si le mot de passe n'a pas été renseigné
            if (empty($client->password)){
                // Récupérer celui de la session
                $client->password = $client->password;
            }
            
            // Récupérer la date de création
            $client->dateCreation = $sessionClient->dateCreation;
             // Récupérer la date de dernière modification       
            $client->dateModification = $sessionClient->dateModification;
            // Récupérer la visibilité
            $client->visible = $sessionClient->visible;
        }     
    }
    
    /**
     * Créer un objet client à partir d'un formulaire.
     * 
     * @param bool $isPostForm Le formulaire est-il envoyé en POST ?
     * @return Client Le client ainsi généré.
     */
    public static function recupererDepuisFormulaireHTML($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);
        
        // On créé l'objet adresse
        $adresse = new Adresse(
            $requestParameters["Adresse1"],
            $requestParameters["CodePostal"],
            $requestParameters["Ville"],
            $requestParameters["Adresse2"],
            $requestParameters["Adresse3"]
        );
        
        $result =  new Client(
            $requestParameters["Nom"],
            $requestParameters["Prenom"],
            $requestParameters["Mail"],
            $requestParameters["Password"],
            DateTime::createFromFormat("Y-m-d", $requestParameters["DateNaissance"]),
            $adresse,
            $requestParameters["Telephone"],
            0, // Identifiant DB
            $requestParameters["SIRET"],
            $requestParameters["RaisonSociale"],
            new DateTime(), // Date de création
            new DateTime(), // Date de dernière modification
            true,
            SecteurActivite::charger($requestParameters["IdSecteurActivite"])
        );
        
        // Si on a une session active
        if (Client::sessionActiveExistante()){
            // Merger avec les données de la session
            Client::mergerAvecSessionActive($result);
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
        return $this->prenom . " " . $this->nom . "(" . $this->mail . ")\n"
            . "Né le " . $this->dateNaissance->format("d/m/Y") . '\n'
            . "Créé le " . $this->dateCreation->format("d/m/Y") . " à " . $this->birthDate->format("H/i/s") . '\n'
            . "Modifié le " . $this->dateModification->format("d/m/Y") . " à " . $this->birthDate->format("H/i/s") . '\n'
            . "Email : " . $this->mail . "\n"
            . "Adresse : " . $this->adresse . "\n"
            . "SIRET : " . $this->SIRET . "\n"
            . "Raison Social : " . $this->raisonSociale . "\n"
            . "Visible: " . $this->visible . "\n"
            . "Secteur d'activité : " . $this->secteurActivite;
    }
}
