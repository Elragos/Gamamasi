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
     * Constructeur.
     * 
     * @param int $id Identifiant DB du type de membre.
     * @param string $nom Nom du type de membre.
     */
    public function __construct($id, $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }
    
    /**
     * Récupérer le type de membre sous forme de chaîne de caractères.
     * 
     * @return string Le secteur d'activité.
     */
    public function __toString() {
        return $this->id . " : " . $this->nom;
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
        $datas = $_SESSION["DB_MANAGER"]->exec(
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
        $datasList = $_SESSION["DB_MANAGER"]->exec("SELECT * FROM wam_type_membre");
        
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
        return new TypeMembre($datas["Id_type_membre"], $datas["intitule"]);
    }
}