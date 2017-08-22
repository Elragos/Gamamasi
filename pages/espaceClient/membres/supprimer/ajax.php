<?php

// Erreurs survenue dans la suppression
$erreur = "";

// Identifiant du membre à supprimer logiquement
$idMembre = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

// Récupérer le client connecté
$client = Client::recupererSessionActive();

// Si l'identifiant est bien un nombre
if (filter_var($idMembre, FILTER_VALIDATE_INT)){
    // Si on a un client
    if ($client != null){
        // Récupérer le membre demandé
        $membre = Membre::charger($idMembre, $client->id);
        
        // Si trouvé
        if ($membre != null){
            // Si la suppression a échoué
            if (!$membre->supprimer()){
                $erreur = "Erreur lors de la suppression du membre";
            }
        }
        else{
            $erreur = "Membre non trouvé";
        }
    }
    else{
        $erreur = "Client non reconnu";
    }
}
// Sinon, erreur
else{
    $erreur = "Impossible de récupérer le membre demandé";
}

Config::get("RENDER_MANAGER")->pageDatas = array(
    // Est-ce que l'exécution s'est effectuée sans erreur
    "execute" => empty($erreur),
    "erreur" => $erreur,
);
