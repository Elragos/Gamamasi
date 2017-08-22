<?php

/**
 * Représentation d'un administrateur Wam&Co.
 *
 * @author marechal
 */
class Admin {
    /**
     * Identifiant DB de l'administrateur.
     * @var int 
     */
    public $id = 0;
    /**
     * Nom de l'administrateur.
     * @var string 
     */
    public $nom;
    /**
     * Prénom de l'administrateur.
     * @var string 
     */
    public $prenom;
    /**
     * Email de l'administrateur.
     * @var string 
     */
    public $mail;
    
    /**
     * Identifiant de l'administrateur.
     * @var string 
     */
    public $login;
    
    /**
     * Mot de passe de l'administrateur.
     * @var string 
     */
    private $password;

    /**
     * Date de création de l'administrateur.
     * @var DateTime
     */
    public $dateCreation;
    /**
     * Date de dernière modification de l'administrateur.
     * @var DateTime
     */
    public $dateModification;
    /**
     * Est-ce un Super Administrateur ?
     * @var bool 
     */
    private $superAdmin;
    
    /**
     * Nom de l'index dans le tableau de session.
     * @var string 
     */
    private static $NOM_VARIABLE_SESSION = "admin";
   
    /**
     * Constructeur.
     * @param string $nom Nom de l'administrateur.
     * @param string $prenom Prénom de l'administrateur.
     * @param string $mail Email de l'administrateur.
     * @param string $login Identifiant de l'administrateur.
     * @param string $password Mot de passe de l'administrateur.
     * @param DateTime $dateCreation Date de création de l'administrateur.
     * @param DateTime $dateModification Date de dernière modification de l'administrateur.
     * @param int $id Identifiant de l'administrateur.

     */
    public function __construct($nom, $prenom, $mail, $login, $password, 
            $dateCreation = null, $dateModification = null, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
        $this->login = $login;
        $this->password = $password;    
        $this->dateCreation = $dateCreation;
        $this->dateModification = $dateModification;
        // Par défaut, tout nouvel admin n'est pas Super Adminsitrateur
        $this->superAdmin = false;
    }
    
    /**
     * Sauvegarder l'utilisateur (gère l'insertion et la mise à jour)
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    public function sauvegarde(){
        // On modifie la date de dernière modification
        $this->dateModification = new DateTime();
        
        // Si l'identifiant est défini
        if ($this->id > 0){
            // On met à jour la DB
            return $this->miseAJour();
        }
        // Sinon
        else{
            // On enregistre la date de création
            $this->dateCreation = new DateTime();
                
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
        $id = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "INSERT INTO wam_admin(
                Nom, Prenom, Login, Password, Mail,
                DateCreation, DateModification, super_admin
            ) VALUES (
                :Nom, :Prenom, :Login, :Login, :Mail,
                :DateCreation, :DateModification, :super_admin
            );",
            // param 2: valeurs issues du formulaire
            $this->parametresSQL(true),
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
        $count = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "UPDATE `wam_admin` SET
                Nom = :Nom,
                Prenom = :Prenom,
                Login = :Login,
                Password = CASE WHEN :Password IS NULL THEN Password ELSE :Password END,
                Mail = :Mail,
                DateModification = :DateModification,
                super_admin = :super_admin
            WHERE IdUtilisateur = :id;",
            // param 2: valeurs issues du formulaire
            $this->parametresSQL(),
            // param 3: true = lecture, false = écriture
            false
        );

        // L'insertion s'est bien passé si on a exactement 1 ligne inséré
        return $count == 1;
    }
    
    /**
     * Récupérer l'administrateur sous forme de tableau pour mise à jour en BDD.
     * 
     * @param bool $forCreation Récupère-t-on les paramètres pour une création ?
     * @return Array Les attributs sous forme de tableau.
     */
    private function parametresSQL($forCreation = false){        
        $result = array(
            "Nom" => $this->nom,
            "Prenom" => $this->prenom,
            "Mail" => $this->mail,
            "Login" => $this->login,
      
            "DateModification" => $this->dateModification->format("Y-m-d H:i:s"),
            "super_admin" => $this->superAdmin ? "1" : "0",
        );
        // Ajouter l'identifiant DB si demandé
        if ($forCreation){
            $result["DateCreation"] = $this->dateCreation->format("Y-m-d H:i:s");
        }
        else{
            $result["id"] = $this->id;
            $result["Password"] = $this->password;
        }
        return $result;
    }
    
