<?php

/**
 * Classe représentant un membre d'une société cliente.
 *
 * @author marechal
 */
class Membre {
    
    /**
     * Identifiant DB du membre.
     * @var int
     */
    public $id;
    
    /**
     * Nom du membre.
     * @var String
     */
    public $nom;
    
    /**
     * Prénom du membre.
     * @var String
     */
    public $prenom;
    
    /**
     * Mail du membre.
     * @var String 
     */
    public $mail;
    
    /**
     * Client dont dépend le membre
     * @var Client 
     */
    public $client;
    
    /**
     * Type de membre
     * @var type 
     */
    public $typeMembre;
    
    /**
     * Secteur d'activité du membre
     * @var SecteurActivite
     */
    public $secteurActivite;
    
    /**
     * Constructeur
     * @param String $nom Nom du membre.
     * @param String $prenom Prénom du membre.
     * @param String $mail Mail du membre
     * @param Client $client Client dont dépend le membre
     * @param TypeMembre $typeMembre Type de membre
     * @param int $id Identifiant DB.
     * @param type $secteurActivite
     */
    public function __construct($nom, $prenom, $mail, $client, $typeMembre,
        $id = 0, $secteurActivite = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
        $this->client= $client;
        $this->typeMembre = $typeMembre;
        $this->id = $id;
        $this->secteurActivite = $secteurActivite;
    }
    
        /**
     * Charger un  membre depuis son Identifiant DB.
     * 
     * @param int $id Identifiant DB du client.
     * @return Membre Le membre trouvé, ou null su non trouvé.
     */
    public static function charger($id){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $datas = $_SESSION["DB_MANAGER"]->exec(
            "SELECT * FROM wam_membre WHERE Id_membre = :id",
            array(
                "id" => $id
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = Membre::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger la liste complète des membres d'un client.
     * 
     * @return Array[Membre] La liste des types de membres dans la DB.
     */
    public static function chargerTout($idClient){
        // Déclaration du résultat
        $result = array();
        
        // Récupération des données du client
        $datasList = $_SESSION["DB_MANAGER"]->exec(
            "SELECT * FROM wam_membre WHERE IdClient = :idClient",
            array(
                "idClient" => $idClient
            )
        );
        
        // Pour chaque résultat
        foreach ($datasList as $datas){
            // Charger depuis les résultats
           $result[] = Membre::chargerDepuisRetourSQL($datas);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Créer un Type de membre à partir des données d'un tableau associatif.
     * 
     * @param Array[String] $datas Le tableau associatif contenant les données à charger.
     * @return Membre Le type de membre ainsi créé.
     */
    private static function chargerDepuisRetourSQL($datas){        
        return new Membre(
            $datas["Nom_membre"],
            $datas["Prenom_membre"],
            $datas["Mail"],
            Client::charger($datas["IdClient"]),
            TypeMembre::charger($datas["Id_type_membre"]),
            $datas["Id_membre"],
            SecteurActivite::charger($datas["Id_secteur_activite"])
        );
    }
    
        /**
     * Sauvegarder le membre (gère l'insertion et la mise à jour)
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
     * Ajoute en DB le membre.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function insertion(){       
        // On exécute la requête d'insertion, en récupérant l'id d'insertion
        $id = $_SESSION["DB_MANAGER"]->exec(
            // param 1: requête préparée
            "INSERT INTO wam_membre( "
                . " Nom_membre, Prenom_membre, Mail, "
                . "IdClient, Id_type_membre, Id_secteur_activite "
            . ") VALUES ("
                . ":Nom_membre, :Prenom_membre, :Mail, "
                . ":IdClient, :Id_type_membre, :Id_secteur_activite "
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
        // On modifie la date de dernière modification
        $this->dateModification = new DateTime();

        // On exécute la requête de mise à jour, en récupérant le nb de lignes modifiés
        $count = $_SESSION["DB_MANAGER"]->exec(
            // param 1: requête préparée
            "UPDATE wam_membre SET"
                . " Id_membre = :Id_membre,"
                . " Nom_membre = :Nom_membre,"
                . " Prenom_membre = :Prenom_membre"
                . " Mail = :Mail"
                . " IdClient = :IdClient"
                . " Id_type_membre = :Id_type_membre,"
                . " Id_secteur_activite = :Id_secteur_activite"
            . " WHERE Id_membre = :id",
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
     * @return Array[mixed] Les attributs sous forme de tableau.
     */
    public function parametresSQL($addId = true){        
        $result = array(
            "Nom_membre" => $this->nom,
            "Prenom_membre" => $this->prenom,
            "Mail" => $this->mail,
            "IdClient" => $this->client->id,
            "Id_type_membre" => $this->typeMembre->id,
            "Id_secteur_activite" => $this->secteurActivite == null ? null : $this->secteurActivite->id
        );
        
        // Ajouter l'identifiant DB si demandé
        if ($addId){
            $result["id"] = $this->id;
        }
        return $result;
    }
    
    /**
     * Créer un objet Membre à partir d'un formulaire.
     * 
     * @param bool $isPostForm Le formulaire est-il envoyé en POST ?
     * @return Membre Le client ainsi généré.
     */
    public static function recupererDepuisFormulaireHTML($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);
        
        return new Membre(
            $requestParameters["NomMembre"],
            $requestParameters["PrenomMembre"],
            $requestParameters["MailMembre"],
            Client::recupererSessionActive(),
            TypeMembre::charger($requestParameters["IdTypeMembre"]),
            $requestParameters["IdMembre"],
            SecteurActivite::charger($requestParameters["IdSecteurActivite"])
        );
    }
    
}
