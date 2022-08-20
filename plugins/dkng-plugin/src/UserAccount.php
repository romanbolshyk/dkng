<?php

namespace Dkng\Wp;

use Braintree\VenmoAccount;
use Dkng\Wp\CustomActions;

class UserAccount {

    public $custom_actions;

    /**
     *
     */
    public function __construct() {
        $this->custom_actions = new CustomActions();
    }

    /**
     * Actions on Init
     */
    public function init_actions() {

        add_action( 'wp_ajax_edit_user_account',         [ $this,  'edit_user_account_function' ] );
        add_action( 'wp_ajax_nopriv_edit_user_account',  [ $this,  'edit_user_account_function' ] );

        add_action( 'wp_ajax_user_image',                [ $this,  'user_image_function' ] );
        add_action( 'wp_ajax_nopriv_user_image',         [ $this,  'user_image_function' ] );

    }

    /**
     * Function callback of user account info
     *
     */
    public function edit_user_account_function() {

        $post = $_POST;
        parse_str( $post['data'], $params );

        $user         = wp_get_current_user();
        $position     = !empty( $params['job-title'] ) ?  $params['job-title'] : "";
        $timezone     = !empty( $params['timezone_string'] ) ? $params['timezone_string'] : "America/Los_Angeles";
        $company_name = !empty( $params['name'] ) ?  $params['name'] : "";
        $phone        = !empty( $params['phone'] ) ?  $params['phone'] : "";
        $email        = !empty( $params['email'] ) ?  $params['email'] : "";

        $fb_link      = !empty( $params['fb_link'] )   ? $params['fb_link'] : "";
        $tw_link      = !empty( $params['tw_link'] )   ? $params['tw_link'] : "";
        $lnkd_link    = !empty( $params['lnkd_link'] ) ? $params['lnkd_link'] : "";
        $ytb_link     = !empty( $params['ytb_link'] )  ? $params['ytb_link']  : "";
        $meet_link    = !empty( $params['meet_link'] ) ? $params['meet_link'] : "";
        $address      = !empty( $params['address'] )   ? $params['address'] : "";
        $sendgrid_address   = !empty( $params['sendgrid_address'] ) ? $params['sendgrid_address'] : "";
        $sendgrid_city      = !empty( $params['sendgrid_city'] ) ? $params['sendgrid_city'] : "";
        $sendgrid_country   = !empty( $params['sendgrid_country'] ) ? $params['sendgrid_country'] : "";
        $wealthbox_api_key  = !empty( $params['wealthbox_api_key'] ) ? $params['wealthbox_api_key'] : "";
        $article_disclosure = !empty( $params['article_disclosure'] ) ? $params['article_disclosure'] : "";
        $email_disclosure   = !empty( $params['email_disclosure'] ) ? $params['email_disclosure'] : "";
        $password     = !empty( $params['password'] )    ? $params['password'] : "";
        $first_name   = !empty( $params['first_name'] )  ? $params['first_name'] : "";
        $last_name    = !empty( $params['last_name'] )   ? $params['last_name'] : "";
        $custom_site  = !empty( $params['custom_site'] ) ? $params['custom_site'] : "";
        // $user_phase   = $params['user_phase'] !empty( $params['user_phase'] ) ?  $params['user_phase'] : "";

        if ( !filter_var( $params["email"], FILTER_VALIDATE_EMAIL ) ) {
            wp_send_json( array('error'=> false, 'message' => 'Not correct email address.'), 500 );
        }

        update_field( 'position',      $position,     'user_'.$user->ID );
        update_field( 'name',          $company_name, 'user_'.$user->ID );
        update_field( 'phone',         $phone,        'user_'.$user->ID );
        update_field( 'email',         $email,        'user_'.$user->ID );

        update_field( 'facebook_link', $fb_link,      'user_'.$user->ID );
        update_field( 'twitter_link',  $tw_link,      'user_'.$user->ID );
        update_field( 'linkedin_link', $lnkd_link,    'user_'.$user->ID );
        update_field( 'youtube_link',  $ytb_link,     'user_'.$user->ID );
        update_field( 'meeting_calendar_link', $meet_link,       'user_'.$user->ID );
        update_field( 'sendgrid_address',   $sendgrid_address,   'user_'.$user->ID );
        update_field( 'address',            $address,            'user_'.$user->ID );
        update_field( 'sendgrid_city',      $sendgrid_city,      'user_'.$user->ID );
        update_field( 'sendgrid_country',   $sendgrid_country,   'user_'.$user->ID );
        update_field( 'wealthbox_api_key',  $wealthbox_api_key,  'user_'.$user->ID );
        update_field( 'disclaimer',         $article_disclosure, 'user_'.$user->ID );
        update_field( 'email_disclosure',   $email_disclosure,   'user_'.$user->ID );
        update_field( 'custom_site',        $custom_site,        'user_'.$user->ID );
        update_field( 'user_timezone',      $timezone,           'user_'.$user->ID );
        // update_field( 'user_phase',    $user_phase,   'user_'.$user->ID );

        if ( !empty( $password ) ) {
            wp_set_password( $password, $user->ID );
        }
        update_user_meta( $user->ID, 'first_name', $first_name );
        update_user_meta( $user->ID, 'last_name',  $last_name );

        if ( $this->custom_actions->update_articles_company( $user->ID, $company_name ) ) {
            wp_send_json( array( 'status' => 'Done' ), 200);
        }
        else {
            wp_send_json('Something wrong.', 200);
        }

    }

