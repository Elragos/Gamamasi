// Fonction gérant la fermeture de la popin
function fermerPopinOption(){
    $("#overlay").hide();
    $(".popin").hide();
}

// Fonction gérant l'ouverture de la popin
function ouvrirPopinOption(){
    // Afficher l'overlay ainsi que la popin création membre
    $("#overlay").show();
    $(".popin").show();
    // On réinitialise le formulaire de création membre
    $("#admin-options-popin form").get(0).reset();
    // Fix pour la checkbox
    $("#EnVenteOption").removeAttr("checked");
}

// Calculer le TTC en fonction du HT
function calculerTTC(){
    var tva = $("#IdTvaOption option:selected").attr("data-taux") || 0.0;
    var ht = $("#PrixHtOption").val() || 0.0;
    var ttc = ht * (1 + (tva/100));

    $("#PrixTtcOption").val(ttc.toFixed(2));
}

$(document).ready(function(){
    // Déplacer la popin de création d'un membre dans l'overlay
    $("#admin-options-popin").detach().appendTo("#overlay");
    
    // Gestion du clic sur Ajouter un membre
    $("#AjouterOption").click(ouvrirPopinOption);
    
    // Gestion du clic sur Modifier un membre
    $(".admin-options-modifier").click(function(event){
        // Ouvrir la popin
        ouvrirPopinOption();
        
        // Ligne sur laquelle on a cliqué
        var ligne = $(event.target).parents("tr");
        // Données de la ligne
        var donneesLigne = {
            "IdOption" : ligne.attr("data-option-id"),
            "NomOption" : ligne.attr("data-option-nom"),
            "PrixHtOption" : ligne.attr("data-option-prix"),
            "IdTvaOption" : ligne.attr("data-option-tvaId"),
            "EnVenteOption" : ligne.attr("data-option-enVente") == 1,
            "StockMaxOption" : ligne.attr("data-option-stockMax"),
        };        
        
        // Fix pour la checkBox
        if (donneesLigne.EnVenteOption){
            $("#EnVenteOption").attr("checked", "checked");
        }
        else{
            $("#EnVenteOption").removeAttr("checked");
        }
        
        // Remplir le formulaire avec les données
        $('#admin-options-popin form').find('input, select').val(function() {
            return donneesLigne[this.id];
        });
        
        // Lancer le calclu du TTC
        calculerTTC();
    });

    // Fermer la popin si l'on clique en dehors de la popin
    $("#overlay").click(function(event){  
        // Si le clic n'est pas dans la popin
        if($(event.target).closest('.popin').length === 0){
            // On ferme la popin
            fermerPopinOption();
        }
        // Si le clie est dans la zone de fermeture
        if ($(event.target).closest('.popin-toolbar-close').length != 0){
            // On ferme la popin
            fermerPopinOption();
        }
    });
    
    // Au changement du taux de TVA, recalculer le prix TTC
    $("#IdTvaOption").change(calculerTTC);
    
    // Au changement du prix HT, recalculer le TTC
    $("#PrixHtOption").change(calculerTTC);
    
    // Si on change le prix TTC, recalculer le prix HT
    $("#PrixTtcOption").change(function(){
        var tva = $("#IdTvaOption option:selected").attr("data-taux") || 0.0;
        var ttc = $("#PrixTtcOption").val() || 0.0;
        var ht = ttc / (1 + (tva/100));

        $("#PrixHtOption").val(ht.toFixed(3));
    });
});