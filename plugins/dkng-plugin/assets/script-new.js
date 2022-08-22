jQuery(document).ready(function ($) {
    /**
     * Load More function for campoigns
     *
     */
    function  load_more_announces( ) {
        $(".announced_loadmore").on( "click", function (e) {
            e.preventDefault();

            $("#loader_more").show();
            $(this).addClass('disabled_btn');

            let announce_type = $(this).attr('data-type');
            let page        = $('.all_campaigns_block').attr('data-page');
            page            = ( page > 1 ) ?  page : 2


            var data = {
                'action':     'load_announces_by_ajax',
                'page':        page,
                'announce_type':  announce_type,
            };

            $.ajax({
                url: get.ajaxurl,
                type: "POST",
                data: data,
                success:function(response) {
                    $("#loader_more").hide();
                    if ( response ) {
                        $(".podcast_block-list .container").append(response.html);
                        page++;
                        $('.announced_loadmore').attr('data-page', page );
                        if ( response.count >= response.all ) {
                            $(".announced_loadmore").hide().removeClass('disabled_btn');
                        }
                        else {
                            $(".announced_loadmore").removeClass('disabled_btn');
                        }
                    }
                    else {
                        $(".announced_loadmore").hide().removeClass('disabled_btn');
                    }
                }
            });
        });
    }
    load_more_announces();


   

    /**
     * Mobile Menu
     */
    const NavMenu = function() {
        const menu = function() {
            const navItem = $('.menu-item-has-children > a');
            const burger = $('.js-burger');
            const closeNav = $('.js-close-nav');
            const nav = $('.c-header__menu');

            navItem.on('click', function(e) {
                e.preventDefault();

                $(this).next().toggleClass('open');
            });

            burger.on('click', function(e) {
                e.preventDefault();

                nav.toggleClass('open');
            });

            closeNav.on('click', function(e) {
                e.preventDefault();

                nav.removeClass('open');
            });
        }
    
        return {
            init: function () {
                menu();
            }
        }
    }();
    
    NavMenu.init();

    /**
     * Toggle Search Form
     */

    function toggleSearch() {
        const openBtn = $('.js-search-open');
        const closeBtn = $('.js-search-close');
        const form = $('.js-search-form');

        openBtn.on('click', function(e) {
            e.preventDefault();

            form.addClass('active');
        });

        closeBtn.on('click', function(e) {
            e.preventDefault();

            form.removeClass('active');
        });
    }

    toggleSearch();

});




