<?php

/**
 * Représentation d'une adresse dans la solution.
 *
 * @author marechal
 */
class Adresse {
    /**
     * Première ligne d'adresse.
     * @var string.
     */
    public $ligne1;
    /**
     * Deuxième ligne d'adresse.
     * @var string.
     */
    public $ligne2;
    /**
     * Troisième ligne d'adresse.
     * @var string.
     */
    public $ligne3;
    /**
     * Code Postal de l'adresse.
     * @var string.
     */
    public $codePostal;
    /**
     * Ville de l'adresse.
     * @var string.
     */
    public $ville;
    
    /**
     * Constructeur.
     * 
     * @param string $ligne1 Première ligne d'adresse.
     * @param string $codePostal Code Postal de l'adresse.
     * @param string $ville Ville de l'adresse.
     * @param string $ligne2 Deuxième ligne d'adresse.
     * @param string $ligne3 Troisième ligne d'adresse.
     */
    public function __construct($ligne1, $codePostal, $ville, $ligne2 = null, $ligne3 = null) {
        $this->ligne1 = $ligne1;
        $this->ligne2 = $ligne2;
        $this->ligne3 = $ligne3;
        $this->codePostal = $codePostal;
        $this->ville = $ville;
    }
    
    /**
     * Récupérer l'adresse sous forme de chaîne de caractères.
     * 
     * @return string L'adresse
     */
    public function __toString() {
        // Ajouter la première ligne (sans la modifier)
        $result = '' . $this->ligne1;
        
        // Si la deuxième ligne est rempli
        if (isset($this->ligne2) && !empty($this->ligne2)){
            // On l'ajoute
            $result .= '\n' . $this->ligne2;
        }
        
        // Si la troisième ligne est rempli
        if (isset($this->ligne3) && !empty($this->ligne3)){
            // On l'ajoute
            $result .= '\n' . $this->ligne3;
        }
        
        // On ajoute le code postal et la ville
        $result .= '\n' . $this->codePostal . ", " . $this->ville;
           
        return $result;        
    }
}
