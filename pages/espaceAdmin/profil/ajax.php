<?php

// Si on a aucun admin en session
if (!Admin::sessionActiveExistante()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceAdmin/index"));  
    // Fin du script
    exit();
}
// Créer l'objet administrateur en fonction des données du formulaire
$admin = Admin::recupererDepuisFormulaireHTML();

// Récupérer la session admin courante
$sessionAdmin = Admin::recupererSessionActive(); 

// S'assurer que les identifiants correspondent
if ($sessionAdmin->id == $admin->id){
    // Sauvegarder l'administrateur
    if ($admin->sauvegarde()){    
       // Mettre à jour la session si la sauvegarde a réussi
        $admin->mettreEnSession(); 
    }
}

// Rediriger vers la page de profil
header("Location: " . getAbsoluteURL("espaceAdmin/profil"));  
// Fin du script
exit();