$(function() {
    $('#nav-toggle').click(function(e) {
        function openMenu() {
            $('nav').width('300px');
            $('#nav-overlay').css('opacity', .5);
        }

        function closeMenu() {
            $('nav').width('0');
            $('#nav-overlay').remove();
        }

        var overlay = $('#nav-overlay');
        // If overlay does not exist, create one and if it is clicked, close menu
        if (overlay.length === 0) {
            overlay = $('<div id="nav-overlay"></div>');
            overlay.css('opacity', 0).click( function(){
              closeMenu();
            });
            $('body').append(overlay);
        }

        $('nav').width() > 0 ? closeMenu() : openMenu();
    });
});
