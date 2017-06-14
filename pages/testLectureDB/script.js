$(document).ready(function(){
    $(".client-update").click(function(){
        $.ajax({
            url: "testLectureDB.do",
            method: "GET",
            data: {
                id: $(this).attr("data-client-id") 
            }
        }).done(function(resultMessage){
            result = JSON.parse(resultMessage);
            if(result.done){
                alert("Mise à jour réussie");
                location.reload();
            }
            else{
                alert("Echec de la mise à jour");
            }
        });
        return false;
    })
});