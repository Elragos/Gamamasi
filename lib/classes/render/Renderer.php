<?php

/**
 * Interface permettant de représenter la gestion d'un rendu.
 *
 * @author marechal
 */
interface Renderer { 
    
    /**
     * Indiquer la page à afficher et vérifie qu'elle peut être appelée.
     * @param string $pagePath Chemin souhaité.
     * @return bool <code>true</code> si initialisation réussie, <code>false</code> sinon.
     */
    public function setPage($pagePath);
    
    /**
     * Renvoi le rendu du template en fonction des données envoyés.
     * @param string $pagePath Chemin souhaité.
     * @param array $pageDatas Données du template.
     * @param bool $reloadCache Doit-on recharger le cache ?
     * @return string Le rendu généré par le moteur.
     */
    public function render($pagePath, $pageDatas, $reloadCache = false);
}
