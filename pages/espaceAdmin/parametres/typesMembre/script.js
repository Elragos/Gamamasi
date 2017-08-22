// Fonction gérant la fermeture de la popin
function fermerPopinTypeMembre(){
    $("#overlay").hide();
    $(".popin").hide();
}

// Fonction gérant l'ouverture de la popin
function ouvrirPopinTypeMembre(){
    // Afficher l'overlay ainsi que la popin création membre
    $("#overlay").show();
    $(".popin").show();
    // On réinitialise le formulaire de création membre
    $("#admin-typeMembre-popin form").get(0).reset();
    // Fix pour la checkbox
    $("#VisibiliteTypeMembre").removeAttr("checked");
}

$(document).ready(function(){
    // Déplacer la popin de création d'un membre dans l'overlay
    $("#admin-typeMembre-popin").detach().appendTo("#overlay");
    
    // Gestion du clic sur Ajouter un membre
    $("#AjouterTypeMembre").click(ouvrirPopinTypeMembre);
    
    // Gestion du clic sur Modifier un membre
    $(".admin-typeMembre-modifier").click(function(event){
        // Ouvrir la popin
        ouvrirPopinTypeMembre();
        
        // Ligne sur laquelle on a cliqué
        var ligne = $(event.target).parents("tr");
        // Données de la ligne
        var donneesLigne = {
            "IdTypeMembre" : ligne.attr("data-typeMembre-id"),
            "NomTypeMembre" : ligne.attr("data-typeMembre-nom"),
            "VisibiliteTypeMembre" : ligne.attr("data-typeMembre-visible") == "1",
        };        
        
        // Remplir le formulaire avec les données
        $('#admin-typeMembre-popin form').find('input').val(function() {
            return donneesLigne[this.id];
        });
        
        // Fix pour la checkbox
        if (donneesLigne.VisibiliteTypeMembre){
            $("#VisibiliteTypeMembre").attr("checked", "checked");
        }
        else{
            $("#VisibiliteTypeMembre").removeAttr("checked");
        }
    });

    // Fermer la popin si l'on clique en dehors de la popin
    $("#overlay").click(function(event){  
        // Si le clic n'est pas dans la popin
        if($(event.target).closest('.popin').length === 0){
            // On ferme la popin
            fermerPopinTypeMembre();
        }
        // Si le clie est dans la zone de fermeture
        if ($(event.target).closest('.popin-toolbar-close').length != 0){
            // On ferme la popin
            fermerPopinTypeMembre();
        }
    });
});