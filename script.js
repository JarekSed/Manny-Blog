
var hidden = false;
$(document).ready(function(){
    $(".posts").click(function(){
        if(hidden){
            $("#hidden", this).show();
            $(this).css("width", "80%");
            hidden = false;
        }else{
            $("#hidden", this).hide();
            $(this).css("width", "25%");
            hidden = true;
        }
    });
});

/*
$(document).ready(function(){
    $(".posts").click(function(){
        $("#hidden", this).toggle();
    });
});
*/
