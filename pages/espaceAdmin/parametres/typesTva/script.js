// Fonction gérant la fermeture de la popin
function fermerPopinTypeTva(){
    $("#overlay").hide();
    $(".popin").hide();
}

// Fonction gérant l'ouverture de la popin
function ouvrirPopinTypeTva(){
    // Afficher l'overlay ainsi que la popin création membre
    $("#overlay").show();
    $(".popin").show();
    // On réinitialise le formulaire de création membre
    $("#admin-typeTva-popin form").get(0).reset();
    // Fix pour la checkbox
    $("#VisibiliteTypeTva").removeAttr("checked");
}

$(document).ready(function(){
    // Déplacer la popin de création d'un membre dans l'overlay
    $("#admin-typeTva-popin").detach().appendTo("#overlay");
    
    // Gestion du clic sur Ajouter un membre
    $("#AjouterTypeTva").click(ouvrirPopinTypeTva);
    
    // Gestion du clic sur Modifier un membre
    $(".admin-typeTva-modifier").click(function(event){
        // Ouvrir la popin
        ouvrirPopinTypeTva();
        
        // Ligne sur laquelle on a cliqué
        var ligne = $(event.target).parents("tr");
        // Données de la ligne
        var donneesLigne = {
            "IdTypeTva" : ligne.attr("data-typeTva-id"),
            "NomTypeTva" : ligne.attr("data-typeTva-nom"),
            "TauxTypeTva" : ligne.attr("data-typeTva-taux"),
        };
        console.log(donneesLigne);        
        
        // Remplir le formulaire avec les données
        $('#admin-typeTva-popin form').find('input').val(function() {
            console.log()
            return donneesLigne[this.id];
        });
    });

    // Fermer la popin si l'on clique en dehors de la popin
    $("#overlay").click(function(event){  
        // Si le clic n'est pas dans la popin
        if($(event.target).closest('.popin').length === 0){
            // On ferme la popin
            fermerPopinTypeTva();
        }
        // Si le clie est dans la zone de fermeture
        if ($(event.target).closest('.popin-toolbar-close').length != 0){
            // On ferme la popin
            fermerPopinTypeTva();
        }
    });
});