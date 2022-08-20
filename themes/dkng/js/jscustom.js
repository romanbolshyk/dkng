jQuery(document).ready(function($){
    var menu = $('.menu');
    var menuActive = false;
    if($('.hamburger').length && $('.menu').length)
    {
        var hamb = $('.hamburger');
        var close = $('.menu_close_container');

        hamb.on('click', function()
        {
            if(!menuActive)
            {
                openMenu();
            }
            else
            {
                closeMenu();
            }
        });

        close.on('click', function()
        {
            if(!menuActive)
            {
                openMenu();
            }
            else
            {
                closeMenu();
            }
        });


    }

    function openMenu()
    {
        menu.addClass('active');
        menuActive = true;
    }

    function closeMenu()
    {
        menu.removeClass('active');
        menuActive = false;
    }

});

jQuery(document).ready(function ($) {
    if ($('#slider').length)
    {
        var locSlider = $('#slider');
        locSlider.owlCarousel(
            {
                items: 1,
                autoplay: false,
                loop: true,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                nav: false,
                center: true,
                dots: false,
                margin: 20,
                smartSpeed: 1200
            });

        if ($('#slider').length)
        {
            var nextTitle = $('.up-next');
            var dot = $('.slider-menu .dot');
            var next = $('.loc_slider_nav.next');
            var prev = $('.loc_slider_nav.prev');
            next.on('click', function ()
            {
                locSlider.trigger('next.owl.carousel');
            });

            prev.on('click', function ()
            {
                locSlider.trigger('prev.owl.carousel');
            });

            dot.on('click', function () {
                var x = $(this).index();
                var to = x - 1;
                locSlider.trigger('to.owl.carousel', to);
            });

            locSlider.on('changed.owl.carousel', function(e) {
                if (e.item) {
                    var index = e.item.index - 1;
                    var count = e.item.count;
                    if (index > count) {
                        index -= count;
                    }
                    if (index <= 0) {
                        index += count;
                    }

                    var activeDot = $('.slider-menu .dot.active');
                    var nextDot = dot.eq(index - 1);

                    activeDot.removeClass('active');
                    nextDot.addClass('active');

                    nextTitle.html('<span>Next: </span>' + nextDot.data('next'));
                }
            });

        }

    }
    if ($('.strategy-slider').length)
    {
        var locaSlider = $('.strategy-slider');
        locaSlider.owlCarousel(
            {
                loop: true,
                margin: 10,
                nav: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });


    }
    $(".user-info, img.logo_main").click(function (e) {
        e.preventDefault();
        $(".account-info").addClass('active');
    });
    $(".user-info-close").click(function (e) {
        e.preventDefault();
        $(".account-info").removeClass('active');
    });
    $(".close-collapse").click(function (e) {
        e.preventDefault();
        $("#startCollapse").click();
    });
    $(".card-button").click(function () {
        // $('.upcoming-accordion .card-header').removeClass('active');
        var heading = $(this).attr('data-heading');
        var aria = $(this).attr('aria-expanded');

        if (aria == 'false') {
            $('#' + heading).addClass('active');
        } else {
            $('#' + heading).removeClass('active');
        }
    });
    if ($('.range-slider').length >= 1)
    {
        $(".range-slider").slider();
    }


    var menul = $('.left-menu');
    var menuLeftActive = false;
    if ($('.hamburger-left').length && $('.left-menu').length)
    {
        var hambl = $('.hamburger-left');
        var close = $('.menu_left_close');

        hambl.on('click', function (e)
        {
            e.stopPropagation();
            if (!menuLeftActive)
            {
                openLMenu();
            } else
            {
                closeLMenu();
            }
        });

        close.on('click', function ()
        {
            if (!menuLeftActive)
            {
                openLMenu();
            } else
            {
                closeLMenu();
            }
        });

        $('body').on('click', function (e) {
            if(e.target !== menul.get(0) && menul.hasClass('active')) {
                closeLMenu();
            }
        })

    }

    function openLMenu()
    {
        menul.addClass('active');
        $('body').css('overflowY', 'hidden');
        menuLeftActive = true;
    }

    function closeLMenu()
    {
        menul.removeClass('active');
        $('body').css('overflowY', 'visible');
        menuLeftActive = false;
    }


    var menu = $('.menu');
    var menuActive = false;
    if ($('.hamburger').length && $('.menu').length)
    {
        var hamb = $('.hamburger');
        var close = $('.menu_close_container');

        hamb.on('click', function ()
        {
            if (!menuActive)
            {
                openMenu();
            } else
            {
                closeMenu();
            }
        });

        close.on('click', function ()
        {
            if (!menuActive)
            {
                openMenu();
            } else
            {
                closeMenu();
            }
        });


    }

    function openMenu()
    {
        menu.addClass('active');
        menuActive = true;
    }

    function closeMenu()
    {
        menu.removeClass('active');
        menuActive = false;
    }

    $(".progress.circle").each(function () {

        var value = $(this).attr('data-value');
        var left = $(this).find('.progress-left .progress-bar');
        var right = $(this).find('.progress-right .progress-bar');

        if (value > 0) {
            if (value <= 50) {
                right.css('transform', 'rotate(' + percentage_to_degrees(value) + 'deg)')
            } else {
                right.css('transform', 'rotate(180deg)')
                left.css('transform', 'rotate(' + percentage_to_degrees(value - 50) + 'deg)')
            }
        }

    })

    function percentage_to_degrees(percentage) {

        return percentage / 100 * 360

    }

});
