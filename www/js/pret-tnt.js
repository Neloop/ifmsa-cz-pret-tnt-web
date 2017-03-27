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

    function extendMainIfNeeded() {
        var main = $('main');
        var mainHeight = main.height();
        var navHeightMinusPadding = $('nav').height() - parseInt(main.css('margin-top'));

        if (mainHeight < navHeightMinusPadding) {
            main.height(navHeightMinusPadding);
        }
    }

    function aprilHeartGenerator() {

        // start generating hearts only on the April Fools' Day
        var now = new Date();
        if (now.getDate() !== 1 || now.getMonth() !== 3) {
            return;
        }

        // count iterations and generate heart every 5 seconds
        var heartIters = 0;
        var heartInterval = setInterval(function () {
            // create heart itself
            var randomHeart = $('<svg class="random-heart">' +
                    '<polygon points="160,269 319,110 319,45 240,0 160,37 80,0 1,45 1,110" fill="white" />' +
                    '<polygon points="319,110 80,0 0,45 0,110 111,220" fill="#E51C44" opacity="0.77" />' +
                    '<polygon points="209,220 319,110 319,45 240,0 0,110" fill="#AC1E52" opacity="0.79" />' +
                    '<polygon points="160,269 209,220 160,37 111,220" fill="#5B0E38" opacity="0.72" />' +
                    '<polygon points="320,110 319,45 240,0 209,220" fill="#8F1C56" opacity="0.68" />' +
                    '<polygon points="80,0 0,45 0,110 111,220" fill="#8F1C56" opacity="0.68" />' +
                    '<text fill="#FFFFFF" font-size="26" font-family="Verdana" x="50%" y="40%" text-anchor="middle" font-weight="bold">APRIL FOOLS\' DAY</text>' +
                    '</svg>');

            // random position of heart at the page
            var width = 320;
            var height = 270;
            var posx = (Math.random() * ($(document).width() - width)).toFixed();
            var posy = (Math.random() * ($(document).height() - height)).toFixed();

            randomHeart.css({
                'left': posx + 'px',
                'top': posy + 'px',
                'width': width + 'px',
                'height': height + 'px'
            });

            $('body').append(randomHeart);

            // make heart appear continuously
            randomHeart.fadeIn(1000, function () {});

            // if there are more than 100 hearts, stop...
            heartIters++;
            if (heartIters >= 100) {
                clearInterval(heartInterval);
            }
        }, 5000);
    }

    extendMainIfNeeded();
    aprilHeartGenerator();
});
