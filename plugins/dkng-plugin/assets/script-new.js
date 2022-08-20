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

});

