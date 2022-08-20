jQuery(document).ready(function ($) {

    console.log('articles.js');

    $(".edit-post-button, .edit_article_button").on( "click", function ( e ) {
        e.preventDefault();
        if ( !$(this).find("a").hasClass('disabled') ) {
            $(".popup_form_edit").show();
            const _body = $('body');
            const _overlay = $('<div class="overlay"></div>');
            _body.addClass('no-scroll');
            _body.prepend(_overlay);
            _overlay.css('display', 'block');
        }
    });

    /**
     * Function for downloading process for article
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
                    if($(".download-document-popup-wrap .download-overlay").length){
                        $(".download-document-popup-wrap .download-overlay").trigger('click');
                    }
                },
                error: function (data) {
                    console.log('error');
                },
            });

        })
    }

    /**
     * Function open downloads
     *
     */
    function open_downloads_function() {
        $(".word-pdf-button1").on("click", function (e) {
            e.preventDefault();
            $(this).parent().find('.download-overlay').show();
            $(this).parent().find('.download-document-popup').show();
        })
        $(".download-document-popup-wrap .download-overlay").on("click", function (e) {
            e.preventDefault();
            $(this).parent().find('.download-overlay').hide();
            $(this).parent().find('.download-document-popup').hide();
        })
        $(".download-document-popup-wrap .cancel").on("click", function (e) {
            e.preventDefault();
            $(".download-document-popup-wrap .download-overlay").trigger('click');
        })
        $(".download-document-popup-wrap .close-popup").on("click", function (e) {
            e.preventDefault();
            $(".download-document-popup-wrap .download-overlay").trigger('click');
        })
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
     * Function cloning original article
     *
     */
    function clone_article() {
        $(".clone_article").on("submit", function (e) {
            e.preventDefault();
            $("#loader").show();

            var file_data = $(this).find("input[name='thumbnail']").prop('files')[0];

            if($(this).find("#editor").length){
                let html =  $(this).find("#editor").html();
                $(this).find("textarea#content_cloned_article").val(html);
            }

            let data      = $(this).serialize();

            let form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('data', data);
            form_data.append('action', 'clone_article');

            $(".edit-post-button, .edit-post-button a, .clone_article input[type='submit']").addClass('disabled_btn');
            $(".loaded .preloader").show().css('background', 'initial');

            $.post({
                url: get.ajaxurl,
                data: form_data,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#loader").show();
                    $(".popup_form_edit").hide();
                    window.location.href = data.redirect_link;
                },
                error: function (data) {
                    $("#loader").hide();
                    $(".loaded .preloader").hide()
                    console.log('error');
                },
            });
        });
    }

    /**
     * Function editing cloned article
     *
     */
    function edit_cloned_article() {
        $(".edit_cloned_article_form").on("submit", function (e) {
            e.preventDefault();
            $("#loader").show();

            var file_data = $(this).find("input[name='thumbnail']").prop('files')[0];

            if($(this).find("#editor").length){
                let html =  $(this).find("#editor").html();
                $(this).find("textarea#content_cloned_article").val(html);
            }

            let data      = $(this).serialize();

            let form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('data', data);
            form_data.append('action', 'edit_cloned_article');

            $(".edit_article_button, .reset_article_button, .edit_cloned_article_form input[type='submit']").addClass('disabled_btn');
            $(".loaded .preloader").show().css('background', 'initial');
            $.post({
                url: get.ajaxurl,
                data: form_data,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#loader").show();
                    $(".popup_form_edit").hide();
                    location.reload();
                },
                error: function (data) {
                    $("#loader").hide();
                    $(".loaded .preloader").hide()
                    console.log('error');
                },
            });
        });
    }


    /**
     * Function editing cloned article
     *
     */
    function reset_cloned_article() {
        $(".reset_article_button").on("click", function (e) {
            e.preventDefault();

            let article_id = $(this).attr('data-id');
            var info = {
                article_id: article_id,
                action: 'reset_cloned_article'
            };
            $(".loaded .preloader").show().css('background', 'initial');

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    $("#loader").show();
                    console.log('success');
                    $(".edit_article_button, .reset_article_button").addClass('disabled_btn');
                    window.location.href = data.redirect_link;
                },
                error: function (data) {
                    $("#loader").hide();
                    $(".loaded .preloader").hide()
                    console.log('error');
                },
            });

        })
    }

    /**
     * Function change published status of article
     *
     */
    function publish_article() {
        $("#published").on( "change", function () {

            let id_user   = $(this).attr( 'data-user' );
            let id_post   = $(this).attr( 'data-post' );
            let id_shared = $(this).attr( 'data-shared-post' );
            let link      = $(this).attr( 'data-permalink' );

            $("#loader1").show();
            $("#input_url").attr('disabled', 'disabled');

            let checked = false;

            if ( $(this).is(":checked") ) {
                checked = 1;
            }
            else {
                checked = 0;
            }

            let data = {
                'action':   'published_articles',
                'checked':   checked,
                'id_user':   id_user,
                'id_post':   id_post,
                'id_shared': id_shared,
            };

            $.ajax({
                url: get.ajaxurl,
                type: "POST",
                data: data,
                success:function( response ) {
                    $("#loader1").hide();
                    $("#input_url").attr('disabled', false);
                    if ( checked == 1 ) {
                        $('.btn_link_copy').addClass('visible');

                        $(".sharing_block .addtoany_shortcode a.social-link").removeClass('disabled_hrefs');

                        if ( $("span.show_customlink_text").length > 0 ) {
                            $("span.show_customlink_text").hide();
                        }

                        let res = response.response;
                        $("input.input_url").val( res.new_post_permalink );
                        $(".sharing_block").attr( 'data-link', res.new_post_permalink );
                        $(".addtoany_shortcode .addtoany_list").attr( 'data-a2a-url', res.new_post_permalink );
                        $(".social-link.big.pdf.share-button").attr( 'data-post-id', res.new_post_id );
                        $(".social-link.big.pdf.share-button").attr( 'data-post-name', res.new_post_title );
                        $(".social-link.big.word.share-button").attr( 'data-post-id', res.new_post_id );
                        $("input#published").attr( 'data-shared-post', res.new_post_id );

                        if ( $(".sharing_block a.social-link.big.pdf.share-button").attr( 'href' ) != '' ) {
                            $(".sharing_block a.social-link.big.pdf.share-button").removeClass('disabled_hrefs')
                        }

                        if ( $(".sharing_block a.social-link.big.word.share-button").attr( 'href' ) != '' ) {
                            $(".sharing_block a.social-link.big.word.share-button").removeClass('disabled_hrefs')
                        }
                    }
                    else  {
                        $('.btn_link_copy').removeClass('visible');

                        $("input.input_url").val('');
                        $(".sharing_block a").addClass('disabled_hrefs');
                    }
                }
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
                    console.log('error');
                },
            });

        });
    }

    downloads_function();
    open_downloads_function();
    disable_sharing();
    clone_article();
    edit_cloned_article();
    reset_cloned_article();
    publish_article();
    share_article();

})