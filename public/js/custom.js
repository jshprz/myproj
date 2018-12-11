   /* $(document).keydown(function (event) {
    if (event.keyCode == 123) { // Prevent F12
        return false;
    } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
        return false;
    }
});
$(document).on("contextmenu", function (e) {        
    e.preventDefault();
});*/
$(document).on("click", ".navbars", function() {
    $toggle = $(this),
    1 == dashboard.misc.navbar_menu_visible ? ($("html").removeClass("nav-open"),
    dashboard.misc.navbar_menu_visible = 0,
    setTimeout(function() {
        $toggle.removeClass("toggled"),
        $("#bodyClick").remove()
    })) : (setTimeout(function() {
        $toggle.addClass("toggled")
    }),
    div = '<div id="bodyClick"></div>',
    $(div).appendTo("body").click(function() {
        $("html").removeClass("nav-open"),
        setTimeout(function() {
            $toggle.removeClass("toggled"),
            $("#bodyClick").remove()
        }, 550)
    }),
    $("html").addClass("nav-open"))
}),
dashboard = {
    misc: {
        navbar_menu_visible: 0
    },
    
   
};

 var $document = $(document),
   $element = $('.navbar'),
   className = 'navbars';

 $document.scroll(function() {
   if ($document.scrollTop() >= 50) {
     // Change 50 to the value you require
     // for the event to trigger
     $element.addClass(className);
   } else {
     $element.removeClass(className);
   }
 });

