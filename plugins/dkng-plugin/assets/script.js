jQuery(document).ready(function ($) {


    /**
     * Function of searching page
     *
     */
    function  search_function() {
        if ( $(".search_page").length > 0 ) {
            let count = 3;

            if ( $(".search_page .search-item.hidden").length < 1 ) {
                $("#search_load_more_button").hide();
            }

            $(".search_page").find("#search_load_more_button").on('click', function (e) {
                e.preventDefault();

                let i = 0;
                $(".search_page .search-item.hidden").each(function( index ) {
                    i++;
                    if ( i <= count  ) {
                        $( this ).fadeIn('slow').removeClass('hidden');
                    }
                });

                if ( $(".search_page .search-item.hidden").length < 1 ) {
                    $("#search_load_more_button").hide();
                }
            })
        }
    }

    // search_function();


    /**
     * Function for checking if site support canavas
     *
     */
    function isWebPSupported() {
        const elem = document.createElement('canvas');

        if(!(elem.toDataURL('image/webp').indexOf('data:image/webp') === 0)) {
            document.body.classList.add('no-webP-supported');
        }
    }


    /**
     * Trim textarea function
     *
     */
    function textarea_trim_values() {
        $('textarea').each(function(){
            $(this).val($(this).val().trim());
        });
    }

    /**
     * Function for replacing login page button when user is logged
     *
     */
    function header_function() {
        const header = $('#header');
        const dashboard = $('.menu-item .dashboard_block');
        const dashboardMobile = $('.mobile_menu .dashboard_block');
        const scheduleItem = $('.menu-item .a_schedule');
        const scheduleMobile = $('.mobile_menu .a_schedule');
        const login = header.find('.a_login_block').parent();
        const topNav = $('.header_top_nav');
        const loginLink = $(`<div class="sv-login-link">Already a Member?<a href="${header.data('base')}/advisorlogin/">Login Now</a></div>`);

        const isloggedIn    = header.data('logged');

        dashboardMobile.hide();
        dashboard.hide();
        login.remove();
        scheduleItem.show();

        if ( isloggedIn === 'yes' ) {
            scheduleMobile.hide();
            dashboardMobile.show();

            let url   = dashboard.attr('href');
            let title = dashboard.text();

            scheduleItem.text(title).attr('href', url);

            $('.footer .menu_item, .menu.trans_500 .menu_item').each( function () {
                let href =  $(this).find('a').attr('href');
                if ( href.indexOf('login') >= 0 ) {
                    $(this).hide();
                }
            });
        } else {
            topNav.find(scheduleItem).wrap('<div class="sv-login-wrapper"></div>');
            const loginWrapper = $('.sv-login-wrapper');
            loginWrapper.append(loginLink);
            scheduleItem.attr('target', '_blank');
            scheduleMobile.attr('target', '_blank');
        }

    }



    /**
     * Function scrolling bottom popup
     *
     */
    function scrollFunction() {
        let cookie_popup_closed = readCookie( 'b_popup_closes' );
        if ( ( $(".footer .footer_popup_block").length > 0 ) && ( cookie_popup_closed != 1 ) ) {
            $(".footer .footer_popup_block").fadeIn("slow");
        }
    }

    /**
     * Bottom popup event scroll
     */
    function scroll_function() {
        window.onscroll = scrollFunction;
    }


    /*
     * Tooltip function
     *
     */
    function documentTooltip() {
        let tooltip;

        document.addEventListener('mouseover', function (e) {
            const message = e.target.dataset.tooltip;

            if(!message) return;

            const target = e.target;
            const targetCoordinates = target.getBoundingClientRect();
            tooltip = {
                elem: document.createElement('div'),
                left: 0,
                top: 0
            };

            tooltip.elem.className = "tooltip-popup";
            tooltip.elem.textContent = message;

            target.parentElement.append(tooltip.elem);

            setTimeout(function () {
                tooltip.elem.classList.add('visible');
            }, 100);

        });

        document.addEventListener('mouseout', function () {
            if(tooltip) {
                tooltip.elem.classList.remove('visible');
                new Promise(function (resolve) {
                    setTimeout(function () {
                        resolve();
                    }, 300)
                }).then(function () {
                    tooltip.elem.remove();
                    tooltip = null;
                });
            }
        });
    }



    /* ------------------------------------------- */
    /* 		IMG TO BACKGROUND 	*/
    /* ------------------------------------------- */
    function addImgBg(imgSelector, parentSelector) {
        var $parent,
            $neighbor,
            $imgDataHidden,
            $imgDataSibling,
            $this;

        if (!imgSelector) {
            return false;
        }

        $(imgSelector).each(function () {
            $this = $(this);
            $imgDataHidden = $this.data('s-hidden');
            $imgDataSibling = $this.data('s-sibling');
            $parent = $this.closest(parentSelector);
            $parent = $parent.length ? $parent : $this.parent();

            if ($imgDataSibling) {
                $parent.addClass('img-bg-sibling');
                $neighbor = $this.next();
                $neighbor = $neighbor.length ? $neighbor : $this.next();
                $neighbor.css('background-image', 'url(' + this.src + ')').addClass('img-bg-sibling__neighbor');
            } else {
                $parent.css('background-image', 'url(' + this.src + ')').addClass('img-bg-parent');
            }

            if ($imgDataHidden) {
                $this.css('visibility', 'hidden');
            } else {
                $this.hide();
            }
        });

        return false;
    }

    /**
     *  Move footer to bottom of the window when page height is too small
     */
    function moveFooterToTheBottom() {
        const isDashboard = !!document.querySelector('.dashboard-page');
        const content = document.querySelector('.main-content');
        const footer = document.querySelector('.footer');

        if(!isDashboard || !content || !footer) return;

        setContentMinHeight();

        window.addEventListener('resize', setContentMinHeight);
        window.addEventListener('orientationchange', setContentMinHeight);

        function setContentMinHeight() {
            content.style.minHeight = window.innerHeight - footer.getBoundingClientRect().height + 'px';
        }
    }

    /*
    * Function moves footer to bottom of the screen on FAQ page if window height > page content height
    */
    function moveFooterToTheBottomFAQ() {
        const isFAQ = !!document.querySelector('.page-faq');
        const footer = document.querySelector('.footer');

        if(!isFAQ) return;

        setFooterMargin();

        window.addEventListener('resize', setFooterMargin);
        window.addEventListener('orientationchange', setFooterMargin);

        // if window.innerHeight > page content add margin top to the footer
        function setFooterMargin() {
            if(window.innerHeight > footer.getBoundingClientRect().bottom) {
                footer.style.marginTop = window.innerHeight - footer.getBoundingClientRect().bottom;
            } else {
                footer.style.marginTop = null;
            }
        }
    }

    /**
     *
     */
    function scrollToIdSection() {
        const button = $('.js-scroll-to');

        if(!button.length) return;

        button.on('click', function (e) {
            e.preventDefault();

            $('html, body').animate({
                scrollTop: $($(this).data('scroll')).offset().top
            }, 800);
        });
    }


    /**
     *
     */
    function fixedHeader() {
        const header = $('.header');

        if( $("body").hasClass('not-logged-in-articles') ) {
            $("header").addClass('scrolled');
        }

        if(!header.length || $("body").hasClass('not-logged-in-articles')) return;


        $(window).on('load scroll', function () {
            if ($(this).scrollTop() >= 20) {
                header.addClass('scrolled');
            }
            else {
                header.removeClass('scrolled');
            }
        });
    }


    isWebPSupported();
    fixedHeader();
    scrollToIdSection();
    textarea_trim_values();
    header_function();
    scroll_function();
    documentTooltip();
    addImgBg('.js-img-bg');
    moveFooterToTheBottom();
    moveFooterToTheBottomFAQ();

});

/*
 * Function of preloading pages
 *
 */
window.onload = function () {
    hide_preloader();
};

/**
 * Function of hiding preloader
 *
 */
function hide_preloader(){
    document.body.classList.add( 'loaded_hiding' );
    window.setTimeout( function () {
        document.body.classList.add( 'loaded' );
        document.body.classList.remove( 'loaded_hiding' );
    }, 1 );
}