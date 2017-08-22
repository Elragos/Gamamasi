<?php

// Si on a aucune superadmin en session
if (!Admin::sessionSuperAdminActive()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

// Créer l'objet client en fonction des données du formulaire
$option = Option::recupererDepuisFormulaireHTML();

// Sauvegarder le membre
$option->sauvegarde();

// Rediriger vers la page de membres
header("Location: " . getAbsoluteURL("espaceAdmin/parametres/gestionOptions"));  
// Fin du script
exit();