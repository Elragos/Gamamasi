$(document).ready(function(){
    $("#sendAjax").click(function(){
        $.ajax({
            url: "index.do",
            method: "GET",
            data: $("#testAjax").serialize() 
        }).done(function(msg){
            alert(msg);
        });
        return false;
    })
});