<?php

// Si on a aucune superadmin en session
if (!Admin::sessionSuperAdminActive()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

// Créer l'objet client en fonction des données du formulaire
$typeTva = TypeTva::recupererDepuisFormulaireHTML();

// Sauvegarder le membre
$typeTva->sauvegarde();

// Rediriger vers la page de membres
header("Location: " . getAbsoluteURL("espaceAdmin/parametres/typesTva"));  
// Fin du script
exit();