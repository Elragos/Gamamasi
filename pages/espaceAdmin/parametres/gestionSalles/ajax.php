<?php

// Si on a aucune superadmin en session
if (!Admin::sessionSuperAdminActive()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

// Créer l'objet admin en fonction des données du formulaire
$salle = Salle::recupererDepuisFormulaireHTML();

// Sauvegarder les données
$salle->sauvegarde();

// Rediriger vers la page des admins
header("Location: " . getAbsoluteURL("espaceAdmin/parametres/gestionSalles"));  
// Fin du script
exit();