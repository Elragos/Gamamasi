// Fonction gérant la fermeture de la popin
function fermerPopinAdmin(){
    $("#overlay").hide();
    $(".popin").hide();
}

// Fonction gérant l'ouverture de la popin
function ouvrirPopinAdmin(){
    // Afficher l'overlay ainsi que la popin création membre
    $("#overlay").show();
    $(".popin").show();
    // On réinitialise le formulaire de création membre
    $("#admin-gestionAdmin-popin form").get(0).reset();
    // Fix pour la checkbox
    $("#SuperAdmin").removeAttr("checked");
}

$(document).ready(function(){
    // Déplacer la popin de création d'un membre dans l'overlay
    $("#admin-gestionAdmin-popin").detach().appendTo("#overlay");
    
    // Gestion du clic sur Ajouter un membre
    $("#AjouterAdmin").click(ouvrirPopinAdmin);
    
    // Gestion du clic sur Modifier un membre
    $(".admin-gestionAdmin-modifier").click(function(event){
        // Ouvrir la popin
        ouvrirPopinAdmin();
        
        // Ligne sur laquelle on a cliqué
        var ligne = $(event.target).parents("tr");
        // Données de la ligne
        var donneesLigne = {
            "IdSuperAdmin" : ligne.attr("data-admin-id"),
            "NomSuperAdmin" : ligne.attr("data-admin-nom"),
            "PrenomSuperAdmin" : ligne.attr("data-admin-prenom"),
            "MailSuperAdmin" : ligne.attr("data-admin-mail"),
            "LoginSuperAdmin" : ligne.attr("data-admin-login"),
            "DroitSuperAdmin" : ligne.attr("data-admin-superAdmin") == 1,
        };

        // Remplir le formulaire avec les données
        $('#admin-gestionAdmin-popin form').find('input').val(function() {
            return donneesLigne[this.id];
        });
        
        // Fix pour la checkbox
        if (donneesLigne.DroitSuperAdmin){
            $("#DroitSuperAdmin").attr("checked", "checked");
        }
        else{
            $("#DroitSuperAdmin").removeAttr("checked");
        }
    });

    // Fermer la popin si l'on clique en dehors de la popin
    $("#overlay").click(function(event){  
        // Si le clic n'est pas dans la popin
        if($(event.target).closest('.popin').length === 0){
            // On ferme la popin
            fermerPopinAdmin();
        }
        // Si le clic est dans la zone de fermeture
        if ($(event.target).closest('.popin-toolbar-close').length != 0){
            // On ferme la popin
            fermerPopinAdmin();
        }
    });
    
    // Au clic sur supprimer un admin
    $(".admin-gestionAdmin-supprimer").click(function(event){
        // Si confirmation de suppression
        if (confirm("Êtes-vous sûr de supprimer cette administrateur ?")){
            // Récupérer la ligne à supprimer
            var ligne = $(event.target).parents("tr");
                
            // Début de l'appel AJAX
            afficherLoader();

            $.ajax({
                url: "gestionAdmins/supprimer.do",
                method: "POST",
                data: {
                    "id" : ligne.attr("data-admin-id")
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
});