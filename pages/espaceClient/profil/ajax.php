<?php

// Créer l'objet client en fonction des données du formulaire
$client = Client::recupererDepuisFormulaireHTML();

// Sauvegarder le client
if ($client->sauvegarde()){    
   // Mettre à jour la session si la sauvegarde a réussi
    $client->mettreEnSession(); 
}

// Rediriger vers la page de profil
header("Location: " . getAbsoluteURL("espaceClient/profil"));  
// Fin du script
exit();