    /**
     * Supprimer logiquement un administrateur en DB.
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    public function supprimer(){
        // On exécute la requête de mise à jour, en récupérant le nb de lignes modifiés
        $count = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "UPDATE `wam_admin` SET active = 0
            WHERE IdUtilisateur = :id;",
            // param 2: valeurs issues du formulaire
            array(
                "id" => $this->id
            ),
            // param 3: true = lecture, false = écriture
            false
        );

        // L'insertion s'est bien passé si on a exactement 1 ligne inséré
        return $count == 1;
    }
    
    /**
     * Récupérer un administrateur par son identifiant et son mot de passe.
     * 
     * @param string $login Identifiant de l'administrateur.
     * @param string $password Le mot de passe du administrateur.
     * @return Admin L'administrateur trouvé, ou <code>null</code> si non trouvé.
     */
    public static function authentfication($login, $password){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données de l'administrateur
        $datas = Config::get("DB_MANAGER")->exec(
            "SELECT * FROM wam_admin WHERE
                Login = :Login
                AND password = :password
                AND active = 1",
            array(
                "Login" => $login,
                "password" => $password
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = Admin::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger un admininstrateur depuis son Identifiant DB.
     * 
     * @param int $id Identifiant DB de l'admininstrateur.
     * @return Admin L'aministrateur demandé, ou NULL si non trouvé.
     */
    public static function charger($id){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données de l'administrateur
        $datas = Config::get("DB_MANAGER")->exec(
            "SELECT * FROM wam_admin WHERE IdUtilisateur = :id AND active = 1",
            array(
                "id" => $id
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = Admin::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger la liste complète des administrateurs.
     * 
     * @return Array[Admin] La liste des administrateurs dans la DB.
     */
    public static function chargerTout(){
        // Déclaration du résultat
        $result = array();
        
        // Récupération des données de l'administrateur
        $datasList = Config::get("DB_MANAGER")->exec("SELECT * FROM wam_admin WHERE active = 1");
       
        // Pour chaque résultat
        foreach ($datasList as $datas){
            // Charger depuis les résultats
           $result[] = Admin::chargerDepuisRetourSQL($datas);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Créer un administrateur à partir des données d'un tableau associatif.
     * 
     * @param Array[String] $datas Le tableau associatif contenant les données à charger.
     * @return Admin L'administrateur ainsi créé.
     */
    private static function chargerDepuisRetourSQL($datas){
        // On créé l'objet administrateur
        $result = new Admin(
            $datas["Nom"],
            $datas["Prenom"],
            $datas["Mail"],
            $datas["Login"],
            $datas["Password"],       
            DateTime::createFromFormat("Y-m-d H:i:s", $datas["DateCreation"]),
            DateTime::createFromFormat("Y-m-d H:i:s", $datas["DateModification"]),
            $datas["IdUtilisateur"]
        );
        
        // On récupère le fait qu'il soit super-admin ou non
        $result->superAdmin = $datas["super_admin"];
        
        return $result;
    }
    
    /**
     * Mettre l'administrateur dans la session courante.
     */
    public function mettreEnSession(){
        $_SESSION[Admin::$NOM_VARIABLE_SESSION] = $this;
    }
    
    /**
     * Est-ce qu'un administrateur est enregistré dans la session courante ?
     * 
     * @return bool <code>true</code> si oui, <code>false</code> si non.
     */
    public static function sessionActiveExistante(){
        // On a une session admin si la variable session "admin" est définie
        return isset($_SESSION[Admin::$NOM_VARIABLE_SESSION])
            // Et qu'elle n'est pas vide.
            && !empty($_SESSION[Admin::$NOM_VARIABLE_SESSION]);
    }
    
    /**
     * Est-ce qu'un Super Administrateur est enregistré dans la session courante ?
     * 
     * @return bool <code>true</code> si oui, <code>false</code> si non.
     */
    public static function sessionSuperAdminActive(){
        // Récupérer la session administrateur courante
        $sessionAdmin = Admin::recupererSessionActive();
        
        // On est super admin si on est connecté avec un compte reconnu comme super admin
        return $sessionAdmin != null && $sessionAdmin->superAdmin;
    }    
    
    /**
     * Récupérer l'administrateur actuellement en session.
     * 
     * @return Admin L'administrateur trouvé, ou <code>null</code> si non trouvé.
     */
    public static function recupererSessionActive(){
        // Si on a aucune session administrateur active
        if (!Admin::sessionActiveExistante()){
            // On ne renvoie rien
            return null;
        }
        // Renvoyer l'administrateur en session
        return $_SESSION[Admin::$NOM_VARIABLE_SESSION];
    }
    
    /**
     * Merge les données de l'administrateur avec celles enregistrées en session.
     * 
     * @param Admin $admin Objet administrateur à merger.
     */
    public static function mergerAvecSessionActive($admin){
        // Si on a un administrateur en session
        if (Admin::sessionActiveExistante()){
            // Récupérer la session courante
            $sessionAdmin = Admin::recupererSessionActive();
        
            // Récupérer l'identifiant de l'administrateur
            $admin->id = $sessionAdmin->id;

            // Si le mot de passe n'a pas été renseigné
            if (empty($admin->password)){
                // Récupérer celui de la session
                $admin->password = $sessionAdmin->password;
            }
            
            // Récupérer la date de création
            $admin->dateCreation = $sessionAdmin->dateCreation;
             // Récupérer la date de dernière modification       
            $admin->dateModification = $sessionAdmin->dateModification;
            // Récupérer le fqit qu'il est Super Administrateur
            $admin->superAdmin = $sessionAdmin->superAdmin;
        }     
    }
    
    /**
     * Créer un objet administrateur à partir d'un formulaire.
     * 
     * @param bool $isPostForm Le formulaire est-il envoyé en POST ?
     * @return Admin L'administrateur ainsi généré.
     */
    public static function recupererDepuisFormulaireHTML($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);

        $result =  new Admin(
            $requestParameters["NomAdmin"],
            $requestParameters["PrenomAdmin"],
            $requestParameters["MailAdmin"],
            $requestParameters["LoginAdmin"],
            $requestParameters["PasswordAdmin"]
        );
        
        // Si on a une session active
        if (Admin::sessionActiveExistante()){
            // Merger avec les données de la session
            Admin::mergerAvecSessionActive($result);
        }
        // Renvoyer l'administrateur ainsi créé
        return $result;
    }
    
    /**
     * Créer un objet administrateur à partir d'un formulaire SuperAdmin.
     * 
     * @param bool $isPostForm Le formulaire est-il envoyé en POST ?
     * @return Admin L'administrateur ainsi généré.
     */
    public static function recupererDepuisFormulaireHTMLSuperAdmin($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);

        $result =  new Admin(
            $requestParameters["NomSuperAdmin"],
            $requestParameters["PrenomSuperAdmin"],
            $requestParameters["MailSuperAdmin"],
            $requestParameters["LoginSuperAdmin"],
            null, // Mot de passe (vide pour pas de modifs),
            null, // Date Création
            null, // Date Modification
            $requestParameters["IdSuperAdmin"]
        );
        $result->superAdmin = isset($requestParameters["DroitSuperAdmin"]);        
        
        // Renvoyer l'administrateur ainsi créé
        return $result;
    }
    
    /**
     * Est-ce un compte super-admin ?
     * @return bool <code>true</code> si oui, <code>false</code> si non.
     */
    public function superAdmin(){
        return $this->superAdmin;
    }
    
    public function __toString() {
        return $this->prenom . " " . $this->nom . "(" . $this->mail . ")\n"
            . $this->superAdmin ? "Super Administrateur \n" : ""
            . "Créé le " . $this->dateCreation->format("d/m/Y") . " à " . $this->birthDate->format("H/i/s") . '\n'
            . "Modifié le " . $this->dateModification->format("d/m/Y") . " à " . $this->birthDate->format("H/i/s") . '\n';    
    }
}
