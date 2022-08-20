<?php

namespace Dkng\Wp;

class ApiActions {

    /**
     * Function registration api calls
     *
     */
    public function register_api() {

        register_rest_route(
            'dkng',
            '/openedEmail/(?P<id>\d+)/(?P<email>[a-zA-Z0-9 .\=_%-]+)',
            array(
                'methods'  => 'GET',
                'callback' => array( $this, 'opened_email_function' ),
            )
        );

        register_rest_route(
            'dkng',
            '/clickedEmail/(?P<id>\d+)/(?P<email>[a-zA-Z0-9 .\=_%-]+)',
            array(
                'methods'  => 'GET',
                'callback' => array( $this, 'clicked_email_function' ),
            )
        );

        register_rest_route(
            'dkng',
            '/unsubscribeEmail/(?P<id>\d+)/(?P<email>[a-zA-Z0-9 .\=_%-]+)/(?P<campaign_id>\d+)',
            array(
                'methods'  => 'GET',
                'callback' => array( $this, 'unsubscribe_email_function' ),
            )
        );

        register_rest_route(
            'dkng',
            '/getUserData/(?P<id>\d+)',
            array(
                'methods'  => 'GET',
                'callback' => array( $this, 'get_user_data_api' ),
            )
        );

    }


    /**
     * Function for getting all user info by API
     *
     * @param $request
     */
    public function get_user_data_api( $request ) {

        if ( function_exists( 'rocket_clean_domain' ) ) {
            rocket_clean_domain();
        }

        $response = array();
        $id_u     = $request->get_param( 'id' );

        $sharing_image             = get_the_post_thumbnail_url( $id_u, 'thumbnail' );
        $response['sharing_image'] = str_replace( '-150x150', '', $sharing_image );

        $response['phone']        =  get_field( 'phone',         'user_' . $id_u );
        $response['email']        =  get_field( 'email',         'user_' . $id_u );
        $response['office']       =  get_field( 'office',        'user_' . $id_u );
        $response['toll_free']    =  get_field( 'toll-free',     'user_' . $id_u );
        $response['fax']          =  get_field( 'fax',           'user_' . $id_u );
        $response['email_footer'] =  get_field( 'email_footer',  'user_' . $id_u );
        $response['address']      =  get_field( 'address',       'user_' . $id_u );
        $response['address2']     =  get_field( 'address2',      'user_' . $id_u );
        $response['town']         =  get_field( 'town',          'user_' . $id_u );
        $response['state']        =  get_field( 'state',         'user_' . $id_u );
        $response['postal']       =  get_field( 'postal',        'user_' . $id_u );
        $response['days']         =  get_field( 'days',          'user_' . $id_u );
        $response['disclaimer']   =  get_field( 'disclaimer',    'user_' . $id_u );
        $response['fb_link']      =  get_field( 'facebook_link', 'user_' . $id_u );
        $response['tw_link']      =  get_field( 'twitter_link',  'user_' . $id_u );
        $response['lkdn_link']    =  get_field( 'linkedin_link', 'user_' . $id_u );
        $response['ytb_link']     =  get_field( 'youtube_link',  'user_' . $id_u );
        $response['meet_link']    =  get_field( 'meeting_calendar_link', 'user_' . $id_u );
        $custom_site              =  get_field( 'custom_site',   'user_' . $id_u );
        $company                  =  get_field( 'name',   'user_' . $id_u );
        $response['custom_site']  =  !empty( $custom_site ) ? $custom_site : get_site_url();
        $response['avatar']       =  get_user_meta( $id_u, 'avatar', true );
        $response['display_name'] =  get_userdata( $id_u )->display_name;
        $response['first_name']   =  get_userdata( $id_u )->first_name;
        $response['last_name']    =  get_userdata( $id_u )->last_name;
		$response['position']     =  get_field( 'position','user_' . $id_u );
		$response['company']      =  $company;

        $upload_dir   = wp_upload_dir();
        $file_name    = get_user_meta( $id_u, 'avatar', true );
        $fileurl      = $upload_dir['basedir'] . '/' . $file_name;
        $filepath     = $upload_dir['baseurl'] . '/' . $file_name;
        $fileurl      = ( file_exists( $fileurl ) && !empty( $file_name ) ) ? $filepath : get_template_directory_uri() . "/dist/img/avatar.png";
        $response['fileurl']  =  $fileurl;

        nocache_headers();

        $result = new \WP_REST_Response( $response, 200 );
        // Set headers.
        $result->set_headers(array('Cache-Control' => 'no-cache'));

        wp_send_json( $response, 200 );
    }


    /**
     * Function callback for opening sent scheduling email by email data
     *
     * @param $request
     */
    public function opened_email_function( $request ) {
        $email  = $request->get_param( 'email' );
        $email  = base64_decode( $email );
        $id     = $request->get_param( 'id' );

        $campaigns = new Campaigns();
        $campaigns->update_api_action_status( $id, $email,'opened' );
        wp_send_json( array( 'status' => 'Done' ), 200 );
    }

    /**
     * Function callback for clicking sent scheduling email by email data
     *
     * @param $request
     */
    public function clicked_email_function( $request ) {
        $email  = $request->get_param( 'email' );
        $email  = base64_decode( $email );
        $id     = $request->get_param( 'id' );

        $campaigns = new Campaigns();
        $campaigns->update_api_action_status( $id, $email,'clicked' );
//        wp_send_json( array( 'status' => 'Done' ), 200 );
    }


    /**
     * Function callback for clicking sent scheduling email by email data
     *
     * @param $request
     */
    public function unsubscribe_email_function( $request ) {
        $email       = $request->get_param( 'email' );
        $email       = base64_decode( $email );
        $campaign_id = $request->get_param( 'campaign_id' );
        $id          = $request->get_param( 'id' );

        $campaigns = new Campaigns();
        $campaigns->update_api_action_status( $id, $email,'unsubscribed' );

        $campaigns->unsubscribe_email_from_user_list( $id, $email, $campaign_id );

        $url = 'https://finplaninfo.io/sorry-to-see-you-go/';
        wp_redirect( $url, 301 );
        exit;
    }

}
