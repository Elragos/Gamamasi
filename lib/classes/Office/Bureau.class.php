<?php

/**
 * Classe décrivant un Bureau.
 *
 * @author marechal
 */
class Bureau {
    /**
     * Identifiant DB du bureau.
     * @var int 
     */
    public $id;
    
    /**
     * Salle dans laquelle se trouve le bureau.
     * @var Salle 
     */
    public $salle;
    
    /**
     * Tarif HT du bureau à la journée
     * @var float
     */
    public $tarifHT;    
    
    /**
     * Est-ce que ce bureau est en vente ?
     * @var bool 
     */
    public $enVente;

    /**
     * Constructeur.
     * @param Salle $salle Salle dont dépend le Bureau.
     * @param float $tarifHT Tarif HT du bureau à la journée.
     * @param int $id IDentifiant DB.
     * @param bool $enVente Est-ce que ce bureau est en vente ?
     */
    public function __construct($salle, $tarifHT,  $id = 0, $enVente = false) {
        $this->id = $id;
        $this->salle = $salle;
        $this->tarifHT = $tarifHT;
    }
    
    /**
     * Charger un Bureau depuis son Identifiant DB.
     * 
     * @param int $id Identifiant DB du bureau.
     * @return Bureau Le bureau trouvé, ou null si non trouvé.
     */
    public static function charger($id){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $datas = Config::get("DB_MANAGER")->exec(
            "SELECT * FROM wam_bureau WHERE IdBureau = :id",
            array(
                "id" => $id
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = Bureau::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger la liste complète des bureaux pour une salle.
     * 
     * @param int $salleID Doit-on prendre les options non en vente ?
     * @return Array[Bureau] La liste des bureaux dans la salle demandée.
     */
    public static function chargerPourSalle($salleID){
        // Déclaration du résultat
        $result = array();
        
        // Récupération des données du client
        $datasList = Config::get("DB_MANAGER")->exec(
            "SELECT * FROM wam_bureau WHERE IdSalle = :id",
            array(
                "id" => $salleID
            )        
        );
        
        // Pour chaque résultat
        foreach ($datasList as $datas){
            // Charger depuis les résultats
           $result[] = Bureau::chargerDepuisRetourSQL($datas);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Créer un Bureau à partir des données d'un tableau associatif.
     * 
     * @param Array[String] $datas Le tableau associatif contenant les données à charger.
     * @return Bureau Le bureau ainsi créée.
     */
    private static function chargerDepuisRetourSQL($datas){        
        return new Bureau(
            Salle::charger($datas["IdSalle"]),
            $datas["TarifJournalierHT"],
            $datas["IdBureau"],
            $datas["enVente"] == 1
        );
    }
    
    /**
     * Sauvegarder le bureau (gère l'insertion et la mise à jour)
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
     * Ajoute en DB le Bureau.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function insertion(){        
        // On exécute la requête d'insertion, en récupérant l'id d'insertion
        $id = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "INSERT INTO wam_bureau(
                TarifJournalierHT, IdSalle, enVente
            ) VALUES (
                :TarifJournalierHT, :IdSalle, :enVente
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
     * Met à jour en DB le Bureau.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function miseAJour(){
        // On exécute la requête de mise à jour, en récupérant le nb de lignes modifiés
        $count = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "UPDATE wam_option SET
                TarifJournalierHT = :TarifJournalierHT,
                IdSalle = :IdSalle,
                enVente = :enVente           
            WHERE IdBureau = :id",
            // param 2: valeurs issues du formulaire
            $this->parametresSQL(),
            // param 3: true = lecture, false = écriture
            false
        );

        // L'insertion s'est bien passé si on a exactement 1 ligne inséré
        return $count == 1;
    } 
    
     /**
     * Récupérer le bureau sous forme de tableau pour mise à jour en BDD.
     * 
     * @param bool $forCreation Est-ce pour une création ?
     * @return Array[mixed] Les attributs sous forme de tableau.
     */
    private function parametresSQL($forCreation = false){        
        $result = array(
            "TarifJournalierHT" => $this->tarifHT,
            "IdSalle" => $this->salle->id,
            "enVente" => $this->enVente ? "1" : "0",
        );
                
        // Ajouter l'identifiant DB si demandé
        if (!$forCreation){
            $result["id"] = $this->id;
        }
        return $result;
    }
    
    /**
     * Récupérer un objet Option depuis un formulaire HTML
     * @param bool $isPostForm Le formulaire est-il envoyé en POST ?
     * @return Bureau Le bureau ainsi générée
     */
    public static function recupererDepuisFormulaireHTML($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);
        
        return new Bureau(
            Salle::charger($requestParameters["IdSalleBureau"]),            
            $requestParameters["TarifHtBureau"],
            isset($requestParameters["IdBureau"]),
            $requestParameters["EnVenteBureau"]                
        );
    }    
}
