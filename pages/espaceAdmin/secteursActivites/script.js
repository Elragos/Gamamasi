// Fonction gérant la fermeture de la popin
function fermerPopinSecteur(){
    $("#overlay").hide();
    $(".popin").hide();
}

// Fonction gérant l'ouverture de la popin
function ouvrirPopinSecteur(){
    // Afficher l'overlay ainsi que la popin création membre
    $("#overlay").show();
    $(".popin").show();
    // On réinitialise le formulaire de création membre
    $("#admin-secteur-popin form").get(0).reset();
    // Fix pour la checkbox
    $("#VisibiliteSecteur").removeAttr("checked");
}

$(document).ready(function(){    
    // Déplacer la popin de création d'un membre dans l'overlay
    $("#admin-secteur-popin").detach().appendTo("#overlay");
    
    // Gestion du clic sur Ajouter un membre
    $("#AjouterSecteur").click(ouvrirPopinSecteur);
    
    // Gestion du clic sur Modifier un membre
    $(".admin-secteur-modifier").click(function(event){
        // Ouvrir la popin
        ouvrirPopinSecteur();
        
        // Ligne sur laquelle on a cliqué
        var ligne = $(event.target).parents("tr");
        // Données de la ligne
        var donneesLigne = {
            "IdSecteur" : ligne.attr("data-secteur-id"),
            "NomSecteur" : ligne.attr("data-secteur-nom"),
            "VisibiliteSecteur" : ligne.attr("data-secteur-visible") == "1",
        };
        
        // Remplir le formulaire avec les données
        $('#admin-secteur-popin form').find('input').val(function() {
            return donneesLigne[this.id];
        });
        
        // Fix pour la checkbox
        if (donneesLigne.VisibiliteSecteur){
            $("#VisibiliteSecteur").attr("checked", "checked");
        }
        else{
            $("#VisibiliteSecteur").removeAttr("checked");
        }
    });

    // Fermer la popin si l'on clique en dehors de la popin
    $("#overlay").click(function(event){  
        // Si le clic n'est pas dans la popin
        if($(event.target).closest('.popin').length === 0){
            // On ferme la popin
            fermerPopinSecteur();
        }
        // Si le clie est dans la zone de fermeture
        if ($(event.target).closest('.popin-toolbar-close').length != 0){
            // On ferme la popin
            fermerPopinSecteur();
        }
    });
});