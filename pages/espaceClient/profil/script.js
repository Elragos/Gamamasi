$(document).ready(function(){
    // Au clic sur la checkbox
    $("#rattachement").click(function(){
        $("#rattachementDIV").toggle();
    });
    
    // Par défaut, masquer le bloc de rattachement
    if (! $("#rattachement").is(":checked")){
        $("#rattachementDIV").hide();
    }
});