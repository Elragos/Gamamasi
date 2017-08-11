<?php

// Si on a aucune superadmin en session
if (!Admin::sessionSuperAdminActive()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

// Créer l'objet client en fonction des données du formulaire
$typeMembre = TypeMembre::recupererDepuisFormulaireHTML();

// Sauvegarder le membre
$typeMembre->sauvegarde();

// Rediriger vers la page de membres
header("Location: " . getAbsoluteURL("espaceAdmin/parametres/typesMembre"));  
// Fin du script
exit();