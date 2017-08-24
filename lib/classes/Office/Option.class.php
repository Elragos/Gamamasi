<?php

/**
 * Classe décrivant une option.
 *
 * @author marechal
 */
class Option {
    /**
     * Identifiant DB.
     * @var int.
     */
    public $id;
    
    /**
     * Nom.
     * @var string.
     */
    public $nom;
    
    /**
     * Stock Maximal.
     * @var int
     */
    public $stockMax;
    
    /**
     * Stock Actuel.
     * @var int 
     */
    public $stockActuel;
    
    /**
     * Prix HT du produit
     * @var float 
     */
    public $prixHT;
    
    /**
     * Taux de TVA applicable.
     * @var TypeTva 
     */
    public $tva;
    
    /**
     * Est-ce que l'option est en vente ?
     * @var bool 
     */
    public $enVente;
    
    /**
     * Constructeur.
     * 
     * @param int $id Identifiant DB.
     * @param string $nom Nom.
     * @param float $prixHT Prix HT.
     * @param TypeTva $tva Taux de TVA applicable.
     * @param bool $enVente Est-ce que l'option est en vente ?
     * @param int $stockMax Stock maximale du produit.
     * @param int $stockActuel Stock actuel du produit. Optionnel.
     */
    public function __construct($id, $nom, $prixHT, $tva, $enVente, $stockMax, $stockActuel = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prixHT = $prixHT;
        $this->tva = $tva;
        $this->enVente = $enVente;
        $this->stockMax = $stockMax;
        $this->stockActuel = $stockActuel == null ? $stockMax : $stockActuel;
    }
    
    /**
     * Récupérer l'option sous forme de chaîne de caractères.
     * 
     * @return string L'option sous forme de chaîne de caractères.
     */
    public function __toString() {
        return $this->id . " ( " . $this->stockActuel . " / " . $this->stockMax . " ) : " 
            . $this->nom . " " . ($this->enVente ? "En Vente " : "Pas en vente")
            . ", prix =  " . $this->prixHT . "€, TVA = " . $this->tva;
    }
    
    /**
     * Calcule le prix TTC de l'option arrondi à 2 décimales.
     * @return float Le prix TTC de l'option.
     */
    public function prixTTC(){
        return calculerTTC($this->prixHT, $this->tva->taux);
    }
    
    /**
     * Charger une option depuis son Identifiant DB.
     * 
     * @param int $id Identifiant DB du client.
     * @return Option L'option trouvée, ou null si non trouvé.
     */
    public static function charger($id){
        // Déclaration du résultat
        $result = null;
        
        // Récupération des données du client
        $datas = Config::get("DB_MANAGER")->exec(
            "SELECT * FROM wam_option WHERE id_option = :id",
            array(
                "id" => $id
            )
        );
       
        // Si on a des résultats
        if (isset($datas) && !empty($datas)){
            // Charger depuis le premier résultat
           $result = Option::chargerDepuisRetourSQL($datas[0]);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Charger la liste complète des options.
     * 
     * @param bool $prendreNonEnVente Doit-on prendre les options non en vnete ?
     * @return Array[Option] La liste des options actives dans la DB.
     */
    public static function chargerTout(){
        // Déclaration du résultat
        $result = array();
        
        // Récupération des données du client
        $datasList = Config::get("DB_MANAGER")->exec(
            "SELECT * FROM wam_option"
        );
        
        // Pour chaque résultat
        foreach ($datasList as $datas){
            // Charger depuis les résultats
           $result[] = Option::chargerDepuisRetourSQL($datas);
        }

        // Renvoyer le résultat
        return $result;
    }
    
    /**
     * Créer une Option à partir des données d'un tableau associatif.
     * 
     * @param Array[String] $datas Le tableau associatif contenant les données à charger.
     * @return Option L'Option ainsi créée.
     */
    private static function chargerDepuisRetourSQL($datas){        
        return new Option(
            $datas["id_option"],
            $datas["nature_option"],
            $datas["prix_ht_option"],
            TypeTva::charger($datas["id_TVA"]),
            $datas["enVente"] == 1,
            $datas["qte_option"]    
        );
    }
    
    /**
     * Sauvegarder l'option (gère l'insertion et la mise à jour)
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
            "INSERT INTO wam_option(
                nature_option, prix_ht_option, id_TVA, qte_option, enVente
            ) VALUES (
                :nature_option, :prix_ht_option, :id_TVA, :qte_option, :enVente
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
     * Met à jour en DB le type de TVA.
     * 
     * @return bool <code>true</code> si réussi, <code>false</code> sinon.
     */
    private function miseAJour(){
        // On exécute la requête de mise à jour, en récupérant le nb de lignes modifiés
        $count = Config::get("DB_MANAGER")->exec(
            // param 1: requête préparée
            "UPDATE wam_option SET
                nature_option = :nature_option,
                prix_ht_option = :prix_ht_option,
                id_TVA = :id_TVA,
                qte_option = :qte_option,
                enVente = :enVente
            WHERE id_option = :id",
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
            "id_TVA" => $this->tva->id,
            "nature_option" => $this->nom,
            "prix_ht_option" => $this->prixHT,
            "qte_option" => $this->stockMax,
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
     * @return Option L'option ainsi générée
     */
    public static function recupererDepuisFormulaireHTML($isPostForm = true){
        $filterParameter = $isPostForm ? INPUT_POST : INPUT_GET;
        
        $requestParameters = filter_input_array($filterParameter);
        
        return new Option(
            $requestParameters["IdOption"],
            $requestParameters["NomOption"],
            $requestParameters["PrixHtOption"],
            TypeTva::charger($requestParameters["IdTvaOption"]),
            isset($requestParameters["EnVenteOption"]),
            $requestParameters["StockMaxOption"]                
        );
    }
}




