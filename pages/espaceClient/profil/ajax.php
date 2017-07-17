<?php

// Créer l'objet client en fonction des données du formulaire
$customer = Customer::getFromHtmlForm();

// Sauvegarder le client
$customer->save();

// Mettre à jour la session
$_SESSION["customer"] = $customer;

// Rediriger vers la page de profil
header("Location: " . getAbsoluteURL("espaceClient/profil"));  
// Fin du script
exit();