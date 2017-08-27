$(document).ready(function(){    
    // On clic sur une piève
    $(".piece").click(function(event){        
        if ($(event.target).parent(".bureau").is(".bureau-libre")){
            alert("place ajouté");
        }
    });
});