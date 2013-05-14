$(document).ready(function(){
    $(".zoom a").append("<span></span>");
    $(".zoom a").hover(function(){
        $(this).children("span").fadeIn(600);
    },function(){
        $(this).children("span").fadeOut(200);
    });
});