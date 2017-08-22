<?php

// Si on a aucune superadmin en session
if (!Admin::sessionSuperAdminActive()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}

// Créer l'objet admin en fonction des données du formulaire
$admin = Admin::recupererDepuisFormulaireHTMLSuperAdmin();

// Si ce n'est pas l'admin actuellement connecté
if (Admin::recupererSessionActive()->id != $admin->id){
    // Sauvegarder les données
    $admin->sauvegarde();
}

// Rediriger vers la page des admins
header("Location: " . getAbsoluteURL("espaceAdmin/parametres/gestionAdmins"));  
// Fin du script
exit();