<?php

/**
 * Représentation d'un secteur d'activité dans la solution.
 *
 * @author marechal
 */
class SecteurActivite {
    /**
     * Identifiant DB du secteur d'activité.
     * @var int.
     */
    public $id;
    /**
     * Nom du secteur d'activité.
     * @var string.
     */
    public $nom;
   
    /**
     * Constructeur.
     * 
     * @param int $id Identifiant DB du secteur d'activité.
     * @param string $nom Nom du secteur d'activité.
     */
    public function __construct($id, $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }
    
    /**
     * Récupérer le secteur d'activité sous forme de chaîne de caractères.
     * 
     * @return string Le secteur d'activité.
     */
    public function __toString() {
        return $this->id . " : " . $this->nom;
    }
    
    /**
     * Charger un secteur d'activité depuis son Identifiant DB.
     * 
     * @param int $id Identifiant DB du client.
     * @return SecteurActivite Le secteur d'activité trouvé, ou null su non trouvé.
     */
    public static function charger($id){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $datas = $_SESSION["DB_MANAGER"]->exec(
            "SELECT * FROM wam_secteur_activite WHERE Id_secteur_activite = :id",
            array(
                "id" => $id
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = SecteurActivite::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger la liste complète des secteurs d'activité.
     * 
     * @return Array[SecteurActivite] La liste des secteurs d'activité dans la DB.
     */
    public static function chargerTout(){
        // Déclaration du résultat
        $result = array();
        
        // Récupération des données du client
        $datasList = $_SESSION["DB_MANAGER"]->exec("SELECT * FROM wam_secteur_activite");
        
        // Pour chaque résultat
        foreach ($datasList as $datas){
            // Charger depuis les résultats
           $result[] = SecteurActivite::chargerDepuisRetourSQL($datas);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Créer un Secteur d'activié à partir des données d'un tableau associatif.
     * 
     * @param Array[String] $datas Le tableau associatif contenant les données à charger.
     * @return SecteurActivite Le client ainsi créé.
     */
    private static function chargerDepuisRetourSQL($datas){        
        return new SecteurActivite($datas["Id_secteur_activite"], $datas["secteur_activite"]);
    }
}
