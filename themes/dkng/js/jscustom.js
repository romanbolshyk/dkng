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

    $(".close-collapse").click(function (e) {
        e.preventDefault();
        $("#startCollapse").click();
    });


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


});
