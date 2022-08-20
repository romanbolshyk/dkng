jQuery(document).ready(function ($) {

    /**
     * Function for exporting campaign's list
     *
     */
    function export_campaign_list_func () {

        if ( $(".js-equal-subject-body").length && ( $(".js-equal-subject-body").find('tr').length < 1 )  ) {
            $(".export_list_btn").addClass('disabled');
        }

        $(".export_list_btn").on( "click", function(e){
            e.preventDefault();

            let id  = $(this).attr('data-id');
            let info = {
                id: id,
                action: 'export_campaign_list'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    var $a = $("<a>");
                    $a.attr("href",data.file);
                    $("body").append($a);
                    $a.attr("download","exported-list.xlsx");
                    $a[0].click();
                    $a.remove();
                },
                error: function (data) {
                    console.log('error');
                },
            });

        })
    }



    /**
     * Function filtering of wealthbox tags
     *
     */
    function lead_wealthbox_form_submit () {

        /*
          * Class for displaying messages after ajax request
          */
        class ActionModalResponse {

            constructor(message = '', callback = null) {
                this.callback = callback;
                this._initTemplate(message);
                this._bindEvents();
            }

            show() {
                document.body.prepend(this.modalContainer);

                setTimeout(() => {
                    this.modalContainer.classList.add('sv-modal-container-showing');
                }, 0);
            }

            hide() {
                this.modalContainer.classList.remove('sv-modal-container-showing');

                setTimeout(() => {
                    this.modalContainer.remove();

                    this._afterCloseAction();
                }, 400);
            }

            _initTemplate(message) {
                this.modalContainer = document.createElement('div');
                this.modalContainer.className = 'sv-modal-container';

                this.content = `<div class="backdrop"></div>
                            <div class="modal">
                                <div class="modal-body">
                                    <p class="modal-message">${message}</p>
                                    <div class="modal-actions d-flex justify-content-end">
                                        <button type="button" class="sv-button sv-button--green">Close</button>
                                    </div>
                                </div>
                            </div>`;
                this.modalContainer.innerHTML = this.content;

                this.backdrop = this.modalContainer.querySelector('.backdrop');
                this.closeButton = this.modalContainer.querySelector('button');
            }

            _bindEvents() {
                this.backdrop.addEventListener('click', this.hide.bind(this));
                this.closeButton.addEventListener('click', this.hide.bind(this));
            }

            _afterCloseAction() {
                if(this.callback instanceof Function) {
                    this.callback();
                }
            }
        }

        $("#import_wealthbox_list").on( "submit", async function(e){
            e.preventDefault();

            $("#wealthbox_loader").show();
            let data  = $(this).serialize();

            let count_contacts1 = $(this).find("#count_contacts").val();
            let count_page1 = $(this).find("#count_page").val();

            let popup = $('#add_lead_popup');

            // let oldForm = document.forms.import_wealthbox_list_name;
            // let formData = new FormData( oldForm );
            // formData.append("action", 'wealthbox_lead_list_importing');
            //
            // formData.append("count_contacts1", count_contacts1);
            // formData.append("count_page1", count_page1);
            //
            let info = {
                data: data,
                count_contacts1: count_contacts1,
                count_page1: count_page1,
                action: 'wealthbox_lead_list_importing'
            };

            /*
            fetch( get.ajaxurl, {
                method: 'POST',
                body: formData,
            } )
                .then( res => res.text() )
                .then( data => {
                    console.log( 'data-response!!', data )
                    $("#wealthbox_loader").hide();

                    if ( data.alert_message == true ) {
                        if(popup.length){
                            $('body').prepend('<div class=" modal-backdrop show"></div>').addClass('no-scroll');
                            popup.addClass('show').css('display', 'block');
                            if(data.message_unsubscribe.length){
                                popup.find('.exit-popup-wrap').append('<div class="top"><h3 class="unsubscribe">'+data.message_unsubscribe+'</h3></div>');
                            }
                            if(data.list_unsubscribe.length){
                                popup.find('.exit-popup-wrap').append('<div class="right block bottom text-center justify-content-center" style="margin: 0 auto"><p class="mb-30">'+data.list_unsubscribe+'</p></div>');
                            }
                            function closeUploadFilePopup() {
                                $('body').removeClass('no-scroll');
                                $('#add_lead_popup').removeClass('show').css('display', 'none');
                                $('.add_lead_popup_overlay').remove();
                            }
                            $(document).on('click', '#add_lead_popup', function (event) {
                                if(!$(event.target).closest('.exit-popup-wrap').length ){
                                    closeUploadFilePopup();
                                    window.location.replace( data.redirect_url );
                                }
                            });
                        }
                    } else {
                        // data = JSON.parse( data );
                        console.log('data-here2', data, data.redirect_url);
                        const message = new ActionModalResponse("Contact list is created successfully.  Please review  it and hit 'Save'.", window.location.replace.bind(window.location, data.redirect_url));

                        message.show();
                    }
                })
                .catch( err => {
                    $("#wealthbox_loader").hide();
                    console.log('error', err);
                } );
            */

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    $("#wealthbox_loader").hide();

                    if ( data.alert_message == true ) {
                        if(popup.length){
                            $('body').prepend('<div class=" modal-backdrop show"></div>').addClass('no-scroll');
                            popup.addClass('show').css('display', 'block');
                            if(data.message_unsubscribe.length){
                                popup.find('.exit-popup-wrap').append('<div class="top"><h3 class="unsubscribe">'+data.message_unsubscribe+'</h3></div>');
                            }
                            if(data.list_unsubscribe.length){
                                popup.find('.exit-popup-wrap').append('<div class="right block bottom text-center justify-content-center" style="margin: 0 auto"><p class="mb-30">'+data.list_unsubscribe+'</p></div>');
                            }
                            function closeUploadFilePopup() {
                                $('body').removeClass('no-scroll');
                                $('#add_lead_popup').removeClass('show').css('display', 'none');
                                $('.add_lead_popup_overlay').remove();
                            }
                            $(document).on('click', '#add_lead_popup', function (event) {
                                if(!$(event.target).closest('.exit-popup-wrap').length ){
                                    closeUploadFilePopup();
                                    window.location.replace( data.redirect_url );
                                }
                            });
                        }
                    } else {

                        const message = new ActionModalResponse("Contact list is created successfully.  Please review  it and hit 'Save'.", window.location.replace.bind(window.location, data.redirect_url));

                        message.show();
                    }

                },
                error: function (data) {
                    $("#wealthbox_loader").hide();
                    console.log('error');
                },
            });

        })
    }

    lead_wealthbox_form_submit();

    /**
     * Function cloning campaigns
     *
     */
    function clone_campaign() {

        $(document).on("click", ".clone_campaign_btn, .clone_campaign_single_page_btn", function (e) {
            e.preventDefault();

            $(this).addClass('loader_campaign');

            var info = {
                campaign_id: $(this).attr('data-id'),
                action: 'clone_campaign'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function ( data ) {
                    console.log('success', data);
                    let popup = $('#add_lead_popup');

                    if ( data.alert_message == true ) {
                        // alert(data.message);
                        if(popup.length){
                            $('body').prepend('<div class=" modal-backdrop show"></div>').addClass('no-scroll');
                            popup.addClass('show').css('display', 'block');
                            if(data.message_duplicates.length){
                                popup.find('.top h3').text(data.message_duplicates);
                            }
                            if(data.list_duplicates.length){
                                popup.find('.bottom').html('<p class="mb-30">'+data.list_duplicates+'</p>');
                            }
                            if(data.message_unsubscribe.length){
                                popup.find('.exit-popup-wrap').append('<div class="top"><h3 class="unsubscribe">'+data.message_unsubscribe+'</h3></div>');
                            }
                            if(data.list_unsubscribe.length){
                                popup.find('.exit-popup-wrap').append('<div class="right block bottom text-center justify-content-center" style="margin: 0 auto"><p class="mb-30">'+data.list_unsubscribe+'</p></div>');
                            }
                            function closeUploadFilePopup() {
                                $('body').removeClass('no-scroll');
                                $('#add_lead_popup').removeClass('show').css('display', 'none');
                                $('.add_lead_popup_overlay').remove();
                            }
                            $(document).on('click', '#add_lead_popup', function (event) {
                                if(!$(event.target).closest('.exit-popup-wrap').length ){
                                    closeUploadFilePopup();
                                    window.location.replace( data.redirect_url );
                                }
                            });
                        }
                    } else {
                        window.location.replace( data.redirect_url );
                    }

                },
                error: function ( data ) {
                    console.log('error');
                    $(".clone_campaign_btn, .clone_campaign_single_page_btn").removeClass('loader_campaign');
                },
            });

        });
    }

    /**
     * Function of deleting cloned campaigns
     *
     */
    function delete_clone_campaign() {

        $(document).on("click", ".delete_cloned_campaign_btn", function (e) {
            e.preventDefault();

            $(this).addClass('loader_campaign');
            let id_campaign = $(this).attr('data-id');

            var info = {
                campaign_id: id_campaign,
                action: 'delete_clone_campaign'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function ( data ) {
                    console.log('success', data);
                    $('.campaign#'+ id_campaign).remove();
                },
                error: function ( data ) {
                    console.log('error');
                    $(".delete_cloned_campaign_btn").removeClass('loader_campaign');
                },
            });

        });
    }

    /**
     * Function for changing cloned campaign name
     *
     */
    function cloned_campaign_change_name() {
        $(".cloned_name_textarea").on("change", function(e) {
            e.preventDefault();
            let val = $(this).val();

            if ( val.length < 1 ) {
                alert("Please fill new name of campaign, it can't be empty");
                return;
            }

            $("#loader_campaign").show();

            var info = {
                campaign_id: $(this).attr('data-id'),
                val: val,
                action: 'change_clone_campaign_name'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function ( data ) {
                    console.log('success', data);
                    $("#loader_campaign").hide();
                },
                error: function ( data ) {
                    console.log('error');
                    $("#loader_campaign").hide();
                },
            });
        })

    }


    /**
     * Function for stopping campaign when it's in progress
     *
     */
    function stop_campaign_function() {
        $(".js_stop_campaign").on( "click", function(e){
            e.preventDefault();

            $(this).addClass('disabled_btn');
            $(".single-campaign #loader").show();

            let id  = $(this).attr('data-id');
            let info = {
                campaign_id: id,
                action: 'stop_campaign'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    console.log('success')
                    $(".single-campaign #loader").hide();
                    $(".js_stop_campaign").removeClass('disabled_btn');
                    document.location.reload();
                },
                error: function (data) {
                    $(".single-campaign #loader").hide();
                    $(".js_stop_campaign").removeClass('disabled_btn');
                    console.log('error');
                },
            });

        })
    }

    /**
     * Function for pausing campaign when it's in progress
     *
     */
    function pause_campaign_function() {
        $(".js_pause_campaign").on( "click", function(e){
            e.preventDefault();
            $(".single-campaign #loader").show();
            $(this).addClass('disabled_btn');

            let id  = $(this).attr('data-id');
            let info = {
                campaign_id: id,
                action: 'pause_campaign'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    console.log('success11')
                    $(".single-campaign #loader").hide();
                    $(".js_pause_campaign").removeClass('disabled_btn');
                    document.location.reload();
                },
                error: function (data) {
                    $(".single-campaign #loader").hide();
                    $(".js_pause_campaign").removeClass('disabled_btn');
                    console.log('error');
                },
            });

        })
    }

    /**
     * Function for restoring  campaign when it's paused
     *
     */
    function restore_campaign_function() {
        $(".js_restore_campaign").on( "click", function(e){
            e.preventDefault();
            $(".single-campaign #loader").show();
            $(this).addClass('disabled_btn');

            let id  = $(this).attr('data-id');
            let info = {
                campaign_id: id,
                action: 'restore_campaign'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    console.log('success11')
                    $(".single-campaign #loader").hide();
                    $(".js_pause_campaign").removeClass('disabled_btn');
                    document.location.reload();
                },
                error: function (data) {
                    $(".single-campaign #loader").hide();
                    $(".js_pause_campaign").removeClass('disabled_btn');
                    console.log('error');
                },
            });

        })
    }


    /**
     * Load More function for campoigns
     *
     */
    function  load_more_campaigns( ) {
        $("#load_more_campaigns").on( "click", function (e) {
            e.preventDefault();

            $(this).addClass('disabled_btn');

            let total_count = $('.all_campaigns_block').attr('data-all');
            let page        = $('.all_campaigns_block').attr('data-page');
            page            = ( page > 1 ) ?  page : 2

            let get_cat     = $('.all_campaigns_block').attr('data-getcat');
            let cpt_type    = $('.all_campaigns_block').attr('data-cpt');
            let campaign_type = ( $(this).hasClass('cloned') ) ? 'cloned' : 'new';

            var data = {
                'action':     'load_posts_by_ajax',
                'total_count': total_count,
                'page':        page,
                'get_cat':     get_cat,
                'cpt_type':    cpt_type,
                'campaign_type':  campaign_type,
            };

            $.ajax({
                url: get.ajaxurl,
                type: "POST",
                data: data,
                success:function(response) {
                    if ( response ) {
                        $(".all_campaigns_block .columns-grid").append(response.html);
                        page++;
                        $('.all_campaigns_block').attr('data-page', page );
                        $('.all_campaigns_block').attr('data-all', response.all );
                        if ( response.count >= response.all ) {
                            $("#load_more_campaigns").hide().removeClass('disabled_btn');
                        }
                        else {
                            $("#load_more_campaigns").removeClass('disabled_btn');
                        }
                    }
                    else {
                        $("#load_more_campaigns").hide().removeClass('disabled_btn');
                    }
                }
            });
        });
    }

    /**
     * Function for statistic tabs for Single Campaign Report's Page
     *
     */
    function single_camapign_report_tabs() {
        $(".statistic_single_report_tabs").find(".report_tab").on( "click", function (e) {
            e.preventDefault();

            $(".statistic_single_report_block .loader").show();
            $(".statistic_single_report_tabs").find(".report_tab").removeClass('active');
            $(this).addClass('active');

            let tab = $(this).attr('data-status');
            let post_id = $(".statistic_single_report_tabs").attr('data-post_id');

            let data = {
                'action': 'single_campaign_report_tab',
                'tab':    tab,
                'post_id': post_id,
            };

            $.ajax({
                url: get.ajaxurl,
                type: "POST",
                data: data,
                success:function(response) {
                    console.log( 'response', response );
                    $(".statistics_tabs_table tbody").hide();
                    $(".statistic_single_report_block .loader").hide();
                    if ( response.html ) {
                        $(".statistics_tabs_table tbody").html(response.html).show();
                    }
                },
                error(jqXHR, textStatus, errorThrown) {
                    $(".statistic_single_report_block .loader").hide();
                }
            });
        });
    }

    cloned_campaign_change_name();
    clone_campaign();
    delete_clone_campaign();
    export_campaign_list_func();
    stop_campaign_function();
    restore_campaign_function();
    pause_campaign_function();
    load_more_campaigns();
    single_camapign_report_tabs();

})