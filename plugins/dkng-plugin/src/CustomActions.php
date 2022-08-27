<?php

namespace Dkng\Wp;

class CustomActions {


    /**
     * Actions on Init
     */
    public function init_actions() {

//        add_action( 'wp_ajax_contact_page',              [ $this,  'contact_page_function' ] );
//        add_action( 'wp_ajax_nopriv_contact_page',       [ $this,  'contact_page_function' ] );


    }


    /**
     * Function callback for contact page
     *
     */
    public function contact_page_function() {

        if ( empty( $_POST['data'] ) ) {
            return;
        }

        parse_str ( $_POST['data'], $params );

        if ( !filter_var( $params["email"], FILTER_VALIDATE_EMAIL ) ) {
            wp_send_json( array('error'=> false, 'message' => 'Not correct email address.'), 500 );
        }

        // Mail::prepare_mail_info( $params);

        wp_send_json( array( 'error'=> false, 'message' => 'Done.', 'data' => $params ), 200 );

    }

}
