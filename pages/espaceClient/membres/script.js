// Fonction gérant la fermeture de la popin
function fermerPopinMembre(){
    $("#overlay").hide();
    $("#client-membre-popin").hide();
}

$(document).ready(function(){
    
    // Déplacer la popin de création d'un membre dans l'overlay
    $("#client-membre-popin").detach().appendTo("#overlay");
    
    // Activer la gestion du clic sur Ajouter un membre
    $("#AjouterMembre").click(function(){
        // Afficher l'overlay ainsi que la popin création membre
        $("#overlay").show();
        $("#client-membre-popin").show();
        // On réinitialise le formulaire de création membre
        $("#client-membre-popin form").get(0).reset();
    });
    
    // Fermer la popin au clic sur la croix
    $(".client-membre-popin-toolbar-close").click(fermerPopinMembre);
    
    // Fermer la popin si l'on clique en dehors de la popin
    $("#overlay").click(function(event){
        // Récupérer la cible du clic
        var $this = $(event.target);
        
        console.log($this);
        console.log($this.closest('#client-membre-popin'));
        
        // Si le clic n'est pas dans la popin
        if($this.closest('#client-membre-popin').length === 0){
            // On ferme
            fermerPopinMembre();
        }
    });
    
});