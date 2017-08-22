<?php

/**
 * Représentation d'un type de TVA dans la solution.
 *
 * @author marechal
 */
class TypeTva {
    /**
     * Identifiant DB du type de TVA.
     * @var int.
     */
    public $id;
    /**
     * Nom du type de TVA.
     * @var string.
     */
    public $nom;
    
    /**
     * Taux de TVA.
     * @var float 
     */
    public $taux;
    
    /**
     * Constructeur.
     * 
     * @param int $id Identifiant DB du type de TVA.
     * @param string $nom Nom du type de TVA.
     * @param bool $taux Taux de TVA.
     */
    public function __construct($id, $nom, $taux) {
        $this->id = $id;
        $this->nom = $nom;
        $this->taux = $taux;
    }
    
    /**
     * Récupérer le type de TVA sous forme de chaîne de caractères.
     * 
     * @return string Le type de membre.
     */
    public function __toString() {
        return $this->id . " : " . $this->nom . " = " . $this->taux . "%";
    }
    
    /**
     * Charger un type de membre depuis son Identifiant DB.
     * 
     * @param int $id Identifiant DB du client.
     * @return TypeTva Le type de membre trouvé, ou null su non trouvé.
     */
    public static function charger($id){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $datas = Config::get("DB_MANAGER")->exec(
            "SELECT * FROM wam_type_tva WHERE id_TVA = :id",
            array(
                "id" => $id
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = TypeTva::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger la liste complète des secteurs d'activité.
     * 
     * @return Array[TypeTva] La liste des types de membres dans la DB.
     */
    public static function chargerTout(){
        // Déclaration du résultat
        $result = array();
        
        // Récupération des données du client
        $datasList = Config::get("DB_MANAGER")->exec("SELECT * FROM wam_type_tva");
        
        // Pour chaque résultat
        foreach ($datasList as $datas){
            // Charger depuis les résultats
           $result[] = TypeTva::chargerDepuisRetourSQL($datas);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Créer un Type de TVA à partir des données d'un tableau associatif.
     * 
     * @param Array[String] $datas Le tableau associatif contenant les données à charger.
     * @return TypeTva Le type de membre ainsi créé.
     */
    private static function chargerDepuisRetourSQL($datas){        
        return new TypeTva(
            $datas["id_TVA"],
            $datas["nom"],
            $datas["taux_TVA"]
        );
    }
    
    /**
     * Sauvegarder le type de TVA (gère l'insertion et la mise à jour)
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
     * Ajoute en DB le type de TVA.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function insertion(){       
        // On exécute la requête d'insertion, en récupérant l'id d'insertion
        $id = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "INSERT INTO wam_type_tva( "
                . "taux_TVA, nom"
            . ") VALUES ("
                . ":taux_TVA, :nom"
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
     * Met à jour en DB le type de TVA.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function miseAJour(){
        // On exécute la requête de mise à jour, en récupérant le nb de lignes modifiés
        $count = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "UPDATE wam_type_tva SET"
                . " taux_TVA = :taux_TVA, "
                . " nom = :nom "
            . " WHERE id_TVA = :id",
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
            "taux_TVA" => $this->taux,
            "nom" => $this->nom
        );
        
        // Ajouter l'identifiant DB si demandé
        if (!$forCreation){
            $result["id"] = $this->id;
        }
        return $result;
    }
    
    /**
     * Récupérer un objet Type de Tva depuis un formulaire HTML
     * @param bool $isPostForm Le formulaire est-il envoyé en POST ?
     * @return TypeTVA
     */
    public static function recupererDepuisFormulaireHTML($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);
        
        return new TypeTva(
            $requestParameters["IdTypeTva"],
            $requestParameters["NomTypeTva"],
            $requestParameters["TauxTypeTva"]
        );
    }
}