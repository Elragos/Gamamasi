<?php

/**
 * Classe décrivant une sallle.
 *
 * @author marechal
 */
class Salle {
    /**
     * Identifiant DB de la salle.
     * @var int 
     */
    public $id;
    
    /**
     * Nom de la salle.
     * @var string 
     */
    public $nom;
    
    /**
     * Capacité maximale de la salle.
     * @var int 
     */
    public $capaciteMax;
    
    /**
     * Le tarif horaire HT.
     * @var float 
     */
    public $tarifHT;
    
    /**
     * TVA applicable.
     * @var TypeTva 
     */
    public $tva;
    
    /**
     * Type de salle.
     * @var int  
     */
    public $type;
    
    /**
     * Est-ce que la salle est en vente ?
     * @var bool
     */
    public $enVente;
    
    /**
     * Position de départ par rapport au modèle.
     * @var Point 
     */
    public $position;
    
    /**
     * Longueur en pixels de la salle.
     * @var int 
     */
    public $longueur;
    
    /**
     * Largeur en pixels de la salle.
     * @var int 
     */
    public $largeur;
    
    /**
     * Types de salle.
     * @var type 
     */
    public static $typesSalle = array(
        0 => "Salle de réunion",
        1 => "Salle de bureau",
    );
    
    /**
     * Constructeur.
     * @param string $nom Le nom de la salle
     * @param int $capaciteMax La capacité maximale de la salle.
     * @param float $tarifHT Le tarif HT à l'heure.
     * @param TypeTva $tva La TVA applicable.
     * @param int $type Le type de salle.
     * @param bool $enVente Est-ce que la salle est en vente ?
     * @param Point $position Position de départ par rapport au modèle.
     * @param int $longueur Longueur en pixels de la salle.
     * @param int $largeur Largeur en pixels de la salle.
     * @param int $id Identifiant DB de la salle.
     */
    public function __construct($nom, $capaciteMax, $tarifHT, $tva, $type, $enVente, $position, $longueur, $largeur, $id = 0){
        $this->id = $id;
        $this->nom = $nom;
        $this->capaciteMax = $capaciteMax;
        $this->tarifHT = $tarifHT;
        $this->tva = $tva;
        $this->type = $type;
        $this->enVente = $enVente;
        $this->position = $position;
        $this->longueur = $longueur;
        $this->largeur = $largeur;
    }
    
    /**
     * Calcule le prix TTC de la salle arrondi à 2 décimales.
     * @return float Le prix TTC de l'option.
     */
    public function tarifTTC(){
        return calculerTTC($this->tarifHT, $this->tva->taux);
    }
    
    /**
     * Charger une Salle depuis son Identifiant DB.
     * 
     * @param int $id Identifiant DB du client.
     * @return Salle La Salle trouvée, ou null si non trouvé.
     */
    public static function charger($id){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $datas = Config::get("DB_MANAGER")->exec(
            "SELECT * FROM wam_salle WHERE IdSalle = :id",
            array(
                "id" => $id
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = Salle::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger la liste complète des salles.
     * 
     * @param bool $prendreNonEnVente Doit-on prendre les options non en vnete ?
     * @return Array[Salle] La liste des options actives dans la DB.
     */
    public static function chargerTout(){
        // Déclaration du résultat
        $result = array();
        
        // Récupération des données du client
        $datasList = Config::get("DB_MANAGER")->exec(
            "SELECT * FROM wam_salle"
        );
        
        // Pour chaque résultat
        foreach ($datasList as $datas){
            // Charger depuis les résultats
           $result[] = Salle::chargerDepuisRetourSQL($datas);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Créer une Salle à partir des données d'un tableau associatif.
     * 
     * @param Array[String] $datas Le tableau associatif contenant les données à charger.
     * @return Salle La Salle ainsi créée.
     */
    private static function chargerDepuisRetourSQL($datas){
        return new Salle(
            $datas["Nom"],
            $datas["CapaciteMax"],
            $datas["TarifHoraireHT"],
            TypeTva::charger($datas["IdTva"]),
            $datas["TypeSalle"],
            $datas["enVente"] == 1,
            new Point($datas["posX"], $datas["posY"]),
            $datas["longueur"],
            $datas["largeur"],
            $datas["IdSalle"]    
        );
    }
    
    /**
     * Sauvegarder la salle (gère l'insertion et la mise à jour)
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
     * Ajoute en DB la Salle.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function insertion(){       
        // On exécute la requête d'insertion, en récupérant l'id d'insertion
        $id = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "INSERT INTO wam_salle(
                Nom, TarifHoraireHT, IdTva, CapaciteMax, TypeSalle, enVente
            ) VALUES (
                :Nom, :TarifHoraireHT, :IdTva, :CapaciteMax, :TypeSalle, :enVente
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
     * Met à jour en DB la Salle.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function miseAJour(){
        // On exécute la requête de mise à jour, en récupérant le nb de lignes modifiés
        $count = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "UPDATE wam_salle SET
                Nom = :Nom,
                TarifHoraireHT = :TarifHoraireHT,
                IdTva = :IdTva,
                CapaciteMax = :CapaciteMax,
                TypeSalle = :TypeSalle,
                enVente = :enVente
            WHERE IdSalle = :id",
            // param 2: valeurs issues du formulaire
            $this->parametresSQL(),
            // param 3: true = lecture, false = écriture
            false
        );

        // L'insertion s'est bien passé si on a exactement 1 ligne inséré
        return $count == 1;
    } 
    
     /**
     * Récupérer la salle sous forme de tableau pour mise à jour en BDD.
     * 
     * @param bool $forCreation Est-ce pour une création ?
     * @return Array[mixed] Les attributs sous forme de tableau.
     */
    private function parametresSQL($forCreation = false){        
        $result = array(
            "Nom" => $this->nom,
            "TarifHoraireHT" => $this->tarifHT,
            "IdTva" => $this->tva->id,
            "CapaciteMax" => $this->capaciteMax,
            "TypeSalle" => $this->type,
            "enVente" => $this->enVente ? "1" : "0",
        );

        // Ajouter l'identifiant DB si demandé
        if (!$forCreation){
            $result["id"] = $this->id;
        }
        return $result;
    }
    
    /**
     * Récupérer un objet Salle depuis un formulaire HTML
     * @param bool $isPostForm Le formulaire est-il envoyé en POST ?
     * @return Salle La salle ainsi générée.
     */
    public static function recupererDepuisFormulaireHTML($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);
        
        return new Salle(
            $requestParameters["NomSalle"],
            $requestParameters["CapaciteSalle"],
            $requestParameters["TarifHtSalle"],
            TypeTva::charger($requestParameters["IdTvaSalle"]),
            $requestParameters["TypeSalle"],
            isset($requestParameters["EnVenteSalle"]),
            new Point($requestParameters["PosXSalle"], $requestParameters["PosYSalle"]),
            $requestParameters["LongueurSalle"],
            $requestParameters["LargeurSalle"],
            $requestParameters["IdSalle"]
        );
    }
}