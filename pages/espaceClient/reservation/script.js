$(document).ready(function(){    
    // On clic sur une piève
    $(".piece").click(function(event){        
        if ($(event.target).parent(".bureau").is(".bureau-libre")){
            alert("place ajouté");
        }
    });
    /*
    var debut = $("#dateDebut"),
        fin = $( "#dateFin");
    // Initialiser le calendrier pour la date de début
    debut.datepicker( $.datepicker.regional[ "fr" ]);
    // Dès que la date change, modifier le calendrier de la date de fin
    debut.on( "change", function() {
          fin.datepicker( "option", "minDate", getDate( this ) );
    });
    // Initialiser le calendrier pour la date de fin
    fin.datepicker( $.datepicker.regional[ "fr" ]);
    // Dès que la date change, modifier le calendrier de la date de début
    fin.on( "change", function() {
        debut.datepicker( "option", "maxDate", getDate( this ) );
    }); 
    */
});

function getDate( element ) {
    var date;
    try {
        date = $.datepicker.parseDate( formatDate(), element.value );
    } catch( error ) {
        console.log(error);
        date = null;
    }
    console.log(date);

    return date;
 }