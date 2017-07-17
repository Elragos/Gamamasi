<?php

/**
 * Représentation d'une adresse dans la solution
 *
 * @author marechal
 */
class Address {
    /**
     * Première ligne d'adresse.
     * @var string.
     */
    public $line1;
    /**
     * Deuxième ligne d'adresse.
     * @var string.
     */
    public $line2;
    /**
     * Troisième ligne d'adresse.
     * @var string.
     */
    public $line3;
    /**
     * Code Postal de l'adresse.
     * @var string.
     */
    public $zipCode;
    /**
     * Ville de l'adresse.
     * @var string.
     */
    public $town;
    
    /**
     * Constructeur.
     * 
     * @param string $line1 Première ligne d'adresse.
     * @param string $zipCode Code Postal de l'adresse.
     * @param string $town Ville de l'adresse.
     * @param string $line2 Deuxième ligne d'adresse.
     * @param string $line3 Troisième ligne d'adresse.
     */
    public function __construct($line1, $zipCode, $town, $line2 = null, $line3 = null) {
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->line3 = $line3;
        $this->zipCode = $zipCode;
        $this->town = $town;
    }
    
    /**
     * Récupérer l'adresse sous forme de chaîne de caractères.
     * 
     * @return string L'adresse
     */
    public function __toString() {
        // Ajouter la première ligne (sans la modifier)
        $result = '' . $this->line1;
        
        // Si la deuxième ligne est rempli
        if (isset($this->line2) && !empty($this->line2)){
            // On l'ajoute
            $result .= '\n' . $this->line2;
        }
        
        // Si la troisième ligne est rempli
        if (isset($this->line3) && !empty($this->line3)){
            // On l'ajoute
            $result .= '\n' . $this->line3;
        }
        
        // On ajoute le code postal et la ville
        $result .= '\n' . $this->zipCode . ", " . $this->town;
           
        return $result;        
    }
}
