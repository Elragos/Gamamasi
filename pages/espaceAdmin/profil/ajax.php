<?php

// Créer l'objet administrateur en fonction des données du formulaire
$admin = Admin::recupererDepuisFormulaireHTML();

// Sauvegarder l'administrateur
if ($admin->sauvegarde()){    
   // Mettre à jour la session si la sauvegarde a réussi
    $admin->mettreEnSession(); 
}

// Rediriger vers la page de profil
header("Location: " . getAbsoluteURL("espaceAdmin/profil"));  
// Fin du script
exit();