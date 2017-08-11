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
     * Est-ce que ce secteur est visible par les clients ?
     * @var bool.
     */
    public $visible;
    
    /**
     * Constructeur.
     * 
     * @param int $id Identifiant DB du secteur d'activité.
     * @param string $nom Nom du secteur d'activité.
     * @param bool $visible Est-ce que ce secteur est visible par les clients ?
     */
    public function __construct($id, $nom, $visible = true) {
        $this->id = $id;
        $this->nom = $nom;
        $this->visible = $visible;
    }
    
    /**
     * Récupérer le secteur d'activité sous forme de chaîne de caractères.
     * 
     * @return string Le secteur d'activité.
     */
    public function __toString() {
        return $this->id . " : " . $this->nom . "(" .$this->visible ? ("Visible") : ("Invisible") . ")"; 
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
        return new SecteurActivite(
            $datas["Id_secteur_activite"],
            $datas["secteur_activite"],
            $datas["visible"]
        );
    }
    
    /**
     * Sauvegarder le ecteur d'activité (gère l'insertion et la mise à jour)
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
     * Ajoute en DB le secteur d'activité.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function insertion(){       
        // On exécute la requête d'insertion, en récupérant l'id d'insertion
        $id = $_SESSION["DB_MANAGER"]->exec(
            // param 1: requête préparée
            "INSERT INTO wam_secteur_activite( "
                . "secteur_activite, visible"
            . ") VALUES ("
                . ":secteur_activite, :visible"
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
     * Met à jour en DB le secteur d'activité.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function miseAJour(){
        // On exécute la requête de mise à jour, en récupérant le nb de lignes modifiés
        $count = $_SESSION["DB_MANAGER"]->exec(
            // param 1: requête préparée
            "UPDATE wam_secteur_activite SET"
                . " secteur_activite = :secteur_activite, "
                . " visible = :visible "
            . " WHERE Id_secteur_activite = :id",
            // param 2: valeurs issues du formulaire
            $this->parametresSQL(),
            // param 3: true = lecture, false = écriture
            false
        );

        // L'insertion s'est bien passé si on a exactement 1 ligne inséré
        return $count == 1;
    } 
    
     /**
     * Récupérer le secteur d'activité sous forme de tableau pour mise à jour en BDD.
     * 
     * @param bool $forCreation Est-ce pour une création ?
     * @return Array[mixed] Les attributs sous forme de tableau.
     */
    private function parametresSQL($forCreation = false){        
        $result = array(
            "secteur_activite" => $this->nom,
            "visible" => $this->visible ? "1" : 0
        );
        
        // Ajouter l'identifiant DB si demandé
        if (!$forCreation){
            $result["id"] = $this->id;
        }
        return $result;
    }
    
    /**
     * Récupérer un objet Secteur d'activité depuis un formulaire HTML
     * @param bool $isPostForm Le formulaire est-il envoyé en POST ?
     * @return SecteurActivite
     */
    public static function recupererDepuisFormulaireHTML($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);
        
        return new SecteurActivite(
            $requestParameters["IdSecteur"],
            $requestParameters["NomSecteur"],
            isset($requestParameters["VisibiliteSecteur"]) ? true : false
        );
    }
}
