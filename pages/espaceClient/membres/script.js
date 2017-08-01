// Fonction gérant la fermeture de la popin
function fermerPopinMembre(){
    $("#overlay").hide();
    $("#client-membre-popin").hide();
}

// Fonction gérant l'ouverture de la popin
function ouvrirPopinMembre(){
    // Afficher l'overlay ainsi que la popin création membre
    $("#overlay").show();
    $("#client-membre-popin").show();
    // On réinitialise le formulaire de création membre
    $("#client-membre-popin form").get(0).reset();
}

$(document).ready(function(){    
    // Déplacer la popin de création d'un membre dans l'overlay
    $("#client-membre-popin").detach().appendTo("#overlay");
    
    // Gestion du clic sur Ajouter un membre
    $("#AjouterMembre").click(ouvrirPopinMembre);
    
    // Gestion du clic sur Modifier un membre
    $(".client-membre-modifier").click(function(event){
        // Ouvrir la popin
        ouvrirPopinMembre();
        
        // Ligne sur laquelle on a cliqué
        var ligne = $(event.target).parents("tr");
        // Données de la ligne
        var donneesLigne = {
            "IdMembre" : ligne.attr("data-membre-id"),
            "NomMembre" : ligne.attr("data-membre-nom"),
            "PrenomMembre" : ligne.attr("data-membre-prenom"),
            "MailMembre" : ligne.attr("data-membre-mail"),
            "IdTypeMembre" : ligne.attr("data-membre-type"),
            "IdSecteurActivite" : ligne.attr("data-membre-secteur")
        };
        
        // Remplir le formulaire avec les données
        $('#client-membre-popin form').find('input, select').val(function() {
            return donneesLigne[this.id];
        });
    });
    
    //
    $(".client-membre-supprimer").click(function(event){
        // Si confirmation de suppression
        if (confirm("Êtes-vous sûr de retirer cette personne de vos membres ?")){
            // Récupérer la ligne à supprimer
            var ligne = $(event.target).parents("tr");
                
            // Début de l'appel AJAX
            afficherLoader();

            $.ajax({
                url: "supprimerMembre.do",
                method: "POST",
                data: {
                    "id" : ligne.attr("data-membre-id")
                }
            }).done(function(json){
                // Récupérer le retour JSON
                var retour = jQuery.parseJSON(json);
                // Si le retour s'est exécuté normalement
                if (retour.execute){
                    // Supprimer la ligne
                    ligne.remove();
                }
                // Sinon
                else{
                    // Afficher le message d'erreur
                    alert(retour.erreur);
                }
                // On peut masquer le loader
                masquerLoader();
            });
        }
    });
    
    // Fermer la popin au clic sur la croix
    $("#client-membre-popin-toolbar-close").click(fermerPopinMembre);
    
    // Fermer la popin si l'on clique en dehors de la popin
    $("#overlay").click(function(event){  
        // Si le clic n'est pas dans la popin
        if($(event.target).closest('#client-membre-popin').length === 0){
            // On ferme la popin
            fermerPopinMembre();
        }
    });
});