$(document).ready(function(){
    function afficherMasquer(id)
    {
      if(document.getElementById(id).style.display == "none")
            document.getElementById(id).style.display = "block";
      else
            document.getElementById(id).style.display = "none";
    }
    
    // Au clic sur la checkbox
    $("#rattachement").click(function(){
        $("#rattachementDIV").toggle();
    });
    
    // Par défaut, masquer le bloc de rattachement
    if (! $("#rattachement").is(":checked")){
        $("#rattachementDIV").hide();
    }
});