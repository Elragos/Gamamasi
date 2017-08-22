<?php

// Erreurs survenue dans la suppression
$erreur = "";

$sessionAdmin = Admin::recupererSessionActive();

// Identifiant de l'admin à supprimer logiquement
$idAdmin = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

// Si l'identifiant est bien un nombre
if (filter_var($idAdmin, FILTER_VALIDATE_INT)){
    // Si on a une session superadmin
    if (Admin::sessionSuperAdminActive()){
        
        // Si ce n'est pas le même compte admin que celui actuellement en session
        if ($sessionAdmin->id != $idAdmin){
            // Récupérer l'admin demandé
            $admin = Admin::charger($idAdmin);
            // Si trouvé
            if ($admin != null){
                // Si la suppression a échoué
                if (!$admin->supprimer()){
                    $erreur = "Erreur lors de la suppression de l'administrateur";
                }
            }
            else{
                $erreur = "Admin non trouvé";
            }
        }
        else{
            $erreur = "On ne peut supprimer son propre compte";
        }
    }
    else{
        $erreur = "Vous n'avez pas les droits pour effectuer cette action";
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
