// Fonction de gestion du clic sur EstSociete
function OnEstSocieteClick(event){
    // Si la case est coché
    if ($("#EstSociete").is(":checked")){
        // Masquer la date de naissance
        $("#DateNaissance").parent().hide();
        // Afficher le SIRET et la Raison Sociale
        $("#SIRET").parent().show();
        $("#RaisonSociale").parent().show();
    }
    // Sinon
    else{
        // Masquer la date de naissance
        $("#DateNaissance").parent().show();
        // Masquer le SIRET et la Raison Sociale
        $("#SIRET").parent().hide();
        $("#RaisonSociale").parent().hide();
    }
}

$(document).ready(function(){
    // Activer la gestion du clic sur EstSociete avec notre fonction
    $("#EstSociete").click(OnEstSocieteClick);
    // Gérer l'état dès que la page est chargée
    OnEstSocieteClick();
});

