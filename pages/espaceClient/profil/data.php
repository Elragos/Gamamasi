<?php

// Créer un objet vide, pour création
$client = new Client("", "", "", "", "", new Adresse("", "", ""));

// Si on a un client en session
if (Client::sessionActiveExistante()){
    // Récupérer le client de la session
    $client = Client::recupererSessionActive();
}

$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Espace Client",
    "client" => $client,
    "secteursActivite" => SecteurActivite::chargerTout()
);
