<?php

/**
 * Classe décrivant un point sur un plan en 2 dimensions.
 *
 * @author marechal
 */
class Point {
    /**
     * Abscisse (en pixels).
     * @var int 
     */
    public $x;
    /**
     * Ordonnée (en pixels).
     * @var int 
     */
    public $y;
    
    /**
     * Constructeur
     * @param int $x Abscisse (en pixels).
     * @param int $y Ordonnée (en pixels).
     */
    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }
    
    /**
     * Récupérer les coordonnées sous forme d'une chaîne de caractères.
     * @return string Les coordonnées sous forme de string.
     */
    public function __toString() {
        return $this->x . " / " . $this->y;
    }
}
