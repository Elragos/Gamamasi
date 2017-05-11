$(document).ready(function(){
    $("#sendAjax").click(function(){
        $.ajax({
            url: "Simpage.do",
            method: "GET",
            data: $("#testAjax").serialize() 
        }).done(function(msg){
            alert(msg);
        });
        return false;
    })
});