    /**
     * Function uploading image for user
     *
     */
    public function user_image_function() {

        $user  = wp_get_current_user();
        if ( !function_exists( 'wp_handle_upload'  ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $upload_dir    = wp_upload_dir();
        $uploadedfile  = $_FILES['file'];
        $filetype      = wp_check_filetype( basename( $uploadedfile['name'] ), null );
        $filetype      = $filetype['ext'];

        $date_now = date('m-d-h-s');

        $image                = explode('.',  $uploadedfile['name'] );
        $uploadedfile['name'] = "ava_" . $user->ID . "." . $date_now . '.' .  $filetype;
        $fileurl              = $upload_dir['path'] . '/' . $uploadedfile['name'];
        $fileurl1             = $upload_dir['path'] . '/' . "ava_" . $user->ID;
        $filepath             = $upload_dir['url'] . '/' . $uploadedfile['name'];;
        $avatar_url           = $upload_dir['subdir'] . '/' . $uploadedfile['name'];;

        $files_path = scandir( $upload_dir['path'] );
        $user_image_label = "ava_" . $user->ID . ".";
        $this->check_delete_files_from_path( $files_path, $user_image_label, $upload_dir['path'] );
        $this->check_delete_file( $fileurl );

        if ( function_exists( 'rocket_clean_domain' ) ) {
            rocket_clean_domain();
        }

//        update_user_meta( $user->ID, 'avatar',  $uploadedfile['name'] );

        $upload_overrides     = array( 'test_form' => false );
        $movefile             = wp_handle_upload($uploadedfile, $upload_overrides);

        if ( $movefile && !isset( $movefile['error'] ) ) {
            $response = "done";
        } else {
            /**
             * Error generated by _wp_handle_upload()
             * @see _wp_handle_upload() in wp-admin/includes/file.php
             */
            $response =  $movefile['error'];
        }

        update_user_meta( $user->ID, 'avatar',  $avatar_url );

        wp_send_json( array( 'message' => $response, 'avatar_url' => $avatar_url ), 200 );

    }

    /**
     * Function checking and deleting files of avatars
     *
     * @param $file
     * @return bool
     */
    public function check_delete_file( $fileurl ) {
        if ( file_exists( $fileurl ) ) {
            chmod( $fileurl, 777 );
            unlink( $fileurl );
        }

        return true;
    }

    /**
     * Function checking and deleting files of avatars
     *
     * @param $path_files
     * @param $user_image_label
     * @param $path_dir
     *
     * @return bool
     */
    public function check_delete_files_from_path( $path_files, $user_image_label, $path_dir ) {

        foreach (  $path_files as  $path_file ) {
            if ( strstr( $path_file, $user_image_label ) ) {
                chmod( $path_dir. '/' .$path_file, 777 );
                unlink( $path_dir. '/' .$path_file );
            }
        }

        return true;
    }

}
