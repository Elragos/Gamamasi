<?php

/**
 * Représentation d'un type de membre dans la solution.
 *
 * @author marechal
 */
class TypeMembre {
    /**
     * Identifiant DB du type de membre.
     * @var int.
     */
    public $id;
    /**
     * Nom du type de membre.
     * @var string.
     */
    public $nom;
    
    /**
     * Est-ce que ce type de membre est visible par les clients ?
     * @var bool.
     */
    public $visible;
   
    /**
     * Constructeur.
     * 
     * @param int $id Identifiant DB du type de membre.
     * @param string $nom Nom du type de membre.
     * @param bool $visible Est-ce que ce type de membre est visible par les clients ? 
     */
    public function __construct($id, $nom, $visible = true) {
        $this->id = $id;
        $this->nom = $nom;
        $this->visible = $visible;
    }
    
    /**
     * Récupérer le type de membre sous forme de chaîne de caractères.
     * 
     * @return string Le type de membre.
     */
    public function __toString() {
        return $this->id . " : " . $this->nom . "(" .$this->visible ? ("Visible") : ("Invisible") . ")"; 
    }
    
    /**
     * Charger un type de membre depuis son Identifiant DB.
     * 
     * @param int $id Identifiant DB du client.
     * @return TypeMembre Le type de membre trouvé, ou null su non trouvé.
     */
    public static function charger($id){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $datas = Config::get("DB_MANAGER")->exec(
            "SELECT * FROM wam_type_membre WHERE Id_type_membre = :id",
            array(
                "id" => $id
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = TypeMembre::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger la liste complète des secteurs d'activité.
     * 
     * @return Array[TypeMembre] La liste des types de membres dans la DB.
     */
    public static function chargerTout(){
        // Déclaration du résultat
        $result = array();
        
        // Récupération des données du client
        $datasList = Config::get("DB_MANAGER")->exec("SELECT * FROM wam_type_membre");
        
        // Pour chaque résultat
        foreach ($datasList as $datas){
            // Charger depuis les résultats
           $result[] = TypeMembre::chargerDepuisRetourSQL($datas);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Créer un Type de membre à partir des données d'un tableau associatif.
     * 
     * @param Array[String] $datas Le tableau associatif contenant les données à charger.
     * @return TypeMembre Le type de membre ainsi créé.
     */
    private static function chargerDepuisRetourSQL($datas){        
        return new TypeMembre(
            $datas["Id_type_membre"],
            $datas["intitule"],
            $datas["visible"]
        );
    }
    
    /**
     * Sauvegarder le type de membre (gère l'insertion et la mise à jour)
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
     * Ajoute en DB le type de membre.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function insertion(){       
        // On exécute la requête d'insertion, en récupérant l'id d'insertion
        $id = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "INSERT INTO wam_type_membre( "
                . "intitule, visible"
            . ") VALUES ("
                . ":intitule, :visible"
            . ");",
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
     * Met à jour en DB le type de membre.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function miseAJour(){
        // On exécute la requête de mise à jour, en récupérant le nb de lignes modifiés
        $count = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "UPDATE wam_type_membre SET"
                . " intitule = :intitule, "
                . " visible = :visible "
            . " WHERE Id_type_membre = :id",
            // param 2: valeurs issues du formulaire
            $this->parametresSQL(),
            // param 3: true = lecture, false = écriture
            false
        );

        // L'insertion s'est bien passé si on a exactement 1 ligne inséré
        return $count == 1;
    } 
    
     /**
     * Récupérer le type de membre sous forme de tableau pour mise à jour en BDD.
     * 
     * @param bool $forCreation Est-ce pour une création ?
     * @return Array[mixed] Les attributs sous forme de tableau.
     */
    private function parametresSQL($forCreation = false){        
        $result = array(
            "intitule" => $this->nom,
            "visible" => $this->visible ? "1" : 0
        );
        
        // Ajouter l'identifiant DB si demandé
        if (!$forCreation){
            $result["id"] = $this->id;
        }
        return $result;
    }
    
    /**
     * Récupérer un objet Type de Membre depuis un formulaire HTML
     * @param bool $isPostForm Le formulaire est-il envoyé en POST ?
     * @return TypeMembre
     */
    public static function recupererDepuisFormulaireHTML($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);
        
        return new TypeMembre(
            $requestParameters["IdTypeMembre"],
            $requestParameters["NomTypeMembre"],
            isset($requestParameters["VisibiliteTypeMembre"]) ? true : false
        );
    }
}