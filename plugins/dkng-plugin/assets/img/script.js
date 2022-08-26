jQuery(document).ready(function ($) {

    /**
     * Function of video player for single course page
     *
     */
    function video_player() {

        // setTimeout( function(){ double_click(); }, 0.1 );
        if ( !$(".container").hasClass('video-player') ) {
            return false;
        }
        var first      =  $(".video-player li.lesson").first();
        first.addClass('active');

        var video_link = first.find("a.video-link").attr("data-link");
        var videoId    = getId(video_link);
        var src        = "//www.youtube.com/embed/" + videoId;
        $("#player").attr( 'data-vimeo-url', video_link );

        $(".video-player li.lesson").each( function () {
           if ( $(this).hasClass("checked") ) {
               var video_link = $(this).find("a.video-link").attr("data-link");
               var videoId    = getId(video_link);
               var src        = "//www.youtube.com/embed/" + videoId;

               $(".video-player li.lesson").removeClass('active');
               $(this).addClass('active');
           }
        });

        $(".video-player li.lesson_parent").on("click", function (e) {
            e.preventDefault();
        });

        $(".video-player li.lesson").on("click", function (e) {
            e.preventDefault();

            var video_link = $(this).find("a.video-link").attr("data-link");
            var videoId    = getId(video_link);
            var src        = "//www.youtube.com/embed/" + videoId;

            // $(".video-player").find(".main-video").attr('src', src);
            $(".video-player ul").find("li.lesson").removeClass('active');
            $(this).addClass('active');

            var course_id      = $(this).parents(".single_course_list").attr('data-course');
            var lesson_seconds = $(this).attr('data-seconds');
            var parent_lesson  = ( $(this).parent("ul").hasClass('parent') ) ?  $(this).parent("ul.parent").find("li.lesson_parent").attr('data-index') : 0;
            var info = {
                course_id:      course_id,
                parent_lesson:  parent_lesson,
                lesson_seconds: lesson_seconds,
                lesson_name:    $(this).find("span.video-name").text(),
                lesson_id:      $(this).attr('data-index'),
                lesson_video:   $(this).attr('data-video-id'),
                lesson_link:    $(this).find('a.video-link').attr('data-link'),
                action:        'last_iteraction'
            };

            // console.log( 'info',  info);
            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    // console.log(data);
                    if ( data.done == 1) {
                        location.reload();
                    }
                },
                error: function (data) {
                    // alert('error');
                    console.log('error');
                },
            });

        });

    }

    /**
     * Function double click for active lesson
     *
     */
    function double_click() {
        var player_video_src = $("#player iframe").attr('src');
        var active_video_id  = $(".video-player li.lesson.active").find("a.video-link").attr("data-vimeo-id");
        if ( player_video_src ) {
            var bools = player_video_src.indexOf(active_video_id);
            if ( bools == -1 ){
                console.log('double click');
                $(".video-player li.lesson.active").trigger('click');
            }
        }
    }

    /**
     * Function converting yutube link to embed video link
     *
     */
    function getId( url ) {
        if ( !url ) {
            return false;
        }
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        var match = url.match(regExp);

        if (match && match[2].length == 11) {
            return match[2];
        } else {
            return 'error';
        }
    }

    /**
     * Function pdf exporting from single article page
     *
     */
    function pdf_export() {
        $("a.pdf.share-button").on('click', function (e) {
            e.preventDefault();

            var info = {
                post_id: $(this).attr('data-post-id'),
                post_name: $(this).attr('data-post-name'),
                action: 'ss_get_pdf_url'
            };
            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    console.log('data',data);
                    window.open( data.pdf_file, "_blank");
                },
                error: function (data) {
                    alert('error');
                    console.log('error');
                },
            });

        });
    }

    /**
     * Function word exporting from single article page
     *
     */
    function word_export() {
        $("a.word.share-button").on('click', function (e) {
            e.preventDefault();

            var info = {
                post_id: $(this).attr('data-post-id'),
                post_name: $(this).attr('data-post-name'),
                action: 'word_export'
            };
            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    // console.log('data',data);
                    window.open( data.file_url, "_blank");
                },
                error: function (data) {
                    alert('error');
                    console.log('error');
                },
            });

        });
    }


    /**
     * Function choosing category, loading first page of categorie's posts
     *
     */
    function before_load_more_function() {

        $("div.sorting-categories").find("a.dropdown-item").on( "click", function (e) {
            $("#load_more_button").show();
            e.preventDefault();
            var page = 1;
            var category = $(this).attr('href');
            var cat_name = $(this).text();
            var cpt_type = $('.body-items').attr('data-cpt');
            $('.body-items').attr('data-getcat', category);
            $(".dropdown-toggle").text("Sort by: " + cat_name);

            var data = {
                'action':      'load_posts_by_ajax',
                'total_count': 0,
                'page':        page,
                'get_cat':     category,
                'cpt_type':    cpt_type
            };

            $.ajax({
                url: get.ajaxurl,
                type: "POST",
                data: data,
                success:function(response) {
                    if ( response ) {
                        // console.log(response.html)
                        $(".body-items").html('');
                        $(".body-items").append(response.html);
                        page++;
                        $('.body-items').attr('data-all', response.all );
                        $('.body-items').attr('data-page', 2 );

                        $("span.count-articles").text(response.all);

                        if ( response.count >= response.all ) {
                            $("#load_more_button").hide();
                        }

                    }
                    else {
                        $("#load_more_button").hide();
                    }
                }
            });

        });

        $(".all_posts_categories a.cat").on( "click", function (e) {
            e.preventDefault();
            $("#load_more_posts_button").show();
            var page = 1;
            var category = $(this).attr('href');
            var cat_name = $(this).text();
            var cpt_type = $('.all_posts').attr('data-cpt');
            $('.all_posts').attr('data-getcat', category);
            $(".all_posts_categories a.cat").removeClass('active');
            $(this).addClass('active');

            var data = {
                'action':      'load_posts_by_ajax',
                'total_count': 0,
                'page':        page,
                'get_cat':     category,
                'cpt_type':    cpt_type
            };

            $.ajax({
                url: get.ajaxurl,
                type: "POST",
                data: data,
                success:function(response) {
                    if ( response ) {
                        // console.log(response.html)
                        $(".all_posts").html('');
                        $(".all_posts").append(response.html);
                        page++;
                        $('.all_posts').attr('data-all', response.all );
                        $('.all_posts').attr('data-page', 2 );

                        // console.log('response.count', response.count);
                        // console.log('response.all', response.all);
                        if ( response.count >= response.all ) {
                            $("#load_more_posts_button").hide();
                        }

                    }
                    else {
                        $("#load_more_posts_button").hide();
                    }
                }
            });

        });
    }

    /**
     * Function load more
     *
     */
    function load_more_function( ) {

        $("#load_more_button").on( "click", function (e) {
            e.preventDefault();

            var total_count = $('.body-items').attr('data-all');
            var page  = $('.body-items').attr('data-page');
            page      = ( page > 1 ) ?  page : 2

            var get_cat  = $('.body-items').attr('data-getcat');
            var cpt_type = $('.body-items').attr('data-cpt');

            var data = {
                'action':     'load_posts_by_ajax',
                'total_count': total_count,
                'page':        page,
                'get_cat':     get_cat,
                'cpt_type':    cpt_type
            };

            $.ajax({
                url: get.ajaxurl,
                type: "POST",
                data: data,
                success:function(response) {

                    if ( response ) {
                        $(".body-items").append(response.html);
                        page++;
                        $('.body-items').attr('data-page', page );
                        $('.body-items').attr('data-all', response.all );
                        $("span.count-articles").text( response.all );
                        if ( response.count >= response.all ) {
                            $("#load_more_button").hide();
                        }
                    }
                    else {
                        $("#load_more_button").hide();
                    }
                }
            });
        });

        $("#load_more_posts_button").on( "click", function (e) {
            e.preventDefault();

            var total_count = $('.all_posts').attr('data-all');
            var page        = $('.all_posts').attr('data-page');
            page            = ( page > 1 ) ?  page : 2

            var get_cat  = $('.all_posts').attr('data-getcat');
            var cpt_type = $('.all_posts').attr('data-cpt');

            var data = {
                'action':     'load_posts_by_ajax',
                'total_count': total_count,
                'page':        page,
                'get_cat':     get_cat,
                'cpt_type':    cpt_type
            };

            $.ajax({
                url: get.ajaxurl,
                type: "POST",
                data: data,
                success:function(response) {

                    if ( response ) {
                        $(".all_posts").append(response.html);
                        page++;
                        $('.all_posts').attr('data-page', page );
                        $('.all_posts').attr('data-all', response.all );
                        if ( response.count >= response.all ) {
                            $("#load_more_posts_button").hide();
                        }
                    }
                    else {
                        $("#load_more_posts_button").hide();
                    }

                }
            });
        });

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
     * Function for make active header links by page
     *
     */
    function header_custom_pages() {

        if ( $('.inner_container').hasClass('contact_block') ) {
            $(".header a.a_contact_block").parent('li').addClass('master');
            $('.above-footer').hide();
        }
        else if ( $('.inner_container').hasClass('about_block') ) {
            $(".header a.a_about_block").parent('li').addClass('current');
        }
        else if ( $('.inner_container').hasClass('services_block') ) {
            $(".header a.a_services_block").parent('li').addClass('current');
            $('.above-footer').hide();
        }
        else if ( $('.inner_container').hasClass('blog_block') ) {
            $(".header a.a_blog_block").parent('li').addClass('current');
        }
    }

    /**
     * Function getting form from shortcode
     *
     */
    function login_page_form() {
        var form = $(".box pre").html();
        $(".login_box .form_shortcode").html(form);
        $(".login_box form input[type='checkbox']").parent("p").hide();
        $(".login_box form input[type='submit']").hide();
        $(".login_box form .rcp_lost_password").hide();
    }


    /**
     * Function for replacing login page button when user is logged
     *
     */
    function header_function() {
        let dashboard = $('.menu-item .dashboard_block');
        $('.mobile_menu .dashboard_block').hide();

        dashboard.hide();
        let logged    = $('#header').attr('data-logged');
        $('.menu-item.a_login_block').show();

        if ( logged == 'yes' ) {
            $('.mobile_menu .a_login_block').hide();
            $('.mobile_menu .dashboard_block').show();
            let url   = dashboard.attr('href');
            let title = dashboard.text();
            $('.menu-item .a_login_block').text(title).attr('href', url);

            $('.footer .menu_item, .menu.trans_500 .menu_item').each( function () {
                let href =  $(this).find('a').attr('href');
                if ( href.indexOf('login') >= 0 ) {
                    $(this).hide();
                }
            });
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
                setTimeout(function () {
                    tooltip.elem.remove();
                    tooltip = null;
                }, 300);
            }
        });
    }

    before_load_more_function();
    load_more_function();
    textarea_trim_values();
    header_custom_pages();
    login_page_form();
    video_player();
    header_function();
    scroll_function();

    setTimeout( hide_preloader , 2000 );
});

/*
 * Function of preloading pages
 *
 */
window.onload = function () {
    hide_preloader();
};

function hide_preloader(){
    document.body.classList.add( 'loaded_hiding' );
    window.setTimeout( function () {
        document.body.classList.add( 'loaded' );
        document.body.classList.remove( 'loaded_hiding' );
    }, 1 );
}