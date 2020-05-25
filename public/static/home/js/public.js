$(function() {
    var menuBar = $("#open-menu"),
        menu = $("#menu");
    menuBar.click(function () {
        menu.stop(true, false).slideToggle()
    });
    if ($(document).outerWidth() > 768) {
        var lang = $(".menu-item");
        lang.hover(function(){
            $(this).children("ul").stop(true,false).slideToggle()
        });
    }
})