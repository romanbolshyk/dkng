jQuery(document).ready(function ($) {

    $("#completed_recomendation_table").tablesorter();
    $(".addtoany_shortcode a").addClass('social-link big');
    $(".related-edited-articles-sharing .addtoany_shortcode a span").removeClass('').addClass('social-link big');

    /**
     * Function completing course for single course page
     *
     */
    function complete_course_function() {

        $(".complete_task_button").on("click", function (e) {
            e.preventDefault();

            var info = {
                course_id: $(this).attr('data-course-id'),
                action: 'complete_course'
            };
            $.post({
                url: get.ajaxurl,
                data: info,
                success: function ( data ) {
                    // console.log( data );
                    alert('success');
                    $(".complete_task_button").removeClass("complete_task_button").text('Already completed.');
                },
                error: function ( data ) {
                    alert('error');
                    console.log('error');
                },
            });

        });

    }

    /**
     * Function reading course
     *
     */
    function read_course() {
        $(".read-course").on( "click", function (e) {
            e.preventDefault();

            var href = $(this).attr('href');
            var info = {
                course_id: $(this).attr('data-course-id'),
                action: 'read_course'
            };
            $.post({
                url: get.ajaxurl,
                data: info,
                success: function ( data ) {
                    // console.log( data );
                    window.location.replace( href );
                },
                error: function ( data ) {
                    // alert('error');
                    console.log('error');
                },
            });

        });
    }

    /**
     * Function reading article
     *
     */
    function read_article() {
        $(".read-article").on( "click", function (e) {
            e.preventDefault();

            var href = $(this).attr('href');
            var info = {
                article_id: $(this).attr('data-post-id'),
                type: 'read',
                action: 'share_read_article'
            };
            $.post({
                url: get.ajaxurl,
                data: info,
                success: function ( data ) {
                    // console.log( data );
                    window.location.replace( href );
                },
                error: function ( data ) {
                    alert('error');
                    console.log('error');
                },
            });

        });
    }

    /**
     * Function sharing article
     *
     */
    function share_article() {

        var post_id = $(".sharing_block").attr('data-post');
        $(".addtoany_shortcode a.social-link").addClass('share-button').attr('data-post-id', post_id);

        $(".share-button").on( "click", function (e) {
            // e.preventDefault();

            var href = $(this).attr('href');
            var info = {
                article_id: $(this).attr('data-post-id'),
                type: 'share',
                action: 'share_read_article'
            };
            $.post({
                url: get.ajaxurl,
                data: info,
                success: function ( data ) {
                    console.log( data );
                },
                error: function ( data ) {
                    alert('error');
                    console.log('error');
                },
            });

        });
    }

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
     * Function editing user account info
     *
     */
    function account_info() {

        $("form#account-info").on('submit', function (e) {
            $("#loader").show();
            e.preventDefault();
            var info = {
                data: $(this).serialize(),
                action: 'edit_user_account'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    $("#loader").hide();
                    // console.log(data);
                    if ( data.status == 'Done' ) {
                        location.reload();
                    }
                },
                error: function (data) {
                    alert(data.responseJSON.message);
                    console.log('error');
                },
            });

        });
    }

    /**
     * Function changing image for user account
     *
     */
    function account_image() {

        $("form#user-image input#user_image").on('change', function (e) {
            e.preventDefault();
            $("form#user-image").trigger('submit');
        });

        $("form#user-image").on('submit', function (e) {
            e.preventDefault();
            $("#loader-image").show();
            var file_data = $('#user_image').prop('files')[0];

            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('action', 'user_image');

            $.post({
                url: get.ajaxurl,
                data: form_data,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#loader-image").hide();
                    // console.log(data);
                    setTimeout( location.reload(), 500 );
                },
                error: function (data) {
                    alert(data.responseJSON.message);
                    console.log('error');
                },
            });

        });
    }

    $(".edit-user-account").on( "click", function (e) {
        e.preventDefault();
        $("#account-info").find('input').first().focus();
    });

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

    $(".close_popup").on( "click", function () {
        $(".popup_form_edit").hide();
    });

    $(".edit-post-button").on( "click", function ( e ) {
        e.preventDefault();
        if ( !$(this).find("a").hasClass('disabled') ) {
            $(".popup_form_edit").show();
        }
    });

    /**
     * Function change published status of article
     *
     */
    $("#published").on( "change", function () {

        var id_user = $(this).attr( 'data-user' );
        var id_post = $(this).attr( 'data-post' );
        var link    = $(this).attr( 'data-permalink' );

        var checked = false;

        if ( $(this).is(":checked") ) {
            checked = 1;
        }
        else {
            checked = 0;
        }

        var data = {
            'action':  'published_articles',
            'checked':  checked,
            'id_user':  id_user,
            'id_post':  id_post,
        };

        $.ajax({
            url: get.ajaxurl,
            type: "POST",
            data: data,
            success:function( response ) {

                // console.log( response );

                if ( checked == 1 ) {
                    $(".sharing_block .addtoany_shortcode a.social-link").removeClass('disabled_hrefs');

                    var res = response.response;
                    $("input.input_url").val( res.new_post_permalink );
                    $(".sharing_block").attr( 'data-link', res.new_post_permalink );
                    $(".addtoany_shortcode .addtoany_list").attr( 'data-a2a-url', res.new_post_permalink );
                    $(".social-link.big.pdf.share-button").attr( 'data-post-id', res.new_post_id );
                    $(".social-link.big.pdf.share-button").attr( 'data-post-name', res.new_post_title );
                    $(".social-link.big.word.share-button").attr( 'data-post-id', res.new_post_id );

                    if ( $(".sharing_block a.social-link.big.pdf.share-button").attr( 'href' ) != '' ) {
                        $(".sharing_block a.social-link.big.pdf.share-button").removeClass('disabled_hrefs')
                    }

                    if ( $(".sharing_block a.social-link.big.word.share-button").attr( 'href' ) != '' ) {
                        $(".sharing_block a.social-link.big.word.share-button").removeClass('disabled_hrefs')
                    }

                }
                else  {
                    $("input.input_url").val('');
                    $(".sharing_block a").addClass('disabled_hrefs');
                }

            }
        });

    });

    /**
     * Function editing post
     *
     */
    function edit_post() {
        $(".edit_post").on("submit", function (e) {
            e.preventDefault();
            $("#loader").show();

            var file_data = $(this).find("input[name='thumbnail']").prop('files')[0];
            var data      = $(this).serialize();

            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('data', data);
            form_data.append('action', 'edit_post');

            $.post({
                url: get.ajaxurl,
                data: form_data,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#loader").hide();
                    $(".popup_form_edit").hide();
                    // console.log(data);
                    location.reload();
                },
                error: function (data) {
                    alert(data.responseJSON.message);
                    console.log('error');
                },
            });
        });
    }

    /**
     * Function disabling sharing for post when it doesn't have related article
     *
     */
    function disable_sharing() {
        if ( !$(".sharing_block").attr("data-link") ) {
            $(".sharing_block a").addClass('disabled_hrefs');
        }
    }

    /**
     * Function on js for upcoming webinars
     *
     */
    function upcoming_js() {

        $(".view_details").each(function () {
            if ( $(this).parents(".card").find(".collapse").hasClass('show') ) {
                $(this).text("HIDE DETAILS");
            }
            else{
                $(this).text("VIEW DETAILS");
            }
        });

        $(".view_details").on("click", function () {
            var text = $(this).text();
            if ( text == "HIDE DETAILS" ) {
                $(this).parents(".card-header").removeClass('active');
                $(this).text("VIEW DETAILS");
            }
            else if ( text == "VIEW DETAILS" ) {
                $(".card").find('.view_details').text("VIEW DETAILS");
                $(".card").find('.card-header').removeClass('active');
                $(".card").find('collapse').removeClass('show');

                $(this).parents(".card").find('.card-header').addClass('active');
                $(this).parents(".card").find('collapse').addClass('show');
                $(this).text("HIDE DETAILS");
            }
        });
    }

    /**
     * Function for main tabs
     *
     */
    function main_tabs() {
        if ( $('.container').hasClass('content') ) {
            $(".main_tabs .nav-item a.content_tab").addClass('active');
        }
        else if ( $('.container').hasClass('training') ) {
            $(".main_tabs .nav-item a.training_tab").addClass('active');
        }
        else if ( $('.container').hasClass('home-container') ) {
            $(".main_tabs .nav-item a.home_tab").addClass('active');
        }
    }

    /**
     * Function for welcome block
     *
     */
    function welcome() {
        $(".close-welcome").on("click", function () {
            localStorage.setItem( 'closed_welcome_block', '1');
            $(".welcome_block").hide();
        });
        $(".logout_button").on("click", function () {
            localStorage.setItem( 'closed_welcome_block', '0');
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
     * Function of submitting functionality for Contact page and Exit popup
     *
     */
    function contact_page_exit_popup_forms() {

        $("#contact_form").on('submit', function (e) {
            e.preventDefault();
            $("#loader").show();
            var info = {
                data: $(this).serialize(),
                action: 'contact_page'
            };

            var contact_form = ( $(this).parents('.exit_popup_block').length == 1 ) ? false : true;

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    $("#loader").hide();
                    if ( !contact_form ) {
                        $(".exit_popup_block #contact_form").trigger('reset');
                        $(".exit_popup_block #contact_form").hide();
                        $(".exit_popup_block .success_message_block h3").text("Sent.");
                        setCookie('e_popup_closed', 1, 720 );
                        $(".exit_popup_block .success_message_block").show();
                    }
                    else {
                        $(".contact_page_block #contact_form").trigger('reset');
                        $(".contact_page_block .form_contact_box").hide();
                        $(".contact_page_block .success_message_block").show();
                    }
                },
                error: function (data) {
                    console.log('error');
                    console.log(data.responseJSON.message);
                },
            });

        });
    }

    /**
     * Function for thing to do complete/uncomplete
     *
     */
    function thing_to_do_functionality() {

        $("form.thing_to_do input[type=checkbox]").each( function () {
            if ( $(this).attr('checked') ) {
                $(this).attr('disabled', 'disabled');
                $(this).next().css('cursor', 'not-allowed');
            }
        });

        $("form.thing_to_do input").on('change', function (e) {
            e.preventDefault();

            var id = $(this).attr('id');
            if ( !$(this).attr('checked') ) {
                $(this).attr('checked','checked');
            }

            var info = {
                id_r: $(this).attr('data-idr'),
                id_u: $(this).attr('data-idu'),
                action: 'thing_to_do'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    $("#"+id).attr('disabled', 'disabled');
                    $("#"+id +"+label").css('cursor', 'not-allowed');
                    $("#"+id +"+label span").css('background-color', '#00c7c7');
                },
                error: function (data) {
                    alert(data.responseJSON.message);
                    console.log('error');
                },
            });


        });

    }

    /**
     * Function for profile
     *
     */
    function profile_function(){
        var closed_welcome = localStorage.getItem( 'closed_welcome_block');
        if ( closed_welcome == '1' ) {
            $('.welcome_block').hide();
        }

        $(".dashboard-page .account-info .social-link").each(function () {
            if( $(this).attr('href') == '' ) {
                $(this).addClass('empty_link');
            }
        });

        $(document).mouseup(function (e) {
            var container = $(".account-info");
            if ( !container.is(e.target)&& container.has(e.target).length === 0 && container.hasClass('active') ) {
                $(".account-info").removeClass('active');
            }
        });

    }

    /**
     * Functionality js for sign up page
     *
     */
    function sign_up_page() {

        if ( $(".inner_container").hasClass('sign_up_page') ) {

            $("#rcp_gateway_extra_fields").removeClass('col-12 one-card pxy-20 mt-3 mb-1').addClass( "col-lg-8 offset-lg-2 col-sm-12 case-studies text-center" );
            $("#rcp_card_name_wrap").addClass("col-lg-12");
            $("#rcp_card_wrap").addClass('col-lg-12');

            var bef_text  = '<div class="before_pr"></div>';
            let price      = $(".sign_up_page").attr('data-price');
            let total_txt  = $("#rcp_registration_form .totat_area_text").text();
            price          = ( price ) ? price : 0;
            let total_price_html = '<div class="col-lg-12 d-flex justify-content-start align-items-center flex-row">\n' +
                '                       <label>'+ total_txt +'</label>\n' +
                '                   </div>';

            $("#rcp_gateway_extra_fields").wrap('<div class="row"><div class="col-lg-12"></div></div>');
            $("#rcp_submit_wrap").wrap('<div class="col-lg-6 offset-lg-3 col-sm-12 before_privacy"></div>');
            $(".before_privacy").before( bef_text );
            $(".privacy_block").detach().appendTo('.before_pr');
            // $(".before_privacy").before(privacy_block);
            $('#email_block').after( $('#additional_fields_rcp>div') );
            $("#rcp_gateway_extra_fields").append(total_price_html);
        }
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
     * Function for admin panel - Companies and Listeners
     *
     */
    function admin_scripts_function() {
        custom_admin_function( 'need_companies', 'uncompanies_list' );
        custom_admin_function( 'need_listeners', 'unlisteners_list' );
    }

    /**
     * Custom function for companies-listeners
     *
     * @param input_name
     */
    function custom_admin_function( input_name, select_name ) {

        if ( $("input[name="+input_name+"]") ) {
            let checked_input = $("input[name="+input_name+"]:checked").val();
            custom_actions( checked_input, select_name );
        }

        $("input[name="+input_name+"]").on( "change", function () {
            let checked = $(this).val();
            custom_actions( checked, select_name )
        });
    }

    /**
     * Actions for companies values
     *
     * @param variable
     */
    function custom_actions( variable, select_name ) {
        if ( variable == "yes" ) {
            $( "select#" + select_name ).attr( "required", true );
            $( "select#" + select_name + " option:selected").attr('disabled', false );
            $( "select#" + select_name ).show();
        }
        else {
            $( "select#" + select_name ).hide();
            $( "select#" + select_name ).attr( "required", false );
            $( "select#" + select_name +" option:selected" ).attr('disabled', 'disabled');
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

    /**
     * Function closing bottom popup
     *
     */
    function close_popup() {
        $(".exit_b_popup").on("click", function () {
            setCookie('b_popup_closes', 1, 24);
            $(".footer_popup_block").fadeOut("slow");
        });
        $(".exit_b_popup.exit_exit_popup").on("click", function () {
            $(".exit_popup_block").modal('hide');
            setCookie('e_popup_closed', 1, 720 );
        });
        $(".exit_e_popup").on("click", function () {
            let href = readCookie( 'a_link' )
            setCookie('e_popup_closed', 1, 720 );
            $(".exit_popup_block").fadeOut("slow");
        });
    }

    /**
     * Function for exit_popup
     *
     */
    function exit_popup_function() {
        var array1 = readCookie( 'visited_pages');
        var showed = readCookie( 'exit_popup_show');
        var res    = [];
        if ( typeof array1 == 'string' ) {
            var res = array1.split(",");
        }
        let href   = window.location.href;

        if ( ( array1 && ( array1.indexOf( href ) === -1 ) ) || ( !array1 ) ) {
            res.push( href );
        }

        if ( ( res.length >= 2 ) && ( !showed ||( showed != 'yes' ) ) ) {
            setCookie( 'exit_popup_show', 'yes', 360 )
        }
        setCookie( 'visited_pages', res, 24 )

    }

    /**
     * Event of leaving page
     *
     * @returns {*|jQuery|boolean}
     */
    function leaving_page_function() {

        $(document).on("mouseleave", function () {
            let exit_popup_show  = readCookie( 'exit_popup_show' );
            let e_popup_closed   = readCookie( 'e_popup_closed' );

            if ( ( $(".footer .exit_popup_block").length > 0 ) && ( exit_popup_show == 'yes' ) && ( e_popup_closed != 1 ) ) {
                showModal();
            }
        })
    }

    /**
     * Show modal window function
     *
     * @returns {*|jQuery}
     */
    function showModal() {
        $(".exit_popup_block").modal('show');
    }

    /**
     *
     * @param name
     * @returns {string|null}
     */
    function readCookie( name ) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for( var i=0;i < ca.length;i++ ) {
            var c = ca[i];
            while ( c.charAt(0)==' ' ) c = c.substring( 1,c.length );
            if ( c.indexOf( nameEQ) == 0 ) return c.substring( nameEQ.length,c.length );
        }
        return null;
    }

    /**
     * Function setting cookie on few hours
     *
     *
     * @param name
     * @param value
     * @param hours
     */
    function setCookie( name, value, hours ) {
        if ( hours ) {
            var date = new Date();
            date.setTime( date.getTime()+( hours*60*60*1000 ) );
            var expires = "; expires="+date.toGMTString();
        }
        else {
            var expires = "";
        }

        document.cookie = name+"="+value+expires+"; path=/";
    }


    /**
     * Function for downloading process
     *
     */
    function downloads_function() {
        $(".word-pdf-button").on("click", function (e) {
            e.preventDefault();

            let href      = $(this).attr('href');
            let post_id   = $(this).attr('data-post-id');
            let post_type = $(this).attr('data-file-type');
            var info = {
                post_id: post_id,
                post_type: post_type,
                action: 'downloads_process'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    console.log('success');
                    window.open( href );
                },
                error: function (data) {
                    console.log('error');
                },
            });

        })
    }

    /**
     * Header notifications function
     *
     */

    function notifications() {
        //bell
        const notifications = document.querySelector('.js-notifications');

        if (!notifications) return;

        //count of a new notification
        const count = notifications.firstElementChild.firstElementChild;
        //notifications list
        const list = notifications.lastElementChild;
        //state of the list
        let isActive = false;

        //set the equal width for count
        count.style.width = count.offsetHeight + 'px';

        //open/close notification list
        document.addEventListener('click', function (e) {
            const target = e.target.closest('.js-notifications');

            if (target && !isActive) {
                list.classList.add('active');
                isActive = true;
            } else if (isActive) {
                list.classList.remove('active');
                isActive = false;
            }
        });
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


    /*
     * To Do list function
     *
     */

    function todoList() {
        const tabs = $('.sv-tasklist ul.tabs li');
        const tabContent = $('.sv-tasklist .tab-content');
        const checkboxes = $('.sv-task__checkbox');

        tabs.on('click',function() {
            const _this = $(this);
            const tab_id = _this.attr('data-tab');

            tabs.removeClass('active');
            tabContent.removeClass('active');

            _this.addClass('active');
            $("#"+tab_id).addClass('active');
        });

        checkboxes.on('click', function (e) {
            const _this = $(this);

            if($(e.target).hasClass('clicked')) {
                _this.toggleClass('clicked');
            } else {
                _this.parent().find('.sv-task__checkbox.clicked').removeClass('clicked');
                _this.addClass('clicked');
            }
        });
    }

    leaving_page_function();
    exit_popup_function();
    setTimeout( sign_up_page , 2500 );
    notifications();
    // pdf_export();
    // word_export();
    close_popup();
    share_article();
    read_article();
    read_course();
    account_info();
    account_image();
    complete_course_function();
    before_load_more_function();
    load_more_function();
    textarea_trim_values();
    edit_post();
    disable_sharing();
    upcoming_js();
    main_tabs();
    welcome();
    header_custom_pages();
    login_page_form();
    contact_page_exit_popup_forms();
    thing_to_do_functionality();
    video_player();
    profile_function();
    header_function();
    admin_scripts_function();
    scroll_function();
    // downloads_function();
    // todoList();
    // documentTooltip();

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