(function ($) {

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
                    window.location.replace( href );
                },
                error: function ( data ) {
                    console.log('error');
                },
            });

        });
    }

    /**
     * Function pie chart with percent value
     *
     */
    function initialize_percentage() {

        if(!($.fn.easyPieChart instanceof Object)) return;

        let chart = $('.js-chart').easyPieChart({
            size: 60,
            barColor: '#00c7c7',
            scaleColor: false,
            trackColor: '#dde6ef',
            lineCap: 'square',
            lineWidth: 3
        });
        return function (index, percent) {
            if ( percent !== '' ) {
                chart.eq(index).data('easyPieChart').update(percent);
            }
        }
    }

    const updatePercentage = initialize_percentage();

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


        $('form.thing_to_do .checkout__recomendation-checkbox').hover(function() {
            $(this).find("span.checkout__recomendation-box").css('background', '#00c7c7');
        },function() {
            $(this).find("span.checkout__recomendation-box").css('background', 'lightgrey');
        });

        $("form.thing_to_do input").on('change', function (e) {
            e.preventDefault();

            let id   = $(this).attr('id');
            let type = $(this).attr('data-type');

            if ( !$(this).attr('checked') ) {
                $(this).attr('checked','checked');
            }

            let info = {
                id_r: $(this).attr('data-idr'),
                type: $(this).attr('data-type'),
                id_u: $(this).attr('data-idu'),
                action: 'thing_to_do'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    if ( type == 'save' ) {
                        $("#"+id).parents(".sv-task").delay(100).appendTo("#tab-2");
                    }
                    else if ( ( type == 'done' ) || ( type == 'not-for-me' ) ) {
                        $("#"+id).parents(".sv-task").fadeOut('slow');
                    }
                    // $("#"+id).attr('disabled', 'disabled');
                    // $("#"+id +"+label").css('cursor', 'not-allowed');
                    // $("#"+id +"+label span").css('background-color', '#00c7c7');
                },
                error: function (data) {
                    console.log('error');
                },
            });

        });

    }

    /**
     * Function for generating custom link for campaigns
     *
     */
    function campaign_custom_link() {
        $(".campaign_custom_link_btn").on( "change", function () {

            let id_user   = $(this).attr( 'data-user' );
            let id_post   = $(this).attr( 'data-id' );
            let id_shared = $(this).attr( 'data-shared-post' );
            let shared_link = $(this).attr( 'data-shared-link' );

            // let checked = false;
            let checked = ( $(this).is(":checked") ) ? 1 : 0;

            if ( checked == 0 ) {
                $(".sv-link-popup").find("input.custom_link_input").val('').prop('disabled', false);
            }
            else {
                // $(this).prop('checked');
                if ( shared_link ) {
                    $(".sv-link-popup").find("input.custom_link_input").val(shared_link).prop('disabled', true);
                }
                else {
                    $(".sv-link-popup__checkbox-flex").addClass( 'loading' );
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
                            $(".sv-link-popup__checkbox-flex").removeClass( 'loading' );
                            if ( checked == 1 ) {
                                let res = response.response;
                                $(".sv-link-popup").find("input.custom_link_input").val( res.new_post_permalink ).prop('disabled', true);
                            }
                            else  {
                                $(".sv-link-popup").find("input.custom_link_input").val( '' ).prop('disabled', false);
                            }
                        }
                    });
                }
            }

        });
    }


    /**
     * Scheduling campaigns forms
     *
     */
    function scheduling_campaign_form() {

        if ( $(".scheduling_campaign_form").length > 0 ) {
            let status = $(".js-submit-campaign").text();
            if ( status.trim() == 'Save' ) {
                $(".scheduling_campaign_form").addClass('edited_form');
            }
        }

        /**
         * Function saving campaign as draft
         *
         */
        $(".js-draft-submit-campaign").on("click", function ( e ) {
            e.preventDefault();
            $(this).prop('disabled', true);
            $(".scheduling_campaign_form").addClass('draft_form');
            $(".scheduling_campaign_form").attr('data-draft_time', 'onetime');
            $(".scheduling_campaign_form").trigger('submit');
            $(this).prop('disabled', false);
        })

        /**
         * Submitting scheduling form function
         *
         */
        $(".scheduling_campaign_form").on('submit', function (e) {

            let sendgridStep     = $(".sendgrid_popup_btn ").attr('data-step');
            let sendgridDomainId = $(".sendgrid_popup_btn ").attr('data-domain-id');
            let sendgridSenderId = $(".sendgrid_popup_btn ").attr('data-sender-id');

            let action = 'scheduling_campaign';
            let draft  =  ( $(".scheduling_campaign_form").attr('data-draft_time') ) ? $(".scheduling_campaign_form").attr('data-draft_time') : '';

            if ( $(this).find('#was_draft').length > 0 ) {
                action = 'edit_scheduling_campaign';
                if ( $(this).hasClass('draft_form') ) {
                    draft  = 'fewtime';
                    action = 'edit_draft_campaign';
                }
            }
            else if ( $(this).hasClass('edited_form') ) {
                action = 'edit_scheduling_campaign';
            }
            else if ( $(this).hasClass('draft_form') ) {
                action = 'draft_scheduling_campaign';
            }
            else if (
                ( ( $(this).find("input[name='edited_id1']" ).length > 0 ) && ( $(this).find("input[name='edited_id1']" ).val() ) )
                ||
                ( ( $(this).find("input[name='edited_id2']").length > 0 ) && ( $(this).find("input[name='edited_id2']" ).val() ) )
            ) {
                action = 'edit_scheduling_campaign';
            }

            $(".js-submit-campaign, .js-draft-submit-campaign").prop('disabled', true);
            $(".single-campaign #loader").show();

            e.preventDefault();

            let info = {
                action: action,
                draft: draft,
                data: $(this).serialize()
            };


            // let allowSend = false;
            // if ( ( action == 'scheduling_campaign' ) || ( action == 'edit_scheduling_campaign' ) ) {
            //     allowSend = false;
            //     if (  ( ( parseInt( sendgridStep ) == 4 ) && ( parseInt( sendgridDomainId ) > 0 ) && ( parseInt( sendgridSenderId ) > 0 ) ) ) {
            //         allowSend = true;
            //     }
            //     else {
            //         allowSend = false;
            //     }
            // }
            // else {
            //     allowSend = true;
            // }

            let allowSend = ( ( action == 'scheduling_campaign' ) || ( action == 'edit_scheduling_campaign' ) ) ? ( ( parseInt( sendgridStep ) == 4 ) && ( parseInt( sendgridSenderId ) > 0 ) ) ? true : false : true;

            if ( allowSend ) {
                $.post({
                    url: get.ajaxurl,
                    data: info,
                    success: function (data) {

                        $(".single-campaign #loader").hide();
                        if ($(".scheduling_campaign_form").hasClass('edited_form') && !$(".scheduling_campaign_form").hasClass('draft_form')) {
                            const message = new ActionModalResponse('Campaign has been saved', window.location.reload.bind(window.location));
                            message.show();
                        } else if ($(".scheduling_campaign_form").hasClass('draft_form')) {
                            $(".scheduling_campaign_form").addClass('draft_scheduling_campaign');
                            const message = new ActionModalResponse('Campaign has been saved as draft', window.location.reload.bind(window.location));
                            message.show();
                        } else {

                            $(".scheduling_campaign_form").addClass('edited_form');
                            $(".js-submit-campaign").text('Save');
                            const message = new ActionModalResponse('Campaign has been started', window.location.reload.bind(window.location));
                            message.show();
                        }
                        $(".js-submit-campaign, .js-draft-submit-campaign").prop('disabled', false);

                    },
                    error: function (data) {
                        $(".single-campaign #loader").hide();
                        $(".js-submit-campaign, .js-draft-submit-campaign").prop('disabled', false);
                        console.log('error');
                    },
                });
            }
            else {
                $(".js-submit-campaign").prop('disabled', true);
                $(".single-campaign #loader").hide();

                const message = new ActionModalResponse("<h3>Oops! You can't hit send yet. Please connect your email domain into our system via the Connect Your Email Domain button in your profile settings.</h3>");
                message.show();

            }
        });
    }


    /**
     * Function for exporting campaign edited content data
     *
     */
    function edited_content_export() {

        if ( $('.was_edited_or_draft').length > 0 ) {

            $(".compilance_download_btn").on("click", function ( e ) {

                let action = 'export_edited_campaign_data';
                let campaign_id = $(this).attr('data-campaginid');
                $(".compilance_download_btn").prop('disabled', true);

                e.preventDefault();

                let info = {
                    action: action,
                    campaign_id: campaign_id
                };

                $.post({
                    url: get.ajaxurl,
                    data: info,
                    success: function (data) {
                        $(".compilance_download_btn").prop('disabled', false);

                        // let filename = "edited-content-" + data.name+".pdf";
                        let filename = "Edited-Content.pdf";
                        let $a = $("<a>");
                        $a.attr("href",data.file);
                        $("body").append($a);
                        $a.attr("download",filename);
                        $a[0].click();
                        $a.remove();

                    },
                    error: function (data) {
                        $(".compilance_download_btn").prop('disabled', false);
                        console.log('error');
                    },
                });

            });
        }

    }
    edited_content_export();

    /**
     * Function changing list name after success import (Single Lead Page)
     */
    function editListName() {
        let editButton = $('.js-edit-list');

        if(!editButton.length) return;

        const field = editButton.parent();
        const input = $('<input type="text" class="sv-new-list-name__title">');
        const newName = field.next();
        let value = '';
        const lead_id = $("#new_name").attr('data-id');

        editButton.on('click', function () {
            value = field.text().trim();
            input.val(value);
            editButton = $(this).detach();
            field.replaceWith(input);
            input.select();

            inputListener();
        });

        //save new name on fucus out & enter key
        function inputListener() {
            input.on('focusout', saveNewName);

            input.on('keyup', function (e) {
                if( e.keyCode === 13 ) {
                    saveNewName()
                }
            });
        }

        /**
         * Function saving name for Single Lead Page
         *
         */
        function saveNewName() {
            value = input.val().trim();
            field.text(value);
            newName.val(value);
            field.append(editButton);
            input.replaceWith(field);

            // let lead_id = $("#new_name").attr('data-id');
            /*  Ajax function part */
            let info = {
                action: 'edit_lead_name',
                lead_id: lead_id,
                new_name: value
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    const message = new ActionModalResponse('Lead list name has been changed');

                    message.show();
                },
                error: function (data) {
                    console.log('error');
                },
            });

        }
    }

    /**
     * Function of changing lead list name in single lead page
     *
     */
    function editLeadListName() {

        $("#lead_list_name").on('change', function () {
            let new_name = $(this).val().trim();
            let lead_id  = $(this).parents("form").attr('data-id');

            let info = {
                action: 'edit_lead_name',
                lead_id: lead_id,
                new_name: new_name
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    const message = new ActionModalResponse('Lead list name has been changed');

                    message.show();
                },
                error: function (data) {
                    console.log('error');
                },
            });

        });

    }

    /**
     * Function saving lead changes in lead single page
     */
    function save_lead_changes() {
        const submitButton = $(".save_lead_changes_button");

        /**
         * Edit lead form
         *
         */
        $("form#lead_edit_form").on('submit', function (e) {
            e.preventDefault();

            let count   = $(this).find("tbody tr").length;
            let list_id = $(this).attr('data-id');
            let check   = fieldsControl();

            $("#loader").show();
            var info = {
                data: $(this).serialize(),
                count: count,
                list_id: list_id,
                action: 'edit_lead_info'
            };

            if ( check ) {
                $(".error_txt").html("").hide();
                submitButton.addClass('disabled');

                $.post({
                    url: get.ajaxurl,
                    data: info,
                    success: function (data) {
                        submitButton.removeClass('disabled');
                        const message = new ActionModalResponse('Lead List has been saved', window.location.replace.bind(window.location), window.location.reload() );

                        message.show();
                    },
                    error: function (data) {
                        console.log('error');
                    },
                });
            }
            else {
                $(".error_txt").html("Please fill the inputs.").show();
            }
        });

        /**
         * Lead built form
         *
         */
        $("form#lead_create_form").on('submit', function (e) {
            e.preventDefault();

            let count   = $(this).find("tbody tr").length;
            let check   = fieldsControl();

            $("#loader").show();
            var info = {
                data: $(this).serialize(),
                count: count,
                action: 'build_new_lead'
            };

            if ( check ) {
                $(".error_txt").html("").hide();
                $(".save_create_lead").addClass('disabled');

                let popup = $('#add_lead_popup');

                $.post({
                    url: get.ajaxurl,
                    data: info,
                    success: function (data) {
                        $(".save_create_lead").removeClass('disabled');

                        if ( data.alert_message == true ) {
                            // alert(data.message);
                            if ( popup.length ) {
                                $('body').prepend('<div class=" modal-backdrop show"></div>').addClass('no-scroll');
                                popup.addClass('show').css('display', 'block');
                                popup.find('.top h3').text(data.message_unsubscribe);
                                popup.find('.bottom').html('<p class="mb-30">'+data.list_unsubscribe+'</p><h4 style="margin-bottom: 30px;">Lead list has been created</h4>');
                                function closeUploadFilePopup() {
                                    $('body').removeClass('no-scroll');
                                    $('#add_lead_popup').removeClass('show').css('display', 'none');
                                    $('.add_lead_popup_overlay').remove();
                                    window.location.replace( data.redirect_url );
                                }
                                $(document).on('click', '#add_lead_popup', function (event) {
                                    if(!$(event.target).closest('.exit-popup-wrap').length ){
                                        closeUploadFilePopup();

                                        // const message = new ActionModalResponse('Lead list has been created', window.location.replace.bind(window.location, data.redirect_url));
                                        // message.show();
                                    }
                                });
                            }
                        } else {
                            const message = new ActionModalResponse('Lead list has been created', window.location.replace.bind(window.location, data.redirect_url));

                            message.show();
                        }

                    },
                    error: function (data) {
                        console.log('error');
                    },
                });
            }
            else {
                $(".error_txt").html("Please fill the inputs.").show();
            }
        });

        submitButton.on("click", function ( e ) {
            e.preventDefault();

            if(this.classList.contains('disabled')) return;

            $("form#lead_edit_form").trigger('submit');
        });


        $(".save_create_lead").on("click", function ( e ) {
            e.preventDefault();

            if(this.classList.contains('disabled')) return;

            $("form#lead_create_form").trigger('submit');
        });

        function fieldsControl() {
            let valid = true;

            $("form#lead_edit_form").find('.name_td input, .email_td input' ).each(function( index ) {
                const _this = $(this);

                if ( _this.val() === '' || (_this.attr('type') === 'email' && !validateEmail(_this.val())) ) {
                    $(this).css("border-bottom", "1px solid red");
                    valid = false;
                } else {
                    $(this).css("border-bottom", 'none');
                }
            });

            return valid;
        }

    }

    /**
     * Function check if email is valid
     *
     */
    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    /**
     * Function Filtering statistic by date
     *
     *
     */
    function filtering_statistic_by_date() {
        $("select.time_sorting").on("change", function () {
            let val = $(this).val();
            let text = $(this).find("option:selected").text();

            var single = 0;
            if ( $(this).hasClass( 'single' ) ) {
                single = $(this).attr('data-campaign-id');
            }
            let info = {
                action: 'filtering_statistic_by_date',
                val: val,
                single : single
            };

            $(".sv-progress-bar span.time_period").text(text);
            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {

                    if ( data ) {

                        let unsubscribers_count = ( data.response.unsubscribers_count ) ? data.response.unsubscribers_count : 0;
                        let unsubscribers_rate = ( data.response.unsubscribers_percent ) ? data.response.unsubscribers_percent : 0;

                        $(".count_contacts").find("span.count").find(".sent_emails").text( data.response.count_sentstatus_emails );
                        $(".number_contacts_sent").find("span.count").text( data.response.count_all_receivers );
                        $(".sent_delivered").find("span.count").find(".sent_emails").text( data.response.count_sent );

                        $(".sv-progress-bar.sent")
                            .find(".sv-progress-bar__chart.js-chart")
                            .find("span.count")
                            .text( data.response.sent + "%");
                        if( $('.single-campaign').length ) {
                            updatePercentage(1, data.response.sent);
                        } else {
                            updatePercentage(0, data.response.sent);
                        }
                        $(".sv-progress-bar.opened")
                            .find(".sv-progress-bar__chart.js-chart")
                            .find("span.count")
                            .text( data.response.opened + "%");
                        if ( $('.single-campaign' ).length ) {
                            updatePercentage(2, data.response.opened);
                        } else {
                            updatePercentage(1, data.response.opened);
                        }
                        $(".sv-progress-bar.opened")
                            .find(".add_count")
                            .find(".emails")
                            .text( data.response.count_opened);

                        $(".sv-progress-bar.clicked")
                            .find(".sv-progress-bar__chart.js-chart")
                            .find("span.count")
                            .text( data.response.clicked + "%");
                        if ( $('.single-campaign').length ) {
                            updatePercentage(3,data.response.clicked );
                        } else {
                            updatePercentage(2,data.response.clicked);
                        }
                        $(".sv-progress-bar.clicked")
                            .find(".add_count")
                            .find(".emails")
                            .text( data.response.count_clicked);

                        $(".sv-progress-bar.unsubscriber_rate")
                            .find(".sv-progress-bar__chart.js-chart")
                            .find("span.count")
                            .text( unsubscribers_rate + "%");
                        if ( $('.single-campaign').length ) {
                            updatePercentage(4, unsubscribers_rate);
                        } else {
                            updatePercentage(3, unsubscribers_rate);
                        }

                        $(".sv-progress-bar.unsubscribers_count")
                            .find("span.count .emails")
                            .text( unsubscribers_count );

                    }
                },
                error: function (data) {
                    console.log('error');
                },
            });

        })
    }

    /**
     * Function of filtering articles
     *
     */
    function filtering_function() {

        /**
         * Form submitting
         */
        $("form.sv-filter__form").on('submit', function (e) {
            e.preventDefault();

            let page = 1;
            let info = {
                'total_count': 0,
                'page':        page,
                data: $(this).serialize(),
                action: 'filtering_articles'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (response) {
                    console.log( 'response', response );
                    $(".body-items").html('');
                    if ( response ) {
                        $(".body-items").append(response.html).hide().fadeIn('slow');
                        page++;
                        $('.body-items').attr('data-all', response.all );
                        $('.body-items').attr('data-page', 2 );

                        $('.body-items').attr('data-getcat',  response.article_cat );
                        $('.body-items').attr('data-gettype', response.article_type );
                        $('.body-items').attr('data-getsort', response.article_sort );

                        $("span.count-articles").text(response.all);
                        if ( response.total >= response.all ) {
                            $("#load_more_button_filtering").hide();
                        }
                        else {
                            $("#load_more_button_filtering").show();
                        }
                    }
                    else {
                        $("#load_more_button_filtering").hide();
                    }
                },
                error: function (data) {
                    console.log( 'error' );
                    console.log( 'data', data );
                },
            });

        });

        /**
         * Changing selects function
         *
         */
        let sv_filter_sort  = ( $(".page-admin-content #sv-filter-sort").length > 0 ) ? $("#sv-filter-sort").val() : 'all';
        let sv_filter_topic = ( $(".page-admin-content #sv-filter-topic").length > 0 ) ? $("#sv-filter-topic").val() : 'all';
        let sv_filter_original_edited = ( $(".page-admin-content #sv-filter-original-edited").length > 0 ) ? $("#sv-filter-original-edited").val() : 'all';

        $("#sv-filter-topic, #sv-filter-type, #sv-filter-sort, #sv-filter-original-edited").on( "change", function (e) {
            e.preventDefault();
            $(".loader_block #loader").show();

            let name_select = $(this).attr('name');
            let get_cat     = ( name_select == 'topic' ) ? $(this).val() : $('.body-items').attr('data-getcat');
            let art_sort    = ( name_select == 'sort' )  ? $(this).val() : $('.body-items').attr('data-getsort');
            let art_original_edited = ( name_select == 'filter_edited_original' ) ? $(this).val() : $('.body-items').attr('data-get_article_type');
            // let art_type    = ( name_select == 'type' )  ? $(this).val() : $('.body-items').attr('data-gettype');
            let art_type    = 'all';

            articles_ajax_function( get_cat, art_type, art_sort, art_original_edited );
        });

        if ( ( ( sv_filter_sort != 'all' ) || ( sv_filter_topic != 'all' ) || ( sv_filter_original_edited != 'all' ) ) && ( ( $(".page-admin-content #sv-filter-topic").length > 0 ) || ( $(".page-admin-content #sv-filter-sort").length > 0 ) || ( $(".page-admin-content #sv-filter-original-edited").length > 0 ) ) ) {
            //let art_type    = $('.body-items').attr('data-gettype');
            let art_type    = 'all';
            articles_ajax_function( sv_filter_topic, art_type, sv_filter_sort, sv_filter_original_edited );
        }

        /**
         * Common function for filtering
         *
         * @param get_cat
         * @param art_type
         * @param art_sort
         * @param art_original_edited
         */
        function articles_ajax_function( get_cat, art_type, art_sort, art_original_edited ) {

            let page        = 1;
            let cpt_type    = $('.body-items').attr('data-cpt');

            let info        = {
                'action':     'filtering_articles',
                'total_count': 0,
                'page':        page,
                'cpt_type':    cpt_type,
                'topic':       get_cat,
                'type':        art_type,
                'original_edited': art_original_edited,
                'sort':        art_sort,
                'js_type':     'load_more',
            };

            $.ajax({
                url: get.ajaxurl,
                type: "POST",
                data: info,
                success:function(response) {

                    $('.body-items').attr('data-getcat',  get_cat );
                    $('.body-items').attr('data-gettype', art_type );
                    $('.body-items').attr('data-getsort', art_sort );
                    $('.body-items').attr('data-get_article_type', art_original_edited );

                    if ( response ) {
                        $(".body-items").html('');
                        $(".body-items").append(response.html).hide().fadeIn('slow');
                        $('.body-items').attr('data-all', response.all );
                        $('.body-items').attr('data-page', 2 );

                        $('.body-items').attr('data-getcat',  response.article_cat );
                        $('.body-items').attr('data-gettype', response.article_type );
                        $('.body-items').attr('data-getsort', response.article_sort );
                        $('.body-items').attr('data-get_article_type', art_original_edited );

                        // $("span.count-articles").text(response.all);

                        $(".loader_block #loader").hide();
                        if ( response.total >= response.all ) {
                            $("#load_more_button_filtering").hide();
                        }
                        else {
                            $("#load_more_button_filtering").show();
                        }
                    }
                    else {
                        $(".body-items").html('');
                        $("#load_more_button_filtering").hide();
                        $(".loader_block #loader").hide();
                    }
                }
            });
        }

        /**
         * Load more function - for articles page
         *
         */
        $("#load_more_button_filtering").on( "click", function (e) {
            e.preventDefault();

            $("#load_more_button_filtering #loader_more").show();

            $(this).addClass('disabled_hrefs');
            let total_count = $('.body-items').attr('data-all');
            let page        = $('.body-items').attr('data-page');
            page            = ( page > 1 ) ?  page : 2

            let cpt_type    = $('.body-items').attr('data-cpt');
            let get_cat     = $('.body-items').attr('data-getcat');
            let art_sort    = $('.body-items').attr('data-getsort');
            let art_type    = $('.body-items').attr('data-gettype');
            let get_artice_type = $('.body-items').attr('data-get_article_type');

            let info = {
                'action':     'filtering_articles',
                'total_count': total_count,
                'page':        page,
                'cpt_type':    cpt_type,
                'topic':       get_cat,
                'type':        art_type,
                'original_edited': get_artice_type,
                'sort':        art_sort,
                'js_type':     'load_more',
            };

            $.ajax({
                url: get.ajaxurl,
                type: "POST",
                data: info,
                success:function(response) {
                    $("#load_more_button_filtering #loader_more").hide();
                    if ( response ) {
                        $(".body-items").append(response.html).hide().fadeIn('slow');
                        page++;
                        $('.body-items').attr('data-all', response.all );
                        $('.body-items').attr('data-page', page );

                        $('.body-items').attr('data-getcat',  response.article_cat );
                        $('.body-items').attr('data-gettype', response.article_type );
                        $('.body-items').attr('data-getsort', response.article_sort );
                        $('.body-items').attr('data-get_article_type', get_artice_type );

                        // $("span.count-articles").text(response.all);

                        if ( response.total >= response.all ) {
                            $("#load_more_button_filtering").hide();
                        }
                        else {
                            $("#load_more_button_filtering").show();
                        }
                    }
                    else {
                        $("#load_more_button_filtering #loader_more").hide();
                        $("#load_more_button_filtering").hide();
                    }
                    $("#load_more_button_filtering").removeClass('disabled_hrefs');
                }
            });
        });

    }

    /**
     * Function of video player for single course page
     *
     */
    function video_player() {

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

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    if ( data.done == 1) {
                        location.reload();
                    }
                },
                error: function (data) {
                    console.log('error');
                },
            });

        });
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

    /**
     * Function for footer color
     *
     */
    function adminDashboardFooterColor() {
        const url = window.location.href;

        if(~url.indexOf('admin-dashboard') || ~url.indexOf('admin-content') || ~url.indexOf('admin-training')) {
            const footer = document.querySelector('.footer');

            if(footer) {
                footer.style.backgroundColor = '#f5f8fa';
            }
        }
    }

    /**
     *
     */
    function campaignsFieldsEqualHeight() {
        const tableRows = document.querySelectorAll('.js-equal-subject-body tr');

        if(!tableRows.length) return;

        for(let row of tableRows) {
            const subject = row.querySelector('.sv-email-campaign__subject div');
            const body = row.querySelector('.sv-email-campaign__body div');
            const date = row.querySelector('.sv-email-campaign__date div');

            if(!subject || !body || !date) continue;

            subject.style.height = null;
            body.style.height = null;
            date.style.height = null;

            if(window.innerWidth < 992) {
                continue;
            }

            const subjectHeight = subject.getBoundingClientRect().height;
            const bodyHeight = body.getBoundingClientRect().height;
            const dateHeight = date.getBoundingClientRect().height;

            const maxHeight = Math.max(subjectHeight, bodyHeight, dateHeight);

            subject.style.height = body.style.height = date.style.height = maxHeight + 'px';
        }
    }

    /**
     * Preview Email Popup
     *
     */
    function viewEmail() {

        $('.js-view-email').on('click', function (e) {
            const email = new Popup($(this));
            email.show();
        });

        function Popup(target) {
            const _this = this;
            const disclosure = target.parents('.sv-email-campaign').find('.email_disclosure_content').text();
            let emailCopy = target.attr('data-edited-content');
            emailCopy     = !emailCopy ? target.attr('data-copy') : emailCopy;
            const customLink = target.parents('tr').find('.custom_link_input').val() || '';
            const customSubject = target.parents('tr').find('.sv-email-campaign__subject div').text() || target.data('title');
            const customToken = target.parents('tr').find('.custom_personal_token_input').val() || '';
            const customArticleChkbx= target.parents('tr').find('.custom_article_token_input').val() || '';
            const tagRegularExpression = /\[custom_link](.*?)\[\/custom_link]/g;
            let matches;

            while ((matches = tagRegularExpression.exec(emailCopy)) !== null) {

                emailCopy = emailCopy.replace(matches[0], customLink ?
                    `<a style="background-color:#789;color:#fff;min-width:120px;text-decoration:none;font-weight:500;text-align:center;letter-spacing:.2px;display:inline-block;border-radius:17px;padding:6px 10px;"
                        target="_blank"
                        href="${customLink}"
                    >${matches[1]}</a>`
                    : '');
            }


            this.documentBody = $('body');
            this.template = $('<div class="sv-email-popup"></div>');

            this.templateHeader = $('<div class="sv-email-popup__header"><h5>Email View</h5></div>');
            this.closeButton = $('<span class="sv-email-popup__close"></span>');

            this.templateHeader.append(this.closeButton);

            this.templateBody = $('<div class="sv-email-popup__body"></div>');
            this.title = $(`<h5>${customSubject}</h5>`);
            this.copy = $(`<div class="sv-email-popup__copy"><div class="hello_user_block"><p>Hi @user, </p></br></div>${emailCopy}</div>`);
            customToken === "" ? this.copy.find('.hello_user_block').addClass('d-none') : this.copy.find('.hello_user_block').removeClass('d-none') ;
            this.copy.find('p').filter(function() {return this.innerHTML == '' || this.innerHTML == ' ' || this.innerHTML == '&nbsp;'}).remove();

            this.userWrapper  = $('<div class="sv-email-popup__user"></div>');
            this.userAvatar   = $(`<img src="${target.data('userimg') || './dist/img/avatar.png'}">`);
            this.userInfo     = $('<div class="sv-email-popup__user-info"></div>');
            this.userFullName = $(`<p><b>${target.data('fullname')}</b></p>`);
            this.userCompany  = $(`<p><b>${target.data('company')}</b></p>`);
            this.userMail     = $(`<p>${target.data('email')}</p>`);
            this.userPhone    = $(`<p>${target.data('phone')}</p>`);
            this.userWebsite  = $(`<p>${target.data('website')}</p>`);
            this.userAddress  = $(`<p>${target.data('address')}</p>`);
            this.userPosition = $(`<p>${target.data('position')}</p>`);

            this.userInfo.append(this.userFullName);
            this.userInfo.append(this.userCompany);
            this.userInfo.append(this.userPosition);
            this.userInfo.append(this.userMail);
            this.userInfo.append(this.userPhone);
            this.userInfo.append(this.userWebsite);
            this.userInfo.append(this.userAddress);

            this.userWrapper.append(this.userAvatar);
            this.userWrapper.append(this.userInfo);

            this.copy.append(this.userWrapper);

            if(disclosure) {
                this.copy.append(`<div class="email_disclosure_content">${disclosure}</div>`);
            }

            this.overlay = $('<div class="overlay"></div>');

            this.templateBody.append(this.title);
            this.templateBody.append(this.copy);

            this.template.append(this.templateHeader);
            this.template.append(this.templateBody);

            this.show();
            this.overlay.on('click', function () {
                _this.hide();
            });

            this.closeButton.on('click', function () {
                _this.hide();
            });
        }

        Popup.prototype.show = function () {
            this.overlay.prependTo(this.documentBody);
            this.template.prependTo(this.documentBody);
            this.template.fadeIn();
            this.overlay.fadeIn();
            this.documentBody.addClass('no-scroll');
        };

        Popup.prototype.hide = function () {
            this.overlay.fadeOut(400, function () {
                $(this).remove();
            });
            this.template.fadeOut(400, function () {
                $(this).remove();
            });
            this.documentBody.removeClass('no-scroll');
        };
    }

    //function check if all enabled emails are scheduled
    //and control submit button state - disabled

    /**
     *
     */
    function emailCampaignSubmitControl() {
        const isCampaignPage = !!$('.js-campaign-table').length;
        const submitButton = $('.js-submit-campaign');

        if (!isCampaignPage) return;

        changeButtonState();

        //on switcher change and on time submit checks is the form is valid
        document.addEventListener('timeSubmitted', changeButtonState);
        document.addEventListener('cancelEmail', changeButtonState);
        document.addEventListener('saveLink', changeButtonState);

        //check do checked emails have selected date
        function isValid() {
            let valid = true;

            const buttons = $('.js-campaign-button:not(:disabled)');
            const customLinks = $('.js-custom-link:not(.disabled)')

            if(!buttons.length) {
                valid = false;
            }

            buttons.each(function () {
                if(!$(this).hasClass('selected')) {
                    valid = false;

                    return false;
                }
            });

            customLinks.each(function () {
                if($(this).attr('data-status') === ''){
                    if(!$(this).closest('tr').find('.custom_link_input').val()) {
                        valid = false;

                        return false;
                    }
                }
            });

            return valid;
        }

        //change button state to active when the form is valid and to disabled if it is not
        function changeButtonState() {
            if(isValid()) {
                submitButton.prop('disabled', false);
                submitButton.removeClass('disabled');
            } else {
                submitButton.prop('disabled', true);
                submitButton.addClass('disabled');
            }
        }
    }

    /**
     * Function add tabs functionality for tables
     */

    /**
     *
     */
    function tableTabs() {
        const switchButtons = $('.js-table-tabs');
        const tabs = $('.js-table-tab');

        if(!switchButtons.length || !tabs.length) return;

        switchButtons.on('click', function () {
            const _this = $(this);

            switchButtons.removeClass('active');
            _this.addClass('active');

            tableSearch(true);

            tabs.css('display', 'none');
            tabs.removeClass('active');
            tabs.eq(_this.data('tab')).css('display', 'table');
            tabs.eq(_this.data('tab')).addClass('active');

            triggerEvent('resize');

            sortTable();
        });
    }

    /**
     * Search in table on Campaigns pages
     */

    function tableSearch(isReset) {

        const searchInput = $('.js-table-search');

        if(!searchInput.length) return;

        if(isReset) {
            $('.js-table-tab tr').css('display', 'table-row');
            searchInput.val('');
        }

        searchInput.on('input change', function (e) {
            search($(this).val());
        });

        function search(val) {

            const tableTr = $('.js-table-tab.active tbody tr');
            tableTr.css('display', 'table-row');

            if(!val) return;

            tableTr.filter(function () {
                const data = getInputsData($(this));

                if(data.isEmpty) {
                    return !$(this).text().toLowerCase().includes(val.toLowerCase());
                }

                return !$(this).text().toLowerCase().includes(val.toLowerCase()) && !data.search.includes(val.toLowerCase());
            }).css('display', 'none');
        }

        function getInputsData(tr) {
            const inputs = tr.find('input:not([type="hidden"]):not([type="checkbox"])');
            const data = {
                search: '',
                isEmpty: false
            };

            if(!inputs.length) {
                data.isEmpty = true;
                return data;
            }

            inputs.each(function () {
                data.search += ' ' + $(this).val().toLowerCase();
            });

            return data;
        }
    }

    /**
     * Sort table control function
     * Makes visual changes in table during sorting and calls a main sort function
     */
    function sortTable() {
        const buttons = $('.js-table-tab.active .js-sort-button');
        const table = $('.js-table-tab.active tbody');

        buttons.off().on('click', function () {
            const _this = $(this);
            const order = _this.data('order');
            const type = _this.data('type');
            const position = _this.data('td');

            buttons.removeClass('top');
            buttons.removeClass('bottom');
            buttons.data('order', 'asc');

            _this.data('order', order);

            if(order === 'asc') {
                _this.removeClass('top');
                _this.addClass('bottom');
                _this.data('order', 'desc');
            } else {
                _this.removeClass('bottom');
                _this.addClass('top');
                _this.data('order', 'asc');
            }

            sort(table, type, order, position);
        });

        /**
         * Main sort function, sorts table by column value (string, number, date)
         */

        function sort(table, type, order, position) {
            const asc = order === 'asc';

            table.find('tr').sort(function (a, b) {
                let _a, _b;

                if(type === 'input-string') {
                    if(asc) {
                        _a = $(a).find('.sv-filter-table__td').eq(position).find('input').val();
                        _b = $(b).find('.sv-filter-table__td').eq(position).find('input').val();
                    } else {
                        _a = $(b).find('.sv-filter-table__td').eq(position).find('input').val();
                        _b = $(a).find('.sv-filter-table__td').eq(position).find('input').val();
                    }
                }else if(type === 'tag') {
                    if(asc) {
                        _a = $(a).find('.sv-filter-table__td').eq(5).find('span').text();
                        _b = $(b).find('.sv-filter-table__td').eq(5).find('span').text();
                    } else {
                        _a = $(b).find('.sv-filter-table__td').eq(5).find('span').text();
                        _b = $(a).find('.sv-filter-table__td').eq(5).find('span').text();
                    }
                } else {
                    if(asc) {
                        _a = $(a).find('.sv-filter-table__td').eq(position).text();
                        _b = $(b).find('.sv-filter-table__td').eq(position).text();
                    } else {
                        _a = $(b).find('.sv-filter-table__td').eq(position).text();
                        _b = $(a).find('.sv-filter-table__td').eq(position).text();
                    }
                }

                if(type === 'number') {
                    return +_a - +_b;
                }

                if(type === 'date') {
                    return Date.parse(_a) - Date.parse(_b);
                }

                if(_a > _b) {
                    return 1;
                } else if(_b > _a) {
                    return -1;
                }

                return 0;

            }).appendTo(table);
        }
    }

    /**
     * Function uploads a xls file by drag and drop and file select button
     */

    function fileUpload() {
        const dropArea = document.querySelector('.js-drop-area');

        if(!dropArea) return;

        const input = dropArea.querySelector('input[type="file"]');
        const description = dropArea.querySelector('.sv-upload__description');
        const message = dropArea.querySelector('.message');
        const uploadButton = dropArea.querySelector('.sv-button');
        const progressBar = dropArea.querySelector('.js-progress');

        const loader = document.createElement('div');
        loader.className = 'sv-spiner';

        //upload file via input button
        input.addEventListener('change', function (e) {
            if(e.target.files.length) {
                handleFiles(e.target.files);
            }
        });

        //prevent default drag&drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(function (eventName) {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        //make drop zone active
        ['dragenter', 'dragover'].forEach(function(eventName) {
            dropArea.addEventListener(eventName, highlight, false);
        });

        //make drop zone no active
        ['dragleave', 'drop'].forEach(function(eventName) {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropArea.classList.add('highlight')
        }

        function unhighlight() {
            dropArea.classList.remove('highlight');
        }

        dropArea.addEventListener('drop', handleDrop, false);

        //handle file dropped by user
        function handleDrop(e) {
            let dt = e.dataTransfer;
            let files = dt.files;

            handleFiles(files);
        }

        //check file extension, show progress spiner and trigger file upload
        function handleFiles(files) {
            const extension = files[0].name.split('.').slice(-1).join('');

            if(files.length > 1 || (extension !== 'xls' && extension !== 'xlsx')) return;

            showProgress();
            uploadFile(files[0]);
        }

        /**
         * Function of uploading excel importing file for user lists
         *
         * @param file
         */
        function uploadFile(file) {
            let formData = new FormData();
            formData.append('file', file);
            formData.append('action', 'import_user_list');
            let popup = $('#add_lead_popup');
            $.post({
                url: get.ajaxurl,
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log('success');
                    console.log(data);

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
                error: function (data) {
                    console.log('error');
                },
            });

        }

        //show progress line and make visual changes
        function showProgress() {
            uploadButton.classList.add('disabled');

            description.innerHTML = 'Uploading';

            progressBar.append(loader);

            progressBar.style.display = 'block';

            message.innerHTML = 'please wait';
            message.classList.add('uploading');

        }
    }

    /**
     * Function shows a popup with video on click
     */
    function watchVideoPopup() {
        const watchButton = $('.js-watch-guide');
        const body = $('body');

        if(!watchButton.length) return;

        popup();

        function popup() {
            const videoId = watchButton.data('id');
            const iframe = $(`<iframe src="https://player.vimeo.com/video/${videoId}?autoplay=1" frameborder="0" allow="autoplay; fullscreen"></iframe>`);
            const template = $('<div class="sv-contact-popup"></div>');
            const videoContainer = $('<div class="sv-video-container"></div>');
            const closeButton = $('<div class="close-popup">x</div>');
            const preloader = $(`<div class="iframe-preloader">
                                    <div class="preloader__row">
                                        <div class="preloader__item"></div>
                                        <div class="preloader__item"></div>
                                    </div>
                                </div>`);
            const overlay = $('<div class="overlay"></div>');

            videoContainer.append(iframe);

            template.append(videoContainer);
            template.append(closeButton);
            template.append(preloader);

            watchButton.on('click', function (e) {
                e.preventDefault();

                show();
            });

            overlay.on('click', function () {
                close();
            });

            closeButton.on('click', function () {
                close();
            });

            iframe.on('load', function() {
                preloader.fadeOut();
            });

            function show() {

                body.prepend(template);
                body.prepend(overlay);
                body.addClass('no-scroll');

                template.fadeIn();
                overlay.fadeIn();
            }

            function close() {
                body.removeClass('no-scroll');
                template.fadeOut(400, function () {
                    $(this).detach();
                });
                overlay.fadeOut(400, function () {
                    $(this).detach();
                });
            }
        }
    }

    /**
     * Cancel campaign on click
     */
    function cancelCampaign() {
        const table = $('.js-campaign-table');
        const buttons = $('.js-cancel-email');
        const cancelEmail = new CustomEvent('cancelEmail');

        if(!table.length) return;

        buttons.on('click', confirmCancel);

        //show confirmation popup
        function confirmCancel() {
            const _this = $(this);
            const alert = new Popup(_this.data('id'));

            alert.show();

            //confirm campaign cancel
            alert.successButton.on('click', function () {
                alert.hide();

                let id = $(this).data('id');
                let info = {
                    action: 'cancel_email',
                    id: id,
                };

                $.post({
                    url: get.ajaxurl,
                    data: info,
                    success: function (data) {
                        // window.alert('success');
                    },
                    error: function (data) {
                        console.log('error');
                    },
                });

                disableRow(_this);

            });
        }

        //make row no active
        function disableRow(button) {
            const tr = button.closest('tr');
            const scheduleButton = tr.find('.sv-email-campaign__schedule-button button');
            const sendingDate = tr.find('.sv-email-campaign__date');
            const customLinkButton = tr.find('.js-custom-link');

            tr.addClass('canceled');
            scheduleButton.removeClass('selected');
            scheduleButton.text('Schedule');
            scheduleButton.prop('disabled', true);
            sendingDate.find('div').text('Canceled');
            sendingDate.find('.js-sending-date-edit').hide();
            sendingDate.find('.js-sending-date').val('canceled');
            customLinkButton.addClass('disabled');


            document.dispatchEvent(cancelEmail);
        }

        //confirmation popup
        function Popup(id) {
            const _this = this;
            this.documentBody = $('body');
            this.overlay = $('<div class="overlay"></div>');
            this.popup = $('<div class="sv-confirmation-popup"></div>');
            this.message = $('<p class="sv-confirmation-popup__message">Are you sure you want to cancel the email? You won’t be able to schedule it anymore.</p>');
            this.buttonsWrapper = $('<div class="sv-confirmation-popup__buttons"></div>');
            this.cancelButton = $('<button type="button" class="sv-button sv-button--red">No</button>');
            this.successButton = $(`<button type="button" class="sv-button sv-button--green" data-id="${id}">Yes</button>`);

            this.buttonsWrapper.append(this.successButton);
            this.buttonsWrapper.append(this.cancelButton);

            this.popup.append(this.message);
            this.popup.append(this.buttonsWrapper);

            this.cancelButton.on('click', function () {
                _this.hide();
            });

            this.overlay.on('click', function () {
                _this.hide();
            });
        }

        Popup.prototype.show = function () {
            this.documentBody.prepend(this.overlay);
            this.documentBody.prepend(this.popup);
            this.documentBody.addClass('no-scroll');

            this.overlay.fadeIn();
            this.popup.fadeIn();
        };

        Popup.prototype.hide = function () {
            this.overlay.fadeOut(400, function() {
                $(this).remove();
            });
            this.popup.fadeOut(400, function() {
                $(this).remove();
            });

            this.documentBody.removeClass('no-scroll');
        };
    }

    /**
     * Turn On campaign on click
     */
    function turnOnCampaign() {
        const table = $('.js-campaign-table');
        const buttons = $('.js-turnon-email');

        if(!table.length) return;

        buttons.on('click', function() {
            const tr = $(this).closest('tr');
            const scheduleButton = tr.find('.sv-email-campaign__schedule-button button');
            const sendingDate = tr.find('.sv-email-campaign__date');
            const scheduleDate = tr.find('.js-campaign-button');
            const customLinkButton = tr.find('.js-custom-link');

            tr.removeClass('canceled').addClass('turnedon').attr('data-scheduling-email-status', '');
            $(this).prop('disabled', 'disabled');
            scheduleButton.removeClass('selected').removeClass('disabled');
            scheduleButton.text('Schedule');
            scheduleButton.prop('disabled', false);
            scheduleDate.prop('disabled', false);
            sendingDate.find('div').text('Not scheduled yet');
            sendingDate.find('.js-sending-date-edit').show();
            sendingDate.find('.js-sending-date').val('');
            customLinkButton.removeClass('disabled');

        })
    }

    /**
     * Function add 'edited_form' class to form when scheduled campaign has changed date
     *
     */
    function editScheduledEmail() {
        const editButtons = $('.js-sending-date-edit');

        editButtons.on('click', function () {

            const parentTr = $(this).closest('tr');
            const counter = $(this).closest('tr').data('counter');

            if (
                ( parentTr.data('scheduling-email-status') === 'inprogress' )
                ||
                ( parentTr.data('scheduling-email-status') === 'draft' )
            ) {
                parentTr.find('input[name="type'+counter+'"]').val('edit');
                $(this).closest('form').addClass('edited_form');
            }
        });

    }


    /**
     *
     */
    function addCustomLinkToMail() {
        const addButton = $('.js-custom-link');
        const saveLink = new CustomEvent('saveLink');

        addButton.on('click', function() {
            const input = $(this).parents('tr').find('.custom_link_input');
            const inputSubject = $(this).parents('tr').find('.email_subject_input');
            const inputCopy = $(this).parents('tr').find('.custom_edited_content');
            const articleTitle = $(this).parents('tr').attr('data-article_title');
            const articleId = $(this).parents('tr').attr('data-articleid');
            const articleLink = $(this).parents('tr').attr('data-article_link');

            const userId = $(this).parents('tr').attr('data-user');
            const sharedPost = $(this).parents('tr').attr('data-shared-post');

            const inputT = $(this).parents('tr').find('.custom_personal_token_input');
            const inputAC = $(this).parents('tr').find('.custom_article_token_input');
            const classLink = $(this).attr('data-status')  === 'disabled' ? 'd-none' : '';
            const valueSubject = $(this).parents('tr').find('.sv-email-campaign__subject div');
            const valueSubjectWrap = $(this).parents('tr').find('.sv-email-campaign__subject');
            const popup = new AddCustomLinkPopup(htmlEntities(input.val()),  htmlEntities(inputT.val()), htmlEntities(inputAC.val()), classLink, articleTitle, articleId, articleLink, userId, sharedPost, htmlEntities(valueSubject.text()) );

            popup.show();
            AddCustomLinkPopupCheckbox();
            AddCustomLinkPopupCheckboxArticle();

            popup.saveButton.on('click', function () {
                const parentTr = input.closest('tr');
                const counter  = input.closest('tr').data('counter');

                input.val(htmlEntities(popup.linkInput.val()));
                inputSubject.val(htmlEntities(popup.subjectInput.val()));

                inputT.val(htmlEntities(popup.linkToken.val()));
                inputAC.val(htmlEntities(popup.articleLinkCheckbox.val()));
                valueSubject.text(htmlEntities(popup.subjectInput.val()));
                valueSubjectWrap.attr('data-subject-edited', htmlEntities(popup.subjectInput.val()));

                if( parentTr.data('scheduling-email-status') === 'inprogress' ) {
                    parentTr.find('input[name="type'+counter+'"]').val('edit');
                    input.closest('form').addClass('edited_form');
                }

                document.dispatchEvent(saveLink);
                let copy = $(this).closest('.sv-link-popup').find('#editor').html();
                input.closest('tr').find('.sv-email-campaign__view-button').find('.js-view-email').attr('data-edited-content', copy);
                inputCopy.val(copy);

                $('.overlay').remove();

                popup.hide();
            });
        });

        function AddCustomLinkPopup(value,  valueT,valueAC,  classLink, articleTitle, articleId, articleLink, userId, sharedPost, valueSubject = '' ) {
            let checkbox_class = ( articleId > 0 ) ? "" : "disabled";

            this.template = $(`<div id="editparent" class="sv-link-popup">
                               <div class="sv-link-popup__header">
                                  <h5>Enable first name tag</h5>
                                  <span class="sv-link-popup__close">
                                    <i class="fa fa-times"></i>
                                  </span>
                               </div>
                               <div class="sv-link-popup__body">
                                  <input id="switch" type="checkbox" ${htmlEntities(valueT)}  value="${htmlEntities(valueT)}" class="sv-link-popup__personal-token">
                                  <label for="switch"></label>
                              </div>
                              <div class="sv-link-popup__header ${htmlEntities(classLink)}">
                                  <h5>Add Seven Group branded article link to this email</h5>
                               </div>
                               <div class="sv-link-popup__body sv-link-popup__checkbox-flex ${htmlEntities(classLink)} ">
                                  <p class="sv-link-popup__checkbox-wrap">
                                      <input id="checkbox" type="checkbox" ${htmlEntities(valueAC)}  value="${htmlEntities(valueAC)}" data-id="${articleId}"
                                      data-user="${userId}" data-shared-post="${sharedPost}"
                                      data-shared-link="${articleLink}"
                                      class="sv-link-popup__custom-checkbox campaign_custom_link_btn" ${checkbox_class}>
                                      <label for="checkbox"></label>
                                  </p>
                                  <p class="sv-link-popup__text-after-checkbox-wrap">${articleTitle}</p>
                              </div>
                               <div class="sv-link-popup__header ${htmlEntities(classLink)}">
                                  <h5>Add your own custom link</h5>
                               </div>
                               <div class="sv-link-popup__body ${htmlEntities(classLink)}">
                                  <input type="text" class="custom_link_input link-input" placeholder="Link" value="${htmlEntities(value)}">
                               </div>
                               <div class="sv-link-popup__header ">
                                  <h5>Edit the subject line</h5>
                               </div>
                               <div class="sv-link-popup__body">
                                  <input type="text" class="custom_subject_input subject-input" placeholder="Subject" value="${htmlEntities(valueSubject)}">
                               </div>
                               <div class="sv-link-popup__body">
                                    <div id="editControls">
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-default" data-role="undo" href="#" title="Undo"><i class="fa fa-undo"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="redo" href="#" title="Redo"><i class="fa fa-repeat"></i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-default" data-role="bold" href="#" title="Bold"><i class="fa fa-bold"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="italic" href="#" title="Italic"><i class="fa fa-italic"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="underline" href="#" title="Underline"><i class="fa fa-underline"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="strikeThrough" href="#" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-default" data-role="insertUnorderedList" href="#" title="Unordered List"><i class="fa fa-list-ul"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="insertOrderedList" href="#" title="Ordered List"><i class="fa fa-list-ol"></i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn  btn-xs btn-default" data-role="justifyleft" href="#" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                            <a class="btn  btn-xs btn-default" data-role="justifycenter" href="#" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="justifyright" href="#" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-default" data-role="h1" href="#" title="Heading 1"><i class="fa fa-header"></i><sup>1</sup></a>
                                            <a class="btn btn-xs btn-default" data-role="h2" href="#" title="Heading 2"><i class="fa fa-header"></i><sup>2</sup></a>
                                            <a class="btn btn-xs btn-default" data-role="h3" href="#" title="Heading 3"><i class="fa fa-header"></i><sup>3</sup></a>
                                            <a class="btn btn-xs btn-default" data-role="p" href="#" title="Paragraph"><i class="fa fa-paragraph"></i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-default" data-command="createlink" href="#" title="Link"><i class="fa fa-link"></i></a>
                                            <a class="btn btn-xs btn-default" data-command="unlink" href="#" title="Link"><i class="fa fa-unlink"></i></a>
                                            <a class="btn btn-xs btn-default" data-command="unstyle" href="#" title="Remove Style"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-xs btn-default" data-command="img" href="#" title="Image Link"><i class="fa fa-image"></i></a>
                                            <a class="btn btn-xs btn-default" data-command="img-url" href="#" title="Image Upload"><i class="fa fa-file-image-o"></i></a>
                                        </div>
                                    </div>
                                    <div id="editor" contenteditable></div>
                                </div>
                                <p  class="message ${htmlEntities(classLink)}">Please do not delete [custom_link]Read More [/custom_link] shortcode. Feel free to edit the text inside it to rename the call-to-action button.</p>
                               <div class="sv-link-popup__body">
                                  <button type="button" class="sv-button sv-button--green ">Save</button>
                               </div>
                            </div>`);

            this.documentBody = $('body');
            this.linkInput = this.template.find('input.custom_link_input');
            this.linkToken = this.template.find('input.sv-link-popup__personal-token');
            this.articleLinkCheckbox = this.template.find('input.campaign_custom_link_btn');
            this.subjectInput = this.template.find('input.custom_subject_input');
            this.saveButton = this.template.find('button');
            this.closeButton = this.template.find('.sv-link-popup__close');
            this.overlay = $('<div class="overlay"></div>');

            this.closeButton.on('click', this.hide.bind(this));
            this.overlay.on('click', this.hide.bind(this));
        }

        AddCustomLinkPopup.prototype.show = function () {
            this.overlay.prependTo(this.documentBody);
            this.template.prependTo(this.documentBody);
            this.template.fadeIn();
            this.overlay.fadeIn();
            this.documentBody.addClass('no-scroll');
            campaign_custom_link();
        };

        AddCustomLinkPopup.prototype.hide = function () {
            this.overlay.fadeOut(400, function () {
                $(this).remove();
            });
            this.template.fadeOut(400, function () {
                $(this).remove();
            });
            this.documentBody.removeClass('no-scroll');
        };
    }

    /**
     * Function checkbox custom link value
     */
    function AddCustomLinkPopupCheckbox() {
            $(document).on('click', '.sv-link-popup__personal-token',function () {
                if($(this).is(':checked')){
                    $(this).val('checked');
                }else{
                    $(this).val('');
                }
            })
    }
    /**
     * Function checkbox custom link value
     */
    function AddCustomLinkPopupCheckboxArticle() {
            $(document).on('click', '.campaign_custom_link_btn',function () {
                if($(this).is(':checked')){
                    $(this).val('checked');
                }else{
                    $(this).val('');
                }
            })
    }

    /**
     * Function add rows to contact lists
     */
    function contactsForm() {
        const form = $('.js-contact-list-form');
        const table = form.find('.sv-filter-table');
        const tableWrap = table.parent();
        const tbody = table.find('tbody');
        const checkAll = table.find('thead input[type="checkbox"]');
        const checkAllLabel = checkAll.next();
        let allCheckboxes = table.find('tbody input[type="checkbox"]');
        const removeButton = form.find('.js-remove-contact');
        const selectedCount = form.find('.js-selected span');
        const addRowButton = form.find('.js-add-row');

        if(!form.length) return;

        setContactsCount(allCheckboxes.length);
        sortTable();
        addRowButton.on('click', function (e) {
            tbody.append(createRow(getLastIndex()));
            checkAll.prop('checked', false);
            updateCheckboxes();
            checkboxListener();
            setContactsCount(allCheckboxes.length);
            scrollToBottom(tableWrap[0]);
        });

        $(document).on('click', "#all-contacts", function () {
            allCheckboxes.prop( 'checked', this.checked );
            updateCounter();
            removeButtonControl();
        });

        removeButton.on('click', function () {
            allCheckboxes.each(function () {
                const checkbox = $(this);

                if(checkbox.prop('checked')) {
                    checkbox.closest('tr').remove();
                }

                checkAll.prop('checked', false);
                updateTable();
            });

            updateCheckboxes();
            checkboxListener();
            setContactsCount(allCheckboxes.length);
            selectedCount.text(0);
        });

        checkboxListener();

        //create new contact row
        function createRow(lastIndex) {
            if(lastIndex < 2000) {
                return $(`
                <tr>
                    <td class="sv-new-lead__col-1">
                        <div class="sv-filter-table__td name_td">
                            <input type="text" name="name-${lastIndex + 1}" value="" placeholder="First Name">
                        </div>
                    </td>
                    <td class="sv-new-lead__col-1">
                        <div class="sv-filter-table__td name_td">
                            <input type="text" name="last_name-${lastIndex + 1}" value="" placeholder="Last Name">
                        </div>
                    </td>
                    <td class="sv-new-lead__col-2">
                        <div class="sv-filter-table__td email_td">
                            <input type="email" name="email-${lastIndex + 1}" value="" placeholder="Email">
                        </div>
                    </td>
                    <td class="sv-new-lead__col-3">
                        <div class="sv-filter-table__td"><input type="text" name="date-${lastIndex + 1}" value="${moment().format('DD/MM/YYYY')}" readonly=""></div>
                    </td>
                    <td class="sv-new-lead__col-5">
                        <div class="sv-filter-table__td sv-filter-table__td text-right">
                            <span class="sv-checkbox sv-checkbox--empty">
                                <input type="checkbox" id="contact-${lastIndex + 1}">
                                <label for="contact-${lastIndex + 1}"></label>
                                <input type="hidden"  class="row-id" name="contact-${lastIndex + 1}">
                            </span>
                        </div>
                    </td>
                </tr>
            `);
            } else {
                $('.sv-action__notification').removeClass('d-none');
            }
        }

        //return number of last checkbox
        function getLastIndex() {
            if(!allCheckboxes.length) {
                return 0;
            }

            return +allCheckboxes
                .last()
                .attr('id')
                .split('-')[1];
        }

        function updateCheckboxes() {
            allCheckboxes = table.find('tbody input[type="checkbox"]');
        }

        //return true if all checkboxes are checked
        function isAllChecked() {
            let checked = true;

            allCheckboxes.each(function () {
                if(!this.checked) {
                    checked = false;
                    return false;
                }
            });

            return checked;
        }

        //return true if some of checkboxes are checked
        function isSomeChecked() {
            let checked = false;

            allCheckboxes.each(function () {
                if(this.checked) {
                    checked = true;
                    return false;
                }
            });

            return checked;
        }

        //add click listener for checkboxes
        function checkboxListener() {
            allCheckboxes.off().on('click', function () {
                if(checkAll.prop( 'checked' ) && !isAllChecked()) {
                    checkAll.prop( 'checked', false );
                } else if(!checkAll.attr('checked') && isAllChecked()) {
                    checkAll.prop( 'checked', true );
                }

                updateCounter();
                removeButtonControl();
            });
        }

        //set number of selected contacts
        function updateCounter() {
            let count = 0;

            allCheckboxes.each(function () {
                count += this.checked;
            });

            selectedCount.text(count);
        }

        //function updates inputs name after remove rows
        function updateTable() {
            let firstIndex = 1;

            //get all rows
            const rows = tbody.find('tr');

            if(!rows.length) return;

            //for each row get all inputs and update their name/id attributes
            rows.each(function() {
                const inputs = $(this).find('input:not([type="hidden"]):not([type="checkbox"])');
                const checkbox = $(this).find('input[type="checkbox"]')[0];
                const hiddenInput = $(this).find('input[type="hidden"]')[0];

                inputs.each(function () {
                    this.name = this.name ? this.name.split('-')[0] + `-${firstIndex}` : this.name;
                });

                if('id' in checkbox) {
                    checkbox.id = checkbox.id.split('-')[0] + `-${firstIndex}`;
                    checkbox.nextElementSibling.setAttribute('for', checkbox.id);
                }

                hiddenInput.name = hiddenInput.name ? hiddenInput.name.split('-')[0] + `-${firstIndex}` : hiddenInput.name;

                firstIndex++;
            });
        }

        //make remove contacts button active when some of contacts are selected
        function removeButtonControl() {
            if(isSomeChecked()) {
                removeButton.prop('disabled', false);
            } else {
                removeButton.prop('disabled', true);
            }
        }

        //set current count of contact rows
        function setContactsCount(count) {
            checkAllLabel.text(`Select All (${count})`);
        }
    }

    /**
     * Function filtering of wealthbox tags
     *
     */
    function tags_wealthbox_submit () {

        $("#tags_wealthbox_form").on( "submit", function(e){
            e.preventDefault();

            $("#wealthbox_loader").show();
            let data  = $(this).serialize();
            let info = {
                data: data,
                action: 'wealthbox_tags_filtering'
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    $("#wealthbox_loader").hide();
                    $("table tbody").html('').html(data.html);
                    contactsForm();
                    $('.js-selected span').text('0');
                    if($('.js-wealthbox-clear-filter').is(':visible')  && !$('#tags_wealthbox_form input:checked').length){
                        $('.js-wealthbox-clear-filter').css('display', 'none');
                    }else {
                        $('.js-wealthbox-clear-filter').css('display', 'block');
                    }
                    if ( data.limit_message == 'show' ) {
                        if ( $(".limit_message_block").hasClass('hidden') ) {
                            $(".limit_message_block").removeClass('hidden')
                        }
                        $(".limit_message_block").show();

                    }

                },
                error: function (data) {
                    $("#wealthbox_loader").hide();
                    console.log('error');
                },
            });

        })
    }

    tags_wealthbox_submit();
    $(document).on('click', '.js-wealthbox-clear-filter', function () {
        $("#tags_wealthbox_form input:checkbox").removeAttr('checked');
        $("#tags_wealthbox_form .sv-button").trigger('click');
    })

    /**
     * The function gets an element and if it has own scroll scrolls to the bottom
     */
    function scrollToBottom(el) {

        //check if the element has scroll
        if(el.scrollHeight === el.clientHeight) return;

        //jQuery element
        const $el = $(el);

        //stop animation if it is running
        $el.stop();

        //scroll to the bottom
        $el.animate({
            scrollTop: el.scrollHeight - el.clientHeight
        }, 400);
    }

    /**
     * Function makes the equal height for row in case when one of td element have > height than others
     */
    function tableRowsHeight() {
        const tables = document.querySelectorAll('.js-table-height');

        tables.forEach(function (table) {
            setHeight(table);
        });

        function setHeight(table) {
            const rows = table.querySelectorAll('tr');

            for(let row of rows) {
                let height = 0;
                const content = row.querySelectorAll('div');

                content.forEach(function (item) {
                    item.style.minHeight = 0;
                });

                for(let item of content) {
                    height = item.offsetHeight > height ? item.offsetHeight : height;
                }

                content.forEach(function (item) {
                    item.style.minHeight = height + 'px';
                });
            }
        }
    }

    /**
     * Function of changing lead list name in single lead page
     *
     */
    function deleteLeadList() {

        $(".delete_list").on('click', function () {
            let lead_id  = $(this).attr('data-id');

            let info = {
                action: 'delete_lead',
                lead_id: lead_id,
            };

            $.post({
                url: get.ajaxurl,
                data: info,
                success: function (data) {
                    $("tr.lead-"+lead_id).remove();
                    let countLeft = $(".sv-tabs__tab.active").find('span.count').text();
                    countLeft = ( parseInt( countLeft) );
                    countLeft = ( countLeft > 0 ) ? ( countLeft -1 ) : 0;
                    $(".sv-tabs__tab.active").find('span.count').text(countLeft);
                    console.log('success' );
                },
                error: function (data) {
                    console.log('error');
                },
            });

        });

    }

    /*
    * Function triggers window events
    */
    function triggerEvent(event) {

        if(!isNativeEvent(event)) return;

        window.dispatchEvent(new Event(event));

        function isNativeEvent(eventname) {
            return typeof document.body["on" + eventname] !== "undefined";
        }
    }


    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }


    /**
     * BCC Emails
     *
     */
    function bccEmail() {
        const emails = [];
        let val = '';
		if($('.bcc_emails_list').length ) {
			val = $('.bcc_emails_list').val();
		}
        $('.bcc_emails').on('keypress',function(e) {
            if(e.which == 13) {
                e.preventDefault();
                let value = $(this).val();
                if(value !== ''){
                    $(this).parent().find('.sv-tale-emails').append('<span class="sv-tale-email">'+value+'</span>');
                    emails.push(value);
                    $(this).val('');
					let value_end = (val === '') ? emails : val+','+emails;
					$(this).parent().find('.bcc_emails_list').val(value_end);
                }
            }
        });
    }


    /**
     * BCC Emails remove
     *
     */
    function bccEmailRemove() {
        $(document).on('click','.sv-tale-email',function(e) {
            let email = $(this).text();
            let val = $(this).closest('.sv-tale').find('.bcc_emails_list').val();
            $(this).remove();
            const arr = val.split(",");
            arr.splice( $.inArray(email, arr), 1 );
            $('.bcc_emails_list').val(arr);

        });
    }


    /**
     * BCC Emails Getting Value
     *
     */
    function bccEmailGetting() {
		const emails = [];

		if($('.bcc_emails_list').length && $('.bcc_emails_list').val() !== ''){
			const arr = $('.bcc_emails_list').val().split(",");
			emails.push(arr);
			$.each( emails[0], function( key, value ) {
				$('.sv-tale-emails').append('<span class="sv-tale-email">'+value+'</span>');
			});
		}

    }


    /**
     * Emails Changing Body text
     *
     */
    function codeEditor() {
        var codeToggled = false;
            $(document).on('click', '#editControls a', function(e) {
                e.preventDefault();
                switch($(this).data('role')) {
                    case 'h1':
                    case 'h2':
                    case 'h3':
                    case 'p':
                        document.execCommand('formatBlock', false, $(this).data('role'));
                        break;
                    default:
                        document.execCommand($(this).data('role'), false, null);
                        break;
                }
                var command = $(this).data('command');

                if (command == 'createlink' ) {
                    url = prompt('Enter the link here: ', 'http:\/\/');
                    if(url !== null){document.execCommand($(this).data('command'), false, url);}
                }else if(command == 'unstyle'){
                    $('#editor *').removeAttr('style').removeAttr('align').removeAttr('color');
                } else if(command == 'img'){
                    url = prompt('Enter the link of your image here: ', 'http:\/\/');
                    if(url !== null) {
                        document.execCommand('formatBlock', true, 'pre');
                        $('#editor pre').replaceWith('<img src="' + url + '" srcset="' + url + '" alt="new image" style="max-width: 400px; width: 100%; height: auto;">')
                    }
                } else if(command == 'img-url'){
                    // if(url !== null){
                        document.execCommand('formatBlock', true, 'pre');
                        customImgUpload();
                    // }
                } else document.execCommand($(this).data('command'), false, null);
            });

            $(document).on('keyup',"#editor",function() {
                var value = $(this).html();
                $("#editorCopy").val(value);
            }).keyup();
        customBR();
    };

    function customBR() {
        if($('#editor').length) {
            const ed = document.getElementById('editor');
            const key13 = function (ev) {
                if (ev.keyCode == 13) {
                    if (document.getSelection().anchorNode.parentNode.nodeName === 'P' || document.getSelection().anchorNode.parentNode.nodeName === 'SPAN' || document.getSelection().anchorNode.parentNode.nodeName === 'BR' || document.getSelection().anchorNode.parentNode.nodeName === 'DIV') {
                        ev.preventDefault();
                        const selection = window.getSelection(),
                            range = selection.getRangeAt(0),
                            node = document.getSelection().anchorNode,
                            pNode = node.parentNode;
                        var tag = pNode.nodeName.toUpperCase();
                        if (ev.ctrlKey) {
                            tag = prompt('Entet tag name', 'div');
                        } else
                            switch (tag) {
                                case 'P':
                                    tag = 'BR';
                                    break;
                                case 'SPAN':
                                    tag = 'BR';
                                    break;
                                case 'DIV':
                                    tag = 'p';
                                    break;
                            }
                        const el = document.createElement(tag);
                        range.deleteContents();
                        range.insertNode(el);
                        // if ('BR' === tag) {
                            range.setStartAfter(el);
                            range.setEndAfter(el);
                        // } else {
                        //     range.setStart(el, 0);
                        //     range.setEnd(el, 0);
                        // }
                        const ze = document.createTextNode("\u200B");
                        range.insertNode(ze);
                        range.setStartBefore(ze);
                        range.setEndBefore(ze);

                        selection.removeAllRanges();
                        selection.addRange(range);
                        ev.stopPropagation();
                    }
                }
                ;
            }
                ed.addEventListener('keydown', key13, false);

        }
    }
    function customImgUpload() {
        var uploader = document.createElement('input');

        uploader.type = 'file';
        uploader.accept = 'image/*';
        uploader.click();

        uploader.onchange = function() {
            var reader = new FileReader();

            var form_data = new FormData();
            form_data.append('file', uploader.files[0]);
            form_data.append('action', 'upload_image_js');

            $.post({
                url: get.ajaxurl,
                data: form_data,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log('success', data )
                    $('#editor pre').replaceWith('<img src="'+data.response.url+'" srcset="'+data.response.url+'" alt="new image" style="max-width: 400px; width: auto; height: auto;">')
                },
                error: function (data) {
                    console.log('error');
                },
            });

        }

    }


    /**
     *
     */
    function editBodtEmail() {
		$(document).on('click', '.sv-link-popup__close', function(){
		    $('.overlay').remove();
        })
        $('.js-sending-body-edit').on('click', function(){
            $(this).closest('tr').find('.js-custom-link').trigger('click')
        });
        // Editing in Custom Link Popup
        $('.js-custom-link').on('click', function () {
            let copy =  $(this).closest('tr').find('.sv-email-campaign__view-button').find('.js-view-email').attr('data-edited-content');
            copy =  !copy ? $(this).closest('tr').find('.sv-email-campaign__view-button').find('.js-view-email').attr('data-copy') : copy;
            $('body').addClass('no-scroll').prepend('<div class="overlay"></div>');
            $('.overlay').css('display', 'block');
            const customLink =  $(this).closest('tr').find('.custom_link_input').val() || '';

            const tagRegularExpression = /\[custom_link](.*?)\[\/custom_link]/g;
            let matches;

            $('.sv-link-popup').find('#editor').html(copy);
            // $('#editor').find( "p:contains('custom_link')" ).addClass('c_link_copy');
            customBR();
        })
    }

    /**
     *
     */
    function openNewPopupLink() {
        $(document).on('click', '.sv-link-popup__close-new, .overlay', function(){
            $('.sv-link-popup-new').removeClass('open');
            $('body').removeClass('no-scroll');
            $('.overlay').remove();
        })

        $('.js-link-popup-new').on('click', function (e) {
            e.preventDefault();
            $('body').addClass('no-scroll').prepend('<div class="overlay"></div>');
            $('.overlay').css('display', 'block');
            $('.sv-link-popup-new').addClass('open');
        })
    }

    $(document).ready(function () {

        if($.fn.datePicker instanceof Object) {
            $('.js-datePicker').datePicker();
            $('.js-sending-date-edit').datePicker();
        }

        if ( $(".single-campaign").length > 0 ) {
            if ( $(".js-draft-submit-campaign").length < 1 ) {
                $(".js-turnon-email").hide();
                $(".js-cancel-email.canceled").attr('disabled','disabled');
            }
            else {
                $(".js-cancel-email.canceled").hide();
            }
        }


        read_course();
        thing_to_do_functionality();
        scheduling_campaign_form();
        editListName();
        editLeadListName();
        save_lead_changes();
        filtering_statistic_by_date();
        filtering_function();
        video_player();
        todoList();
        adminDashboardFooterColor();
        campaignsFieldsEqualHeight();
        viewEmail();
        emailCampaignSubmitControl();
        tableTabs();
        fileUpload();
        watchVideoPopup();
        cancelCampaign();
        turnOnCampaign();
        editScheduledEmail();
        addCustomLinkToMail();
        contactsForm();
        deleteLeadList();
        editBodtEmail();
        codeEditor();
        bccEmail();
        bccEmailRemove();
		bccEmailGetting();
        openNewPopupLink();
        tableSearch(true);
        // campaign_custom_link();
    });

    $(window).on('resize orientationchange', function () {
        tableRowsHeight();
        setTimeout(campaignsFieldsEqualHeight, 0);
    });

    $(window).on('load', tableRowsHeight);

})(jQuery);
