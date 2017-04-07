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

function easterDate(year) {
    var a = year % 19;
    var b = Math.floor(year / 100);
    var c = year % 100;
    var d = Math.floor(b / 4);
    var e = b % 4;
    var f = Math.floor((b + 8) / 25);
    var g = Math.floor((b - f + 1) / 3);
    var h = (19 * a + b - d - g + 15) % 30;
    var i = Math.floor(c / 4);
    var k = c % 4;
    var l = (32 + 2 * e + 2 * i - h - k) % 7;
    var m = Math.floor((a + 11 * h + 22 * l) / 451);
    var n0 = (h + l + 7 * m + 114);
    var n = Math.floor(n0 / 31) - 1;
    var p = n0 % 31 + 1;
    return new Date(year, n, p);
}

function easterEggGenerator() {

    // start easter egg routine week before easter and end it week after
    var now = new Date();
    var easter = easterDate(now.getFullYear());
    var easterStart = (new Date(easter)).setDate(easter.getDate() - 7);
    var easterEnd = (new Date(easter)).setDate(easter.getDate() + 7);
    if (now < easterStart || now > easterEnd) {
        return;
    }

    // create easter egg images and append them to html body
    var easterImages = [
        $('<div class="easter-egg"><img height="100px" src="https://openclipart.org/download/204671/Pollito.svg"></div>'),
        $('<div class="easter-egg"><img height="100px" src="https://openclipart.org/download/204672/Rabbit.svg"></div>'),
        $('<div class="easter-egg"><img height="100px" src="https://openclipart.org/download/191742/1394668349.svg"></div>'),
        $('<div class="easter-egg"><img height="100px" src="https://openclipart.org/download/77467/easter-egg-blue.svg"></div>'),
        $('<div class="easter-egg"><img height="100px" src="https://openclipart.org/download/131623/Chick-007-Newborn-Egg-Cartoon.svg"></div>'),
        $('<div class="easter-egg"><img height="100px" src="https://openclipart.org/download/191046/chicken.svg"></div>'),
        $('<div class="easter-egg"><img height="100px" src="https://openclipart.org/download/87763/Rabbit-001-Face-Cartoon.svg"></div>'),
        $('<div class="easter-egg"><img height="100px" src="https://openclipart.org/download/141919/Rabbit-004-Baby-Cartoon.svg"></div>'),
        $('<div class="easter-egg"><img height="100px" src="https://openclipart.org/download/19477/shokunin-easter-egg-single.svg"></div>')
    ];
    for (i = 0; i < easterImages.length; i++) {
        $('body').append(easterImages);
    }

    //
    var generate = function () {
        // random easter image and preparation of variables
        var randomEasterImage = easterImages[Math.floor(Math.random() * easterImages.length)];
        var originalWidth = randomEasterImage.width();
        var originalHeight = randomEasterImage.height();
        var leftPos;
        var topPos;
        var leftAnimateSequence;
        var topAnimateSequence;
        var widthAnimateSequence;
        var heightAnimateSequence;

        // random position of easter egg on the sides of page (except right one)
        // right side of the page is somehow buggy with this algorithm
        var random = Math.floor(Math.random() * 3);
        if (random === 0) { // left
            randomEasterImage.addClass("rotate90");

            // compute position
            leftPos = 0;
            topPos = (Math.random() * ($(document).height() - randomEasterImage.height())).toFixed();

            // prepare sequences
            leftAnimateSequence = ["+=30", "+=10", "-=10", "+=60", "-=90"];
            topAnimateSequence = ["+=0", "+=0", "+=0", "+=0", "+=0"];
            widthAnimateSequence = ["auto", "auto", "auto", "auto", "auto"];
            heightAnimateSequence = ["auto", "auto", "auto", "auto", "auto"];
        } else if (random === 1) { // top
            randomEasterImage.addClass("rotate180");

            // compute position
            leftPos = (Math.random() * ($(document).width() - randomEasterImage.width())).toFixed();
            topPos = -randomEasterImage.height();

            // prepare sequences
            leftAnimateSequence = ["+=0", "+=0", "+=0", "+=0", "+=0"];
            topAnimateSequence = ["+=30", "+=10", "-=10", "+=60", "-=90"];
            widthAnimateSequence = ["auto", "auto", "auto", "auto", "auto"];
            heightAnimateSequence = ["auto", "auto", "auto", "auto", "auto"];
        } else { // bottom
            randomEasterImage.addClass("rotate0");
            randomEasterImage.height(0);

            // compute position
            leftPos = (Math.random() * ($(document).width() - randomEasterImage.width())).toFixed();
            topPos = $(document).height();

            // prepare sequences
            leftAnimateSequence = ["+=0", "+=0", "+=0", "+=0", "+=0"];
            topAnimateSequence = ["-=30", "-=10", "+=10", "-=60", "+=90"];
            widthAnimateSequence = ["auto", "auto", "auto", "auto", "auto"];
            heightAnimateSequence = ["30px", "+=10", "-=10", "+=60", "-=90"];
        }

        // perform animation itself
        randomEasterImage.css({
            'left': leftPos + 'px',
            'top': topPos + 'px'
        });

        randomEasterImage.animate({
            left: leftAnimateSequence[0],
            top: topAnimateSequence[0],
            width: widthAnimateSequence[0],
            height: heightAnimateSequence[0]
        }, 500, "swing", function() {
            randomEasterImage.delay(500);
            randomEasterImage.animate({
                left: leftAnimateSequence[1],
                top: topAnimateSequence[1],
                width: widthAnimateSequence[1],
                height: heightAnimateSequence[1]
            }, 800, "swing", function() {
                randomEasterImage.animate({
                    left: leftAnimateSequence[2],
                    top: topAnimateSequence[2],
                    width: widthAnimateSequence[2],
                    height: heightAnimateSequence[2]
                }, 500, "swing", function() {
                    randomEasterImage.delay(1000);
                    randomEasterImage.animate({
                        left: leftAnimateSequence[3],
                        top: topAnimateSequence[3],
                        width: widthAnimateSequence[3],
                        height: heightAnimateSequence[3]
                    }, 2000, "swing", function() {
                        randomEasterImage.delay(1000);
                        randomEasterImage.animate({
                            left: leftAnimateSequence[4],
                            top: topAnimateSequence[4],
                            width: widthAnimateSequence[4],
                            height: heightAnimateSequence[4]
                        }, 3000, "swing", function() {
                            randomEasterImage.hide();
                            randomEasterImage.removeClass();
                            randomEasterImage.addClass("easter-egg");
                            randomEasterImage.width(originalWidth);
                            randomEasterImage.height(originalHeight);
                        });
                    });
                });
            });
        });

        // display easter image
        randomEasterImage.show();
    };

    setInterval(generate, 20000);
}

$(function() {
    extendMainIfNeeded();
    aprilHeartGenerator();
    easterEggGenerator();
});
