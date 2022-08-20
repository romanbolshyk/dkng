(function ($) {

    /**
     * Function for updating user function
     *
     */
    function updating_user_function() {

        if ( ( $("#createuser").length > 0 ) || ( $("#your-profile").length > 0 ) ) {
            $("form#createuser, form#your-profile").find("input#user_login, input#pass1, input#pass2").attr('autocomplete', 'chrome-off');

            $("form#your-profile").find("input#pass1, input#pass2").val('').attr('data-pw', '');
            $("form#your-profile").find("input#pass1, input#pass2").attr('disabled', 'disabled');
            $("form#createuser").find(".wp-pwd").hide();
            // $("form#your-profile").find("input[type='hidden']").attr('disabled', 'disabled');

            let fake_html = '<input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />\n' +
                '<input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />';
            $("#pass1").parent("span").before(fake_html );
        }
    }
    updating_user_function();


    /**
     * Function for identifying article type ( Cloned or Original by color styles )
     *
     */
    function  wp_admin_articles_functionality( ) {

        if ( $("body").hasClass('post-type-articles') ) {
            $("table.posts tbody").find('tr').each( function () {
                let a = $(this).find('td.column-taxonomy-articles-types a').text();
                let aElem = $(this).find('td.column-taxonomy-articles-types a');
                if( ( a == 'Original' ) || ( a == '') ) {
                    aElem.css({
                            'background': 'lightgreen',
                            'padding': '10px',
                            'display': 'inline-block'
                    });
                }
                else if( a == 'Cloned') {
                    aElem.css({
                        'background': 'lightyellow',
                        'padding': '10px',
                        'display': 'inline-block'
                    });

                }
            } );
        }

    }

    wp_admin_articles_functionality();


})(jQuery);
