<?php

// Si on a aucune client en session
if (!Client::sessionActiveExistante()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceClient/index"));  
    // Fin du script
    exit();
}

// Créer l'objet client en fonction des données du formulaire
$membre = Membre::recupererDepuisFormulaireHTML();

// Sauvegarder le membre
$membre->sauvegarde();

// Rediriger vers la page de membres
header("Location: " . getAbsoluteURL("espaceClient/membres"));  
// Fin du script
exit();