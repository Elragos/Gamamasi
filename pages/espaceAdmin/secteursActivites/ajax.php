<?php

// Si on a aucune client en session
if (!Admin::sessionActiveExistante()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

// Créer l'objet client en fonction des données du formulaire
$secteur = SecteurActivite::recupererDepuisFormulaireHTML();

// Sauvegarder le membre
$secteur->sauvegarde();

// Rediriger vers la page de membres
header("Location: " . getAbsoluteURL("espaceAdmin/secteursActivites"));  
// Fin du script
exit();