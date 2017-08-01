<?php

// Si on a aucune client en session
if (!Client::sessionActiveExistante()){
    // Rediriger sur la page de connexion
    header("Location: " . getAbsoluteURL("espaceClient/index"));  
    // Fin du script
    exit();
}

$client = Client::recupererSessionActive();

$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Mon Espace Client - Mes membres",
    "client" => $client,
    "activeMenu" => "membres",
    "membres" => Membre::chargerTout($client->id),
    "typesMembres" => TypeMembre::chargerTout(),
    "secteursActivite" => SecteurActivite::chargerTout()
);
