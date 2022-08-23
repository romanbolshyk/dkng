<?php

namespace Dkng\Wp;

class Campaigns {

    public $tracking_table;

    /**
     * Function construct of class
     *
     */
    public function __construct( ) {
        $this->tracking_table = 'scheduling_campaigns';
//        $this->tracking_table = 'tracking_table';
    }

    /**
     * Actions on Init
     */
    public function init_actions() {

        self::creating_scheduling_emails_table();
        self::creating_tracking_scheduling_emails_table();
        // call_user_func( [ $this, 'cron_settings' ] );

        // enqueve js/CSS resources
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts_styles' ] );

        /*
        // ajax actions
        add_action( 'wp_ajax_scheduling_campaign',                [ $this,    'scheduling_campaign' ] );
        add_action( 'wp_ajax_nopriv_scheduling_campaign',         [ $this,    'scheduling_campaign' ] );

        add_action( 'wp_ajax_edit_scheduling_campaign',           [ $this,    'edit_scheduling_campaign' ] );
        add_action( 'wp_ajax_nopriv_edit_scheduling_campaign',    [ $this,    'edit_scheduling_campaign' ] );

        add_action( 'wp_ajax_draft_scheduling_campaign',          [ $this,    'draft_scheduling_campaign' ] );
        add_action( 'wp_ajax_nopriv_draft_scheduling_campaign',   [ $this,    'draft_scheduling_campaign' ] );

        add_action( 'wp_ajax_edit_draft_campaign',                [ $this,    'edit_draft_scheduling_campaign' ] );
        add_action( 'wp_ajax_nopriv_edit_draft_campaign',         [ $this,    'edit_draft_scheduling_campaign' ] );

        add_action( 'wp_ajax_cancel_email',                       [ $this,    'canceling_scheduling_email' ] );
        add_action( 'wp_ajax_nopriv_cancel_email',                [ $this,    'canceling_scheduling_email' ] );

        add_action( 'wp_ajax_filtering_statistic_by_date',        [ $this,    'filtering_statistic_by_date' ] );
        add_action( 'wp_ajax_nopriv_filtering_statistic_by_date', [ $this,    'filtering_statistic_by_date' ] );

        add_action( 'wp_ajax_clone_campaign',                     [ $this,    'clone_campaign_function' ] );
        add_action( 'wp_ajax_nopriv_clone_campaign',              [ $this,    'clone_campaign_function' ] );

        add_action( 'wp_ajax_delete_clone_campaign',              [ $this,    'delete_clone_campaign_function' ] );
        add_action( 'wp_ajax_nopriv_delete_clone_campaign',       [ $this,    'delete_clone_campaign_function' ] );

        add_action( 'wp_ajax_export_edited_campaign_data',        [ $this,    'export_edited_campaign_data' ] );
        add_action( 'wp_ajax_nopriv_export_edited_campaign_data', [ $this,    'export_edited_campaign_data' ] );

        add_action( 'wp_ajax_change_clone_campaign_name',         [ $this,    'change_clone_campaign_name' ] );
        add_action( 'wp_ajax_nopriv_change_clone_campaign_name',  [ $this,    'change_clone_campaign_name' ] );

        add_action( 'wp_ajax_export_campaign_list',               [ $this,    'export_campaign_list_func' ] );
        add_action( 'wp_ajax_nopriv_export_campaign_list',        [ $this,    'export_campaign_list_func' ] );

        add_action( 'wp_ajax_pause_campaign',                     [ $this,    'pause_campaign_func' ] );
        add_action( 'wp_ajax_nopriv_pause_campaign',              [ $this,    'pause_campaign_func' ] );

        add_action( 'wp_ajax_restore_campaign',                   [ $this,    'restore_campaign_func' ] );
        add_action( 'wp_ajax_nopriv_restore_campaign',            [ $this,    'restore_campaign_func' ] );

        add_action( 'wp_ajax_stop_campaign',                      [ $this,    'stop_campaign_func' ] );
        add_action( 'wp_ajax_nopriv_stop_campaign',               [ $this,    'stop_campaign_func' ] );

        add_action( 'wp_ajax_single_campaign_report_tab',         [ $this,    'single_campaign_report_tab' ] );
        add_action( 'wp_ajax_nopriv_single_campaign_report_tab',  [ $this,    'single_campaign_report_tab' ] );

        add_action( 'wp_ajax_upload_image_js',                    [ $this,    'upload_campaign_image_js' ] );
        add_action( 'wp_ajax_nopriv_upload_image_js',             [ $this,    'upload_campaign_image_js' ] );
        */

        add_action( 'restrict_manage_posts',                      [ $this,    'categories_filters'], 10, 2 );
    }

    /**
     * Function of including scripts for current cpt
     *
     */
    public function enqueue_scripts_styles() {

        if ( is_page_template( 'templates/dashboard-campaigns.php' ) || ( is_singular( 'campaigns') )
            || ( strstr( $_SERVER['REQUEST_URI'], 'admin-campaigns/?page=' ) )
        ) {
            wp_enqueue_script( 'campaign-scripts', SVN_PLUGIN_URL . '/assets/campaigns.js', array( 'jquery' ), date('ds'), true );
//            wp_enqueue_style( 'template',   plugins_url( '../assets/scss/blocks/template.css', __FILE__ ), 'all', date('m.d.H') );
        }
    }

    /**
     * Function get expire data and chage role for expired membership
     *
     * @return string
     */
    public function cron_settings() {

        add_filter( 'cron_schedules', function() {

            $schedules['1_min'] = array(
                'interval' => 60,
                'display'  => __( 'In 1 minute' )
            );

            $schedules['every_half_hour'] = array(
                'interval' => 1800,
                'display'  => __( 'Every Half Hour' ),
            );

            $schedules['every_15_mins'] = array(
                'interval' => 900,
                'display'  => __( 'Every 15 minutes' ),
            );

            $schedules['every_1_hour'] = array(
                'interval' => 3600,
                'display'  => __( 'Every 1 hours' ),
            );

            return $schedules;

        });

        if ( !wp_next_scheduled( 'emails_cron_sync' ) ) {
            wp_schedule_event( time(), 'every_15_mins', 'emails_cron_sync' );
        }

        add_action( 'emails_cron_sync',  array( $this, 'emails_cron_sync1' ) );

    }

    /**
     * Emails executing cron function - runs scheduling campaigns with status *inprogress*
     *
     */
    public function emails_cron_sync1() {

        $limit_emails = 500;

        $selected_timezone = get_option( 'timezone_string' );
        date_default_timezone_set( $selected_timezone );
        $needed_emails = $this->get_inpogress_emails();

        if ( !empty( $needed_emails ) )  {

            foreach ( $needed_emails as $email ) {

                $email_id     = $email['id'];
                $campaign_id  = $email['campaign_id'];
                $sending_time = $email['sending_time'];
                $user_db      = $email['user_id'];
                $users_group  = $email['user_list'];
                $custom_link  = $email['custom_link'];
                $custom_personal_token = $email['custom_personal_token'];
                $bcc_emails_list       = $email['bcc_emails_list'];
                $iteration             = $email['sending_iteration'];

                if ( $this->tracking_table == 'scheduling_campaigns' ) {
                    $statistics        = $email['statistics']; // current logic
                }
                else {
                    $statistics        = $this->get_tracking_statistic_by_email( $email_id ); // TODO with tracking system
                }

                $count_all_receivers   = (int)$email['count_get_users'];

                $statistics  = ( !empty( $statistics ) ) ? json_decode( $statistics, true ) : array();
                $sent_emails = ( !empty( $statistics ) ) ? $statistics['sent'] : array();

                $bcc_emails_list_sendgrid = array();
                if ( !empty( $bcc_emails_list ) ) {
                    $bcc_emails_list       = explode( ',', $bcc_emails_list );
                    $bcc_emails_list       = !empty( $bcc_emails_list ) ? $bcc_emails_list : array();

                    foreach ( $bcc_emails_list as $email1 ) {
                        $email_username = explode( '@', $email1 );
                        $bcc_emails_list_sendgrid[$email1] = $email_username[0];
                    }

                }

                $upload_dir   = wp_upload_dir();
                $file_name    = get_user_meta( $user_db, 'avatar', true );
                $user_info    = get_userdata( $user_db );
                $fileurl      = $upload_dir['basedir'] . '/' . $file_name;
                $filepath     = $upload_dir['baseurl'] . '/' . $file_name;
                $fileurl      = ( file_exists( $fileurl ) && !empty( $file_name ) ) ? $filepath : get_site_url() . "/wp-content/themes/seven/dist/img/avatar.png";

                $name         = $user_info->user_firstname . ' ' . $user_info->user_lastname;
                $phone        = get_field( 'phone', 'user_' . $user_db );
                $email_admin  = get_field( 'email', 'user_' . $user_db );
                $email_disclosure = get_field( 'email_disclosure','user_' . $user_db );
                $email_admin  = ( !empty( $email_admin ) ) ? $email_admin : $user_info->user_email;

                /** Getting user's timezone */
                $user_timezone    = get_field( 'user_timezone', 'user_'.$user_db );
                $default_timezone = get_option('timezone_string');
                $user_timezone    = !empty( $user_timezone ) ? $user_timezone : $default_timezone;
                $valid_timezone   = false;
                $user_timezone    = !empty( $valid_timezone ) ? $user_timezone : $default_timezone;
                $user_cur_time    = new \DateTime( "now", new \DateTimeZone( $user_timezone ) );
                $user_cur_time    = $user_cur_time->format('Y-m-d H:i:s');

                if ( ( $email['status'] == 'inprogress' ) && ( $user_cur_time >= $sending_time ) ) {
                    $id_email        = $email['id'];

                    $users_from_list = UsersLists::get_lead_emails_by_list_id( $users_group );
                    $users_from_list = array_values( $users_from_list );
                    $email_subject  = ( !empty( $email['email_subject_new'] ) ) ? stripslashes ( $email['email_subject_new'] ) : stripslashes ( $email['email_subject'] );

                    $email_body      = $email['email_body'];
                    $email_body1     = '';

                    $footer_text1    = '';
                    $footer_text2    = '';
                    $unsubscribe_text = '';

                    $author_id    = get_field( 'author_id', $users_group );
                    $address1     = get_field( 'address',  'user_' . $author_id );
                    $address2     = get_field( 'address2', 'user_' . $author_id );
                    $city         = get_field( 'town',     'user_' . $author_id );
                    $state        = get_field( 'state',    'user_' . $author_id );
                    $zip_code     = get_field( 'postal',   'user_' . $author_id );
                    $website      = get_field( 'custom_site',  'user_' . $author_id );
                    $company      = get_field( 'name',         'user_' . $author_id );
                    $position     = get_field( 'position',     'user_' . $author_id );

                    $campaign_users_statistics = get_user_meta( $user_db, 'campaign_users_statistics', true );
                    $campaign_users_statistics = !empty( $campaign_users_statistics ) ? $campaign_users_statistics : array();
                    $user_unsubscribers        = $campaign_users_statistics['unsubscribers'];

                    /* Preparing data for email body */
                    $footer_text = "
                                <div class='sv-email-popup__user' style='margin-top: 20px;display: flex; align-items: flex-start;'>
                                <div style='overflow: hidden; display: block; height: 96px; max-height: 96px;'>
                                    <img src='$fileurl' style='max-width: 96px; height: auto; display: inline-block; vertical-align: top;' width='96'></div>
                                    <div class='sv-email-popup__user-info' style='display: inline-block; margin-left: 15px; border-left: 2px solid #000; padding-left: 20px;'>
                                        <p style='color: #000; font-family: Roboto,sans-serif; line-height: 1.57; font-size: 18px; font-weight: 700; margin-bottom: 5px; margin-top: 0;'><b>$name</b></p>
                                        <p style='color: #000; font-family: Roboto,sans-serif; line-height: 1.57; font-size: 14px; font-weight: 400; margin-bottom: 0; margin-top: 0;'><b>$company</b></p> 
                                        <p style='color: #000; font-family: Roboto,sans-serif; line-height: 1.57; font-size: 14px; font-weight: 400; margin-bottom: 0; margin-top: 0;'><b>$position</b></p> 
                                        <p style='color: #000; font-family: Roboto,sans-serif; line-height: 1.57; font-size: 14px; font-weight: 400; margin-bottom: 5px; margin-top: 0;'>$email_admin</p>
                                        <p style='color: #000; font-family: Roboto,sans-serif; line-height: 1.57; font-size: 14px; font-weight: 400; margin-bottom: 0; margin-top: 0;'>$phone</p> 
                                        <p style='color: #000; font-family: Roboto,sans-serif; line-height: 1.57; font-size: 14px; font-weight: 400; margin-bottom: 0; margin-top: 0;'>$website</p> 
                                        <p style='color: #000; font-family: Roboto,sans-serif; line-height: 1.57; font-size: 14px; font-weight: 400; margin-bottom: 5px; margin-top: 0;'>$address1</p>
                                    </div>
                                </div>
                            ";

                    if ( !empty( $email_disclosure ) ) {
                        $footer_text1 = "
                                    <div class='email_disclosure_content' 
                                        style='margin-top: 15px;color: #000;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;line-height: 1.57'>
                                        $email_disclosure
                                    </div>
                                ";
                    }

                    $address1_text = !empty( $address1 ) ? "<p>$address1</p>" : "";
                    $address2_text = !empty( $address2 ) ? "<p>$address2</p>" : "";
                    $address3_text = ( !empty( $city ) && !empty( $state ) && !empty( $zip_code ) ) ? "<p>$city, $state, $zip_code</p>" : "";

                    $footer_text2  = "
                                <div class='user_email' style='margin-top: 20px;'>
                                    <p>" . __( 'Address', 'dkng' ) . ":</p>
                                    $address1_text
                                    $address2_text
                                    $address3_text
                                </div>
                            ";
                    /* End Preparing data for email body */

                    if ( !empty( $users_from_list ) ) {

                        $iteration = empty( $iteration ) ? 0 : (int)$iteration;

                        $part_array       = array_chunk( $users_from_list, $limit_emails );

                        $users_from_list1 = $part_array[$iteration];
                        $email_parts      = array(
                            'footer_text'  => $footer_text,
                            'footer_text1' => $footer_text1,
                            'footer_text2' => $footer_text2,
                            'email_body'   => $email_body,
                            'custom_link'  => $custom_link,
                            'custom_personal_token' => $custom_personal_token,
                        );
                        $email_bodies     = $this->set_email_body_by_user( $users_from_list1, $id_email, $campaign_id, $email_parts, $sent_emails, $user_unsubscribers );

                        $mail = Mail::sending_bulk_email_loop_via_sendgrid( $user_db, $users_from_list1, $email_bodies, $email_subject, $bcc_emails_list_sendgrid, $iteration );

                        if ( !empty( $mail ) ) {
                            $iteration = empty( $iteration ) ? 1 : (int)$iteration+1;
                            $this->update_email_iteration( $id_email, $iteration );

                            $this->update_sent_loop_status( $id_email, $users_from_list1, $email_bodies, $email_subject, $campaign_id, $user_db );

                            if ( ( $iteration * $limit_emails ) >= $count_all_receivers ) {

                                $this->update_sent_status( $id_email, 'sent' );

                                $left_emails = $this->get_active_emails( $campaign_id, $user_db );
                                if ( (int)$left_emails == 0 ) {
                                    $user_campaigns = get_user_meta( $user_db, 'user_campaigns', true );
                                    $user_campaigns = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();

                                    $user_campaigns['finished'][$campaign_id] = $campaign_id;
                                    if ( array_key_exists( $campaign_id, $user_campaigns['active'] ) ) {
                                        unset( $user_campaigns['active'][$campaign_id] );
                                    }
                                    update_user_meta( $user_db, 'user_campaigns', $user_campaigns );
                                }

                            }
                        }

                    }

                }
            }

        }

    }

    /**
    * Function scheduling campaign callback
    *
    */
    public function scheduling_campaign() {

        $post = $_POST;
        parse_str ( $post['data'], $params );
        $user         = wp_get_current_user();

        $campaign_id  = (int)$params['campaign_id'];
        $users_group  = (int)$params['campaign_group'];
        $emails       = get_field( 'emails', $campaign_id );
        $count_using_lead = get_field( 'count_of_using', $users_group );
        $count_using_lead = empty( $count_using_lead ) ? 1 : ( (int)$count_using_lead + 1 );

        $users_from_list  = UsersLists::get_lead_emails_by_list_id( $users_group );
        $users_from_list  = array_values( $users_from_list );

        $count_users  = count( $users_from_list );

        $start_date   = array();
        if ( !empty( $emails ) ) {
            $i = 0;
            foreach ( $emails as $email ) {
                $i++;
                $custom_link       = $params['custom_link'.$i];
                $custom_personal_token = $params['custom_personal_token'.$i];
                $custom_article_token  = $params['custom_article_token'.$i];
                $bcc_emails_list   = $params['bcc_emails_list'];
                $date              = !empty( $params['date'.$i] ) ? $params['date'.$i] : date("Y-m-d H:i:s");
                $start_date[]      = $date;
                $email_body        = !empty( $params['custom_edited_content'.$i] ) ? $params['custom_edited_content'.$i]  : $email['email_body'];
                $email_body        = stripslashes ( $email_body );

                $email_subject_original = $email['email_subject'];
                $email_subject_new      = ( !empty( $params['email_subject'.$i] ) && ( $email_subject_original != $params['email_subject'.$i] ) ) ? $params['email_subject'.$i] : '';

                if ( !empty( $date ) ) {
                    $this->insert_scheduling_emails( $campaign_id, $email_subject_original, $email_subject_new, $email_body, $custom_link, $custom_personal_token, $custom_article_token, $bcc_emails_list, $users_group, $date, $count_users );
                }
            }

            $user_campaigns = get_user_meta( $user->ID, 'user_campaigns', true );
            $user_campaigns = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();
            if ( ( !empty( $user_campaigns['active'] ) && !array_key_exists( $campaign_id, $user_campaigns['active'] ) ) || empty( $user_campaigns['active'] ) ) {
                $user_campaigns['active'][$campaign_id] = min( $start_date );
            }
            if ( !empty( $user_campaigns['finished'] ) && array_key_exists( $campaign_id, $user_campaigns['finished'] ) ) {
                unset( $user_campaigns['finished'][$campaign_id] );
            }

            $left_emails = $this->get_active_emails( $campaign_id, $user->ID );
            if ( (int)$left_emails == 0 ) {
                unset( $user_campaigns['active'][$campaign_id] );
                $user_campaigns['finished'][$campaign_id] = $campaign_id;
            }

            update_user_meta( $user->ID, 'user_campaigns', $user_campaigns );
            update_field( 'count_of_using', $count_using_lead, $users_group );

        }

        wp_send_json( array( 'status' => 'Done' ), 200 );
    }


    /**
     * Function draft scheduling campaign callback
     *
     */
    public function draft_scheduling_campaign() {

        $post = $_POST;
        parse_str ( $post['data'], $params );

        $user         = wp_get_current_user();

        $campaign_id  = (int)$params['campaign_id'];
        $users_group  = (int)$params['campaign_group'];
        $emails       = get_field( 'emails', $campaign_id );

        $users_from_list  = UsersLists::get_lead_emails_by_list_id( $users_group );
        $users_from_list  = array_values( $users_from_list );

        $count_users  = count( $users_from_list );

        $start_date   = array();
        if ( !empty( $emails ) ) {
            $i = 0;
            foreach ( $emails as $email ) {
                $i++;
                $custom_link       = $params['custom_link'.$i];
                $custom_personal_token = $params['custom_personal_token'.$i];
                $custom_article_token  = $params['custom_article_token'.$i];
                $bcc_emails_list   = $params['bcc_emails_list'];
                $date              = $params['date'.$i];
                $email_body        = !empty( $params['custom_edited_content'.$i] ) ? $params['custom_edited_content'.$i]  : $email['email_body'];
                $email_body        = stripslashes ( $email_body );
                $start_date[]      = $date;
                $status            = ( $date == 'canceled' ) ? 'canceled' : 'draft';

                $email_subject_original = $email['email_subject'];
                $email_subject_new      = ( !empty( $params['email_subject'.$i] ) && ( $email_subject_original != $params['email_subject'.$i] ) ) ? $params['email_subject'.$i] : '';

                $this->insert_scheduling_emails( $campaign_id, $email_subject_original, $email_subject_new, $email_body, $custom_link, $custom_personal_token, $custom_article_token, $bcc_emails_list, $users_group, $date, $count_users, $status );
            }

            $user_campaigns = get_user_meta( $user->ID, 'user_campaigns', true );
            $user_campaigns = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();
            if ( ( !empty( $user_campaigns['draft'] ) && !array_key_exists( $campaign_id, $user_campaigns['draft'] ) ) || empty( $user_campaigns['draft'] ) ) {
                $user_campaigns['draft'][$campaign_id] = min( $start_date );
            }

            update_user_meta( $user->ID, 'user_campaigns', $user_campaigns );

        }

        wp_send_json( array( 'status' => 'Done' ), 200 );
    }

    /**
     * Function for pausing campaign
     *
     */
    public function pause_campaign_func() {

        global $wpdb;
        $tablename    = $wpdb->prefix . 'scheduling_emails';

        $user         = wp_get_current_user();
        $campaign_id  = !empty( $_POST['campaign_id'] ) ? (int)$_POST['campaign_id'] : 0;

        $wpdb->update( $tablename,
            [ 'status' => 'paused' ],
            [ 'campaign_id' => $campaign_id, 'user_id' => $user->ID, 'status' => 'inprogress' ]
        );

        $user_campaigns = get_user_meta( $user->ID, 'user_campaigns', true );
        $user_campaigns = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();

        if ( ( !empty( $user_campaigns['paused'] ) && !array_key_exists( $campaign_id, $user_campaigns['paused'] ) ) || empty( $user_campaigns['paused'] ) ) {
            $user_campaigns['paused'][$campaign_id] = $campaign_id;
        }
        if ( ( !empty( $user_campaigns['active'] ) && array_key_exists( $campaign_id, $user_campaigns['active'] ) ) ) {
            unset( $user_campaigns['active'][$campaign_id] );
        }

        update_user_meta( $user->ID, 'user_campaigns', $user_campaigns );

        wp_send_json( array( 'status' => 'Done' ), 200 );
    }

    /**
     * Function for restoring campaign when it's paused: TODO
     *
     */
    public function restore_campaign_func() {

        global $wpdb;
        $tablename    = $wpdb->prefix . 'scheduling_emails';

        $user         = wp_get_current_user();
        $campaign_id  = !empty( $_POST['campaign_id'] ) ? (int)$_POST['campaign_id'] : 0;

        $wpdb->update( $tablename,
            [ 'status' => 'inprogress' ],
            [ 'campaign_id' => $campaign_id, 'user_id' => $user->ID, 'status' => 'paused' ]
        );

        $user_campaigns = get_user_meta( $user->ID, 'user_campaigns', true );
        $user_campaigns = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();

        if ( ( !empty( $user_campaigns['active'] ) && !array_key_exists( $campaign_id, $user_campaigns['active'] ) ) || empty( $user_campaigns['active'] ) ) {
            $user_campaigns['active'][$campaign_id] = $campaign_id;
        }
        if ( ( !empty( $user_campaigns['paused'] ) && array_key_exists( $campaign_id, $user_campaigns['paused'] ) ) ) {
            unset( $user_campaigns['paused'][$campaign_id] );
        }

        update_user_meta( $user->ID, 'user_campaigns', $user_campaigns );

        wp_send_json( array( 'status' => 'Done' ), 200 );

    }

    /**
     * Function for stopping campaign
     *
     */
    public function stop_campaign_func() {

        global $wpdb;
        $tablename    = $wpdb->prefix . 'scheduling_emails';

        $user         = wp_get_current_user();
        $campaign_id  = !empty( $_POST['campaign_id'] ) ? (int)$_POST['campaign_id'] : 0;

        $wpdb->update( $tablename,
            [ 'status' => 'stopped' ],
            [ 'campaign_id' => $campaign_id, 'user_id' => $user->ID, 'status' => 'inprogress' ]
        );

        $wpdb->update( $tablename,
            [ 'status' => 'stopped' ],
            [ 'campaign_id' => $campaign_id, 'user_id' => $user->ID, 'status' => 'paused' ]
        );

        $user_campaigns = get_user_meta( $user->ID, 'user_campaigns', true );
        $user_campaigns = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();

        if ( ( !empty( $user_campaigns['stopped'] ) && !array_key_exists( $campaign_id, $user_campaigns['stopped'] ) ) || empty( $user_campaigns['stopped'] ) ) {
            $user_campaigns['stopped'][$campaign_id] = $campaign_id;
        }
        if ( ( !empty( $user_campaigns['active'] ) && array_key_exists( $campaign_id, $user_campaigns['active'] ) ) ) {
            unset( $user_campaigns['active'][$campaign_id] );
        }
        if ( ( !empty( $user_campaigns['paused'] ) && array_key_exists( $campaign_id, $user_campaigns['paused'] ) ) ) {
            unset( $user_campaigns['paused'][$campaign_id] );
        }

        update_user_meta( $user->ID, 'user_campaigns', $user_campaigns );

        wp_send_json( array( 'status' => 'Done' ), 200 );
    }

    /**
     * Function callback of editing scheduling email
     *
     *
     */
    public function edit_scheduling_campaign() {
        $post = $_POST;
        parse_str( $post['data'], $params );

        $draft_count = ( empty( $post['draft'] ) ) ?  false : $post['draft'];

        $campaign_id      = $params['campaign_id'];
        $campaign_group   = $params['campaign_group'];

        $user             = wp_get_current_user();

        $count_using_lead = get_field( 'count_of_using', $campaign_group );
        if ( !empty( $params['was_draft'] ) ) {
            $count_using_lead = empty($count_using_lead) ? 1 : ((int)$count_using_lead + 1);
        }

        $users_from_list = UsersLists::get_lead_emails_by_list_id( $campaign_group );
        $users_from_list = array_values( $users_from_list );

        $count_users     = count( $users_from_list );

        $emails      = get_field( 'emails', $campaign_id );
        $count       = count( $emails );

        if ( !empty( $emails ) ) {

            for ( $i = 0; $i <= $count; $i++ ) {

                $date        = $params['date' . $i];
                $type        = $params['type' . $i];
                $custom_link = $params['custom_link' . $i];
                $custom_personal_token = $params['custom_personal_token' . $i];
                $custom_article_token  = $params['custom_article_token' . $i];
                $bcc_emails_list       = $params['bcc_emails_list'];
                $email_id              = (int)$params['edited_id' . $i];
                $email_body            = !empty( $params['custom_edited_content'.$i] ) ? $params['custom_edited_content'.$i]  : "";
                $email_body            = stripslashes ( $email_body );
                $was_draft             = ( ( !empty( $params['was_draft'] ) ) && empty( $draft_count ) )  ? "inprogress" : "";
                $status                = ( $date == 'canceled' ) ? 'canceled' : 'inprogress';

                $start_date[] = $date;

                $get_email_data         = $this->get_scheduling_email_status( $email_id );
                $status_check           = $get_email_data['status'];
                $email_subject_original = $get_email_data['email_subject'];

                $email_subject_new = ( !empty( $params['email_subject'.$i] ) && ( $params['email_subject'.$i] != $email_subject_original ) ) ? $params['email_subject'.$i] : '';
                $email_subject_new = ( $params['email_subject'.$i] == $email_subject_original ) ? '' : $email_subject_new;

                if ( !empty( $email_id ) && ( ( $status_check == 'inprogress' ) || ( $status_check == 'draft' ) || ( $status_check == 'paused' ) ) ) {
                    $this->update_scheduling_email_date( $email_id, $date, $custom_link, $email_body, $email_subject_new, $custom_personal_token, $custom_article_token, $bcc_emails_list, $campaign_group, $count_users, $was_draft, $status );
                }

            }

            /** Update usermeta user campaigns */
            if ( !empty( $params['was_draft'] ) && empty( $draft_count ) ) {

                $user_campaigns = get_user_meta( $user->ID, 'user_campaigns', true );
                $user_campaigns = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();

                if ( ( !empty( $user_campaigns['active'] ) && !array_key_exists( $campaign_id, $user_campaigns['active'] ) ) || empty( $user_campaigns['active'] ) ) {
                    $user_campaigns['active'][$campaign_id] = min( $start_date );
                }
                if ( !empty( $user_campaigns['draft'] ) && array_key_exists( $campaign_id, $user_campaigns['draft'] ) ) {
                    unset( $user_campaigns['draft'][$campaign_id] );
                }

                update_user_meta( $user->ID, 'user_campaigns', $user_campaigns );
                update_field( 'count_of_using', $count_using_lead, $campaign_group );

            }

            wp_send_json( array( 'status' => 'Done' ), 200 );
        }
    }

    /**
     * Function callback of editing draft scheduling email
     *
     *
     */
    public function edit_draft_scheduling_campaign() {
        $post = $_POST;
        parse_str( $post['data'], $params );

        $draft_count = ( empty( $post['draft'] ) ) ?  false : $post['draft'];

        $campaign_id      = $params['campaign_id'];
        $campaign_group   = $params['campaign_group'];

        $user             = wp_get_current_user();

        $count_using_lead = get_field( 'count_of_using', $campaign_group );
        if ( !empty( $params['was_draft'] ) ) {
            $count_using_lead = empty($count_using_lead) ? 1 : ((int)$count_using_lead + 1);
        }

        $users_from_list = UsersLists::get_lead_emails_by_list_id( $campaign_group );
        $users_from_list = array_values( $users_from_list );

        $count_users     = count( $users_from_list );

        $emails      = get_field( 'emails', $campaign_id );
        $count       = count( $emails );

        if ( !empty( $emails ) ) {

            for ( $i = 0; $i <= $count; $i++ ) {

                $date        = $params['date' . $i];
                $type        = $params['type' . $i];
                $custom_link = $params['custom_link' . $i];
                $custom_personal_token = $params['custom_personal_token' . $i];
                $custom_article_token  = $params['custom_article_token' . $i];
                $bcc_emails_list       = $params['bcc_emails_list'];
                $email_id              = (int)$params['edited_id' . $i];
                $email_body            = !empty( $params['custom_edited_content'.$i] ) ? $params['custom_edited_content'.$i]  : "";
                $email_body            = stripslashes ( $email_body );
                $status                = ( $date == 'canceled' ) ? 'canceled' : 'draft';

                $start_date[] = $date;

                $get_email_data         = $this->get_scheduling_email_status( $email_id );
                $email_subject_original = $get_email_data['email_subject'];

                $email_subject_new = ( !empty( $params['email_subject'.$i] ) && ( ( $params['email_subject'.$i] ) != $email_subject_original ) ) ? $params['email_subject'.$i] : '';
                $email_subject_new = ( ( $params['email_subject'.$i] ) == $email_subject_original ) ? '' : $email_subject_new;

                $this->update_scheduling_email_date( $email_id, $date, $custom_link, $email_body, $email_subject_new, $custom_personal_token, $custom_article_token, $bcc_emails_list, $campaign_group, $count_users, false, $status );

            }

            wp_send_json( array( 'status' => 'Done' ), 200 );
        }
    }

    /**
     * Function inserting scheduling emails
     *
     * @param $campaign_id
     * @param $email_subject
     * @param $email_subject_new
     * @param $email_body
     * @param $custom_link
     * @param $custom_personal_token
     * @param $custom_article_token
     * @param $bcc_emails_list
     * @param $users_group
     * @param $date
     * @param $count_users
     * @param bool $status
     *
     **/
    private function insert_scheduling_emails( $campaign_id, $email_subject, $email_subject_new, $email_body, $custom_link, $custom_personal_token, $custom_article_token, $bcc_emails_list, $users_group, $date, $count_users, $status = false ) {

        global $wpdb;
        $tablename = $wpdb->prefix . 'scheduling_emails';
        $user      = wp_get_current_user();

        $status    = empty( $status ) ? ( $date == 'canceled' ) ? 'canceled' : 'inprogress' : $status ;

        $old_date  = strtotime( $date );
        $new_date  = date('Y-m-d H:i:s', $old_date );

        $wpdb->insert( $tablename, array (
                'campaign_id'       => $campaign_id,
                'user_id'           => $user->ID,
                'email_subject'     => $email_subject,
                'email_subject_new' => $email_subject_new,
                'email_body'        => $email_body,
                'custom_link'       => $custom_link,
                'custom_personal_token' => $custom_personal_token,
                'custom_article_token'  => $custom_article_token,
                'bcc_emails_list'   => $bcc_emails_list,
                'user_list'         => $users_group,
                'sending_time'      => $new_date,
                'count_get_users'   => $count_users,
                'status'            => $status,
            )
        );

    }

    /**
     * Function getting statistics data for campaign
     *
     * @param $campaign_id
     * @param $date_count
     *
     * @return mixed
     */
    public function get_statistic_by_campaign( $campaign_id, $date_count = 'all' ) {
        global $wpdb;
        $user        = wp_get_current_user();
        $user_id     = $user->ID;
        $tablename   = $wpdb->prefix . 'scheduling_emails';
        $tablename1  = $wpdb->prefix . 'tracking_system_scheduling_emails';

        $user_list_data = $this->get_userlist_statistics_by_params( $tablename, $user_id, $campaign_id );
        $user_list                     = $user_list_data['user_list'];
        $count_total_users             = $user_list_data['count_total_users'];
        $unsubscribed_contacts_by_list = $user_list_data['unsubscribed_contacts_by_list'] ;

        $additional_sql = '';
        if ( $date_count != 'all' ) {
            $additional_sql =  " AND ( DATEDIFF( CURRENT_DATE(), t.sending_time) ) <= $date_count  AND ( DATEDIFF( CURRENT_DATE(), t.sending_time) ) >= 0";
        }

        if ( $this->tracking_table == 'scheduling_campaigns' ) {
            $sql = "SELECT t.count_get_users, t.statistics, t.status FROM $tablename t WHERE t.user_id=$user_id AND t.campaign_id=$campaign_id $additional_sql"; // current logic
        }
        else {
            $sql = "
               SELECT t.count_get_users, t1.statistics as 'statistics', t.statistics as 'statistics_original', t.status 
               FROM $tablename t
               lEFT JOIN $tablename1 t1
               ON t.id = t1.email_id
               WHERE t.user_id=$user_id AND t.campaign_id=$campaign_id $additional_sql
           "; // TODO with tracking table

        }

        $results  = $wpdb->get_results( $sql, ARRAY_A );

        $response          = array();
        $opened_statistic  = array();
        $clicked_statistic = array();
        $sent_statistic    = array();

        $opened_statistic_percent  = 0;
        $clicked_statistic_percent = 0;
        $sent_statistic_percent    = 0;
        $unsubscribers_count       = 0;

        $count_emails             = count( $results );
        $response['count_emails'] = $count_emails;

        $i = 0;
        $count_receivers  = 0;
        $count_opened     = 0;
        $count_delivered  = 0;
        $count_clicked    = 0;
        $count_unsubscribers = 0;
        $statistics_array = array();

        if ( !empty( $results ) ) {
            foreach ( $results as $result ) {

                /* Give statistic only for sent campaigns
                if ( $result['status'] != 'sent' ) {
                    continue;
                }
                */

                $i++;

                $statistics      = json_decode( $result['statistics'], true );
                $count_users     = $result['count_get_users'];
                $count_receivers += $count_users;

                $count_opened_email  = !empty( $statistics['opened'] )  ? count( $statistics['opened'] ) : 0;
                $count_clicked_email = !empty( $statistics['clicked'] ) ? count( $statistics['clicked'] ) : 0;
                $count_sent_email    = !empty( $statistics['sent'] )    ? count( $statistics['sent'] ) : 0;
                $count_unsubscribed_email  = !empty( $statistics['unsubscribed'] ) ? count( $statistics['unsubscribed'] ) : 0;

                $opened_statistic_percent  =  !empty( $count_users ) ? ( $count_opened_email * 100 ) / $count_users : 0;
                $clicked_statistic_percent =  !empty( $count_users ) ? ( $count_clicked_email * 100 ) / $count_users : 0;
                $sent_statistic_percent    =  !empty( $count_users )  ? ( $count_sent_email * 100 ) / $count_users : 0;
                $unsubscribe_statistic_percent = !empty( $count_users )  ? ( $count_unsubscribed_email * 100 ) / $count_users : 0;

                $statistics_array['opened'][]  = $opened_statistic_percent;
                $statistics_array['clicked'][] = $clicked_statistic_percent;
                $statistics_array['sent'][]    = $sent_statistic_percent;
                $statistics_array['unsubscribers_percent'][] = $unsubscribe_statistic_percent;

                $count_opened    += $count_opened_email;
                $count_delivered += $count_sent_email;
                $count_clicked   += $count_clicked_email;
                $count_unsubscribers += $count_unsubscribed_email;

            }
        }

        $response['user_list'] = $user_list;
        $response['user_list_unsubscribers_count'] = $user_list;
        $response['unsubscribed_contacts_by_list'] = $unsubscribed_contacts_by_list;

        $response['count_sentstatus_emails'] = $i;
        $response['count_all_receivers']     = $count_receivers;
        $response['count_all_contacts']      = $count_total_users;
        $response['statistics_array']        = $statistics_array;

        $opened_statistic_percent  = empty( $statistics_array['opened'] ) ? 0 : ( array_sum( $statistics_array['opened'] ) ) / count( $statistics_array['opened'] );
        $clicked_statistic_percent = empty( $statistics_array['clicked'] ) ? 0 : ( array_sum( $statistics_array['clicked'] ) ) / count( $statistics_array['clicked'] );
        $sent_statistic_percent    = empty( $statistics_array['sent'] )  ? 0 : ( array_sum( $statistics_array['sent'] ) ) / count( $statistics_array['sent'] );
        $unsubscribed_statistic_percent = empty( $statistics_array['unsubscribers_percent'] )  ? 0 : ( array_sum( $statistics_array['unsubscribers_percent'] ) ) / count( $statistics_array['unsubscribers_percent'] );

        $response['opened']        = round( $opened_statistic_percent,  2 );
        $response['sent']          = round( $sent_statistic_percent,    2 );
        $response['clicked']       = round( $clicked_statistic_percent, 2 );
        $response['unsubscribers_percent'] = round( $unsubscribed_statistic_percent, 2 );
        $response['count_clicked'] = $count_clicked;
        $response['count_sent']    = $count_delivered;
        $response['count_opened']  = $count_opened;
        $response['unsubscribers_count'] = $count_unsubscribers;

        return $response;

    }


    /**
     * Function getting user list statistic for campaign report
     *
     * @param $tablename
     * @param $user_id
     * @param $campaign_id
     * @return array
     */
    private function get_userlist_statistics_by_params( $tablename, $user_id, $campaign_id ) {
        global  $wpdb;

        $result = array();
        /**
         *
         */
        $user_list  = $wpdb->get_row("SELECT user_list FROM $tablename WHERE user_id=$user_id AND campaign_id=$campaign_id", ARRAY_A );
        $user_list  = $user_list['user_list'];

        $users_from_list = UsersLists::get_leads_by_list_id( $user_list );
        $active_contacts_by_list = UsersLists::get_lead_emails_by_list_id( $user_list );
        $count_total_users       = !empty( count( $users_from_list ) ) ? count( $users_from_list ) : 0;
        $active_contacts_by_list = !empty( count( $active_contacts_by_list ) ) ? count( $active_contacts_by_list ) : 0;

        $unsubscribed_contacts_by_list = $count_total_users - $active_contacts_by_list;

//        $unsubscribers =  UsersLists::get_unsubscribers_from_list( $user_list );
//        $result['unsubscribers']     = $unsubscribers;

        $result['user_list']         = $user_list;
        $result['count_total_users'] = $count_total_users;
        $result['unsubscribed_contacts_by_list'] = $unsubscribed_contacts_by_list;

        return $result;

    }

    /**
     * Function getting all in progress scheduling emails
     *
     * @return array|object|null
     */
    private function get_inpogress_emails() {

        global $wpdb;
        $tablename = $wpdb->prefix . 'scheduling_emails';
        $results   = $wpdb->get_results("SELECT * FROM $tablename WHERE status='inprogress'", ARRAY_A );

        return $results;
    }

    /**
     * Function updating sent status
     *
     * @param $id
     * @param $status
     */
    private function update_sent_status( $id, $status ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'scheduling_emails';
        $wpdb->update( $table_name, array( 'status' => $status ),array( 'id' => $id ) );
    }

    /**
     * Function updating sent status
     *
     * @param $id
     * @param $email
     * @param $email_subject
     * @param $campaign_id
     * @param $user_db
     *
     */
    private function update_sent_ind_status( $id, $email, $email_subject, $campaign_id, $user_db ) {
        global $wpdb;

        $action = 'delivered';

        $table_name  = $wpdb->prefix . 'scheduling_emails'; // current logic
        $table_name1 = $wpdb->prefix . 'tracking_system_scheduling_emails'; // TODO with tracking system

        if ( $this->tracking_table == 'scheduling_campaigns' ) {
            $statistics = $this->get_action_status( $id, 'statistics' ); // current logic
        }
        else {
             $statistics = $this->get_tracking_statistic_by_email( $id ); // TODO with tracking system
        }

        $statistics = ( !empty( $statistics ) ) ? json_decode( $statistics, true ) : array();

        if (  ( !empty( $statistics['sent'] ) && !in_array( $email, $statistics['sent'] ) ) || empty( $statistics['sent'] ) ) {
            $statistics['sent'][] = $email;
        }

        /* Calculating user statistics for email - delivered */
        $campaign_users_statistics = get_user_meta( $user_db, 'campaign_users_statistics', true );
        $campaign_users_statistics = !empty( $campaign_users_statistics ) ? $campaign_users_statistics : array();

        if ( ( !in_array( ucfirst( $action ), $campaign_users_statistics[$campaign_id][$email][$email_subject] ) ) || empty( $campaign_users_statistics ) ) {
            $campaign_users_statistics[$campaign_id][$email][$email_subject][] = ucfirst( $action );
        }

        update_user_meta( $user_db, 'campaign_users_statistics', $campaign_users_statistics );
        /* */

        $statistics = json_encode( $statistics );

        if ( $this->tracking_table == 'scheduling_campaigns' ) {
            $wpdb->update( $table_name, array( 'statistics' => $statistics ), array( 'id' => $id ) ); // current logic
        }
        else {
            $this->tracking_statistic_insert_update( $id, $statistics ); // TODO with tracking system
        }

    }

    /**
     * Function updating sent status for few emails together
     *
     * @param $id
     * @param $users_from_list
     * @param $email_bodies
     * @param $email_subject
     * @param $campaign_id
     * @param $user_db
     *
     */
    private function update_sent_loop_status( $id, $users_from_list, $email_bodies, $email_subject, $campaign_id, $user_db ) {
        global $wpdb;

        $action = 'delivered';

        $table_name  = $wpdb->prefix . 'scheduling_emails';
        $table_name1 = $wpdb->prefix . 'tracking_system_scheduling_emails';

        if ( $this->tracking_table == 'scheduling_campaigns' ) {
            $statistics = $this->get_action_status( $id, 'statistics' ); // current logic
        }
        else {
            $statistics = $this->get_tracking_statistic_by_email( $id ); // TODO with tracking system
        }

        $statistics = ( !empty( $statistics ) ) ? json_decode( $statistics, true ) : array();

        /* Calculating user statistics for email - delivered */
        $campaign_users_statistics = get_user_meta( $user_db, 'campaign_users_statistics', true );
        $campaign_users_statistics = !empty( $campaign_users_statistics ) ? $campaign_users_statistics : array();

        if ( !empty( $users_from_list ) ) {
            foreach ( $users_from_list as $user ) {
                $user_email   = $user['email'];

                if (
                    empty( $email_bodies[$user_email]['is_verified'] )
                ) {
                    continue;
                }

                if (  ( !empty( $statistics['sent'] ) && !in_array( $user_email, $statistics['sent'] ) ) || empty( $statistics['sent'] ) ) {
                    $statistics['sent'][] = $user_email;
                }

                if ( ( !in_array( ucfirst( $action ), $campaign_users_statistics[$campaign_id][$user_email][$email_subject] ) ) || empty( $campaign_users_statistics ) ) {
                    $campaign_users_statistics[$campaign_id][$user_email][$email_subject][] = ucfirst( $action );
                }
            }
        }

        update_user_meta( $user_db, 'campaign_users_statistics', $campaign_users_statistics );
        /* */

        $statistics = json_encode( $statistics );

        if ( $this->tracking_table == 'scheduling_campaigns' ) {
            $wpdb->update( $table_name, array( 'statistics' => $statistics ), array( 'id' => $id ) ); // current logic
        }
        else {
            $this->tracking_statistic_insert_update( $id, $statistics ); // TODO with tracking system
        }

    }

    /**
     * Function updating sent status
     *
     * @param $id
     * @param $iteration
     *
     */
    private function update_email_iteration( $id, $iteration ) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'scheduling_emails';
        $wpdb->update( $table_name, array( 'sending_iteration' => $iteration ), array( 'id' => $id ) );
    }

    /**
     * Function updating action status for scheduling email id
     *
     * @param $id
     * @param $email
     * @param $action
     */
    public function update_api_action_status( $id, $email, $action ) {
        global $wpdb;
        $table_name  = $wpdb->prefix . 'scheduling_emails';
        $table_name1  = $wpdb->prefix . 'tracking_system_scheduling_emails';

        $email_data  = $this->get_email_data_by_id( $id );
        $email_title = !empty( $email_data['email_subject_new'] ) ? $email_data['email_subject_new'] : $email_data['email_subject'];
        $campaign_id = $email_data['campaign_id'];
        $user_id     = $email_data['user_id'];

        // Calculating user statistics for email - opening, clicking
        $campaign_users_statistics = get_user_meta( $user_id, 'campaign_users_statistics', true );
        $campaign_users_statistics = !empty( $campaign_users_statistics ) ? $campaign_users_statistics : array();

        if ( !in_array( ucfirst( $action ), $campaign_users_statistics[$campaign_id][$email][$email_title] ) ) {
            $campaign_users_statistics[$campaign_id][$email][$email_title][] = ucfirst( $action );
        }

        update_user_meta( $user_id, 'campaign_users_statistics', $campaign_users_statistics );

        if ( $this->tracking_table == 'scheduling_campaigns' ) {
            $statistics  = $this->get_action_status( $id, 'statistics' ); // with current table
        }
        else {
            $statistics  = $this->get_tracking_statistic_by_email( $id ); //TODO: with tracking table
        }

        $statistics  = ( !empty( $statistics ) ) ? json_decode( $statistics, true ) : array();

        if ( ( !empty( $statistics[$action] ) && !in_array( $email, $statistics[$action] ) ) || empty( $statistics[$action] ) ) {
            $statistics[$action][] = $email;
        }

        $statistics = json_encode( $statistics );

        if ( $this->tracking_table == 'scheduling_campaigns' ) {
            $wpdb->update( $table_name,  array( 'statistics' => $statistics ), array( 'id' => $id ) ); // with current table
        }
        else {
            $this->tracking_statistic_insert_update( $id, $statistics ); // TODO with tracking system
        }

    }

    /**
     * Function unsubscribing email from lead list by id of campaign
     * ( id = id of email )
     *
     * @param $id
     * @param $email
     * @param $campaign_id
     *
     */
    public function unsubscribe_email_from_user_list( $id, $email, $campaign_id ) {
        global $wpdb;

        $table_name  = $wpdb->prefix . 'lead_lists';
        $action      = 'Unsubscribed';

        $email_data  = $this->get_email_data_by_id( $id );
        $email_title = !empty( $email_data['email_subject_new'] ) ? $email_data['email_subject_new'] : $email_data['email_subject'];
        $user_id     = $email_data['user_id'];
        $user_list   = $email_data['user_list'];

        $wpdb->update( $table_name, array( 'status' => 'unsubscribed' ), array( 'id_list' => $user_list, 'email' => $email ) );

        // Calculating user statistics for email - opening, clicking
        $campaign_users_statistics = get_user_meta( $user_id, 'campaign_users_statistics', true );
        $campaign_users_statistics = !empty( $campaign_users_statistics ) ? $campaign_users_statistics : array();

        $campaign_unsubscribers = $campaign_users_statistics[$campaign_id]['unsubscribers'];
        $user_unsubscribers     = $campaign_users_statistics['unsubscribers'];

        if ( ( !empty( $campaign_unsubscribers ) && !in_array( $email, $campaign_unsubscribers ) ) || ( empty( $campaign_unsubscribers ) ) ) {
            $campaign_users_statistics[$campaign_id]['unsubscribers'][] = $email;
        }

        if ( ( !empty( $user_unsubscribers ) && !in_array( $email, $user_unsubscribers ) ) || ( empty( $user_unsubscribers ) ) ) {
            $campaign_users_statistics['unsubscribers'][] = $email;
        }

        if ( !in_array( $action, $campaign_users_statistics[$campaign_id][$email][$email_title] ) ) {
            $campaign_users_statistics[$campaign_id][$email][$email_title][] = $action;
        }

        update_user_meta( $user_id, 'campaign_users_statistics', $campaign_users_statistics );

        $this->update_subscribed_count_users_by_group_id( $user_list, $campaign_id );
    }

    /**
     * Function getting action status for scheduling email id
     *
     * @param $id
     * @param $action
     * @return mixed
     */
    private function get_action_status( $id, $action ) {
        global $wpdb;

        $tablename = $wpdb->prefix . 'scheduling_emails';
        $result    = $wpdb->get_row("SELECT $action FROM $tablename WHERE id=$id", ARRAY_A );

        return $result[$action] ;
    }

    /**
     * Function getting tracking statistic for scheduling email id
     *
     * @param $id
     * @param $action
     * @return mixed
     */
    private function get_tracking_statistic_by_email( $id ) {
        global $wpdb;

        $tablename = $wpdb->prefix . 'tracking_system_scheduling_emails';
        $result    = $wpdb->get_row("SELECT statistics  FROM $tablename WHERE email_id=$id", ARRAY_A );

        return $result['statistics'] ;
    }


    /**
     * Function helper: checking if email id statistic is already exists in tracking system
     *
     * @param $email_id
     * @param $statistics
     *
     * @return bool
     */
    private function tracking_statistic_insert_update( $email_id, $statistics ) {

        global $wpdb;

        $tablename   = $wpdb->prefix . 'tracking_system_scheduling_emails';
        $results     = $wpdb->get_row("SELECT count('id') as 'count' FROM $tablename WHERE email_id=$email_id", ARRAY_A );

        $count       = (int)$results['count'];
        if ( $count > 0 ) {
            $wpdb->update( $tablename, array( 'statistics' => $statistics ), array( 'email_id' => $email_id ) ); //TODO: with tracking table
        }
        else {
            $wpdb->insert( $tablename, array( 'statistics' => $statistics, 'email_id' => $email_id ) ); //TODO: with tracking table
        }

        return true;
    }


    /**
     * Function getting
     *
     * @param $id
     * @return mixed
     */
    private function get_email_data_by_id( $id ) {
        global $wpdb;

        $tablename = $wpdb->prefix . 'scheduling_emails';
        $result    = $wpdb->get_row("SELECT email_subject, email_subject_new, campaign_id, user_list, user_id FROM $tablename WHERE id=$id", ARRAY_A );

        return $result;
    }

    /**
     * Function getting statistics
     *
     * @param $count_per_page
     * @param string $date_count
     * @return array
     */
    public function get_general_statistic( $count_per_page, $date_count = 'all' ) {

        $user          = wp_get_current_user();
//        $all_campaigns = $this->get_campaigns( $count_per_page );
        $all_campaigns = $this->get_user_campaigns( -1 );
        $response      = array();

        $opened_gen_percent  = 0;
        $sent_gen_percent    = 0;
        $clicked_gen_percent = 0;
        $unsubscribers_gen_percent = 0;

        if ( !empty( $all_campaigns ) ) {
            $count_general = 0;

            $user_campaigns = get_user_meta( $user->ID, 'user_campaigns', true );
            $user_campaigns = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();

            $count_receivers  = 0;
            $count_opened     = 0;
            $count_sent       = 0;
            $count_scheduled_emails = 0;
            $count_clicked    = 0;
            $count_sentstatus_emails = 0;
            $unsubscribers_count = 0;

            foreach ( $all_campaigns as $campaign ) {

                if (
                    ( !empty( $user_campaigns['active'] ) && array_key_exists( $campaign, $user_campaigns['active'] ) )
                    ||
                    ( !empty( $user_campaigns['finished'] ) && array_key_exists( $campaign, $user_campaigns['finished'] ) ) ) {
                    $count_general  += 1;
                    $all_percent     = $this->get_statistic_by_campaign( $campaign, $date_count );

                    $count_receivers += (int)$all_percent['count_all_receivers'];
                    $count_sent      += (int)$all_percent['count_sent'];
                    $count_sentstatus_emails += (int)$all_percent['count_sentstatus_emails'];
                    $count_scheduled_emails  += (int)$all_percent['count_emails'];
                    $unsubscribers_count     += (int)$all_percent['unsubscribers_count'];
                    $count_opened    += (int)$all_percent['count_opened'];
                    $count_clicked   += (int)$all_percent['count_clicked'];
                    $sent_percent    = ( empty( $all_percent ) || is_nan( $all_percent['sent'] ) )    ? 0 : $all_percent['sent'];
                    $clicked_percent = ( empty( $all_percent ) || is_nan( $all_percent['clicked'] ) ) ? 0 : $all_percent['clicked'];
                    $opened_percent  = ( empty( $all_percent ) || is_nan( $all_percent['opened'] ) )  ? 0 : $all_percent['opened'];
                    $unsubscribed_percent = ( empty( $all_percent ) || is_nan( $all_percent['unsubscribers_percent'] ) )  ? 0 : $all_percent['unsubscribers_percent'];

                    $opened_gen_percent   += $opened_percent;
                    $sent_gen_percent     += $sent_percent;
                    $clicked_gen_percent  += $clicked_percent;
                    $unsubscribers_gen_percent += $unsubscribed_percent;
                }
            }

            if ( !empty( $count_general ) ) {
                $opened_gen_percent  = $opened_gen_percent / $count_general;
                $sent_gen_percent    = $sent_gen_percent / $count_general;
                $clicked_gen_percent = $clicked_gen_percent / $count_general;
                $unsubscribers_gen_percent = $unsubscribers_gen_percent / $count_general;
            }
            else {
                $opened_gen_percent  = 0;
                $sent_gen_percent    = 0;
                $clicked_gen_percent = 0;
            }

            $opened_gen_percent  = round( $opened_gen_percent, 2 );
            $clicked_gen_percent = round( $clicked_gen_percent, 2 );
            $sent_gen_percent    = round( $sent_gen_percent, 2 );
            $unsubscribers_gen_percent = round( $unsubscribers_gen_percent, 2 );

        }

        $response['sent']    = $sent_gen_percent;
        $response['opened']  = $opened_gen_percent;
        $response['clicked'] = $clicked_gen_percent;
        $response['unsubscribers_percent'] = $unsubscribers_gen_percent;
        $response['unsubscribers_count']   = $unsubscribers_count;

        $response['count_sentstatus_emails'] = $count_sentstatus_emails;
        $response['count_all_receivers'] = $count_receivers;
        $response['count_sent']          = $count_sent;
        $response['count_opened']        = $count_opened;
        $response['count_clicked']       = $count_clicked;
        $response['count_scheduled_emails']  = $count_scheduled_emails;

        return $response;

    }

    /**
     * Function filtering statistic by date
     *
     */
    public function filtering_statistic_by_date() {
        $post     = $_POST;
        $response = array();

        $date_count  = sanitize_text_field( $post['val'] );
        $campaign_id = (int)sanitize_text_field( $post['single'] );
        $count_page  = 20;

        if ( $date_count == 'all_time' ) {
            $str_str = 'all';
        }
        else {
            $str_str = (int)( $date_count );
        }

        if ( !empty( $campaign_id ) ) {
            $statistic = $this->get_statistic_by_campaign( $campaign_id, $str_str );
        }
        else {
            $statistic  = $this->get_general_statistic( $count_page, $str_str );
        }

        wp_send_json( array( 'response' => $statistic, 'status' => 'Done' ), 200 );
    }

    /**
     * Function getting scheduling email's data by params
     *
     * @param $campaign_id
     * @param $user_id
     * @param $email_subject
     *
     * @return mixed
     */
    public function get_scheduling_email_data( $campaign_id, $user_id, $email_subject ) {
        global $wpdb;

        $tablename = $wpdb->prefix . 'scheduling_emails';
        $sql       = "SELECT * FROM $tablename WHERE campaign_id = $campaign_id and user_id = $user_id";
        $sql       = !empty( $email_subject ) ? $sql . " and email_subject='$email_subject'" : $sql;

        if ( !empty( $email_subject ) ) {
            $result = $wpdb->get_row( $sql, ARRAY_A );
        }
        else {
            $result = $wpdb->get_results( $sql, ARRAY_A );
        }

        return $result;
    }

    /**
     * Function getting scheduling campaign list for campaigns
     *
     * @param $campaign_id
     * @param $user_id
     * @param $email_subject
     *
     * @return mixed
     */
    public function get_scheduling_campaign_list( $campaign_id, $user_id ) {
        global $wpdb;

        $tablename = $wpdb->prefix . 'scheduling_emails';
        $inprogress_status_sql = " and status='inprogress'";
//        $sent_status_sql       = " and ( ( status='sent' ) or ( status='paused' ) or ( status='stopped' ) )";
        $sent_status_sql       = " and  status <>'inprogress'";
        $order_by_sql          =  " order by sending_time DESC";

        $sql1   = "SELECT * FROM $tablename WHERE campaign_id = $campaign_id and user_id = $user_id $inprogress_status_sql $order_by_sql";
        $sql2   = "SELECT * FROM $tablename WHERE campaign_id = $campaign_id and user_id = $user_id $sent_status_sql $order_by_sql";

        $result = $wpdb->get_row( $sql1, ARRAY_A );
        $result = ( !empty( $result ) ) ? $result : $wpdb->get_row( $sql2, ARRAY_A );

        return $result;
    }

    /**
     * Function getting scheduling email's data by params
     *
     * @param $email_id
     * @return mixed
     */
    public function get_scheduling_email_status( $email_id ) {
        global $wpdb;

        $tablename = $wpdb->prefix . 'scheduling_emails';
        $sql       = "SELECT status, email_subject, email_subject_new FROM $tablename WHERE id = $email_id";

        $result    = $wpdb->get_results( $sql, ARRAY_A );

        return $result[0];
    }

    /**
     * Function callback of canceling scheduling email
     *
     */
    public function canceling_scheduling_email( ) {
        $id       = $_POST['id'];
        $id       = empty( $id ) ? 0 : (int)$id;

        $this->update_sent_status( $id, 'canceled' );
        wp_send_json( array( 'status' => 'Done' ), 200 );
    }

    /**
     * Function changing scheduling email data by id
     *
     * @param $email_id
     * @param $date
     * @param $custom_link
     * @param $email_body
     * @param $email_subject_new
     * @param $custom_personal_token
     * @param $custom_article_token
     * @param $bcc_emails_list
     * @param $campaign_id
     * @param $count_users
     * @param $was_draft
     * @param $status
     *
     * @return bool
     */
    private function update_scheduling_email_date( $email_id, $date, $custom_link, $email_body, $email_subject_new, $custom_personal_token, $custom_article_token, $bcc_emails_list, $campaign_id, $count_users, $was_draft = false, $status = false ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'scheduling_emails';

        $old_date   = strtotime( $date );
        $new_date   = date('Y-m-d H:i:s', $old_date );

        $add_array  = array();
        $args       = array (
            'sending_time'      => $new_date,
            'custom_link'       => $custom_link,
            'email_body'        => $email_body,
            'email_subject_new' => $email_subject_new,
            'custom_personal_token' => $custom_personal_token,
            'custom_article_token'  => $custom_article_token,
            'bcc_emails_list'   => $bcc_emails_list,
            'user_list'         => $campaign_id,
            'count_get_users'   => $count_users
        );


        if ( !empty( $was_draft ) ) {
            $add_array = array(
               'status' => 'inprogress'
            );

            $args = array_merge( $args, $add_array );
        }

        if ( !empty( $status ) ) {
            $add_array = array(
                'status' => $status
            );

            $args = array_merge( $args, $add_array );
        }

        $wpdb->update( $table_name,
            $args,
            array (
                'id' => $email_id
            ) );

        return true;

    }


    /**
     * Function callback for exporting campaign list
     *
     */
    public function export_campaign_list_func() {
        $post = $_POST;
        $campaign_id  = $post['id'];
        $user         = wp_get_current_user();

        $campaign_users_statistics = get_user_meta( $user->ID, 'campaign_users_statistics', true );
        $campaign_users_statistics = !empty( $campaign_users_statistics ) ? $campaign_users_statistics[$campaign_id] : array();

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 2;

        $objPHPExcel->getActiveSheet()->SetCellValue( 'A1', 'First Name' );
        $objPHPExcel->getActiveSheet()->SetCellValue( 'B1', 'Last Name' );
        $objPHPExcel->getActiveSheet()->SetCellValue( 'C1', 'Email' );
        $objPHPExcel->getActiveSheet()->SetCellValue( 'D1', 'Status' );

        if ( !empty( $campaign_users_statistics ) ) {
            foreach ( $campaign_users_statistics as $campaign_user => $statistic ) {
                $result = '';
                foreach ( $statistic as $email => $data ) {
                    $tags    = implode(', ', $data );
                    $result .= " $email : $tags |";
                }
                $result = substr( $result, 0, -1 );
                $user_for_email = UsersLists::get_username_for_email( $campaign_id, $user->ID, $campaign_user );

                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $user_for_email['name'] );
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $user_for_email['last_name'] );
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $campaign_user );
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $result );
                $rowCount++;
            }
        }


        $objWriter = new \PHPExcel_Writer_Excel2007( $objPHPExcel );
        ob_start();
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();

        wp_send_json( array( 'status' => 'Exported', 'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData) ), 200 );
    }

    /**
     * Function helper for updating unsubscribed users for group if for scheduling emails
     * for good calculating of statistics
     *
     * @param $id
     * @param $campaign_id
     */
    private function update_subscribed_count_users_by_group_id( $id, $campaign_id ) {
        global $wpdb;
        $users_from_list = UsersLists::get_lead_emails_by_list_id( $id );
        $count_users     = !empty( count( $users_from_list ) ) ? count( $users_from_list ) : 0;
        $table_name      = $wpdb->prefix . 'scheduling_emails';

        $wpdb->update( $table_name, array( 'count_get_users' => $count_users ), array( 'user_list' => $id, 'status' => 'inprogress' ) );
        $wpdb->update( $table_name, array( 'count_get_users' => $count_users ), array( 'user_list' => $id, 'status' => 'paused' ) );

//        $wpdb->update( $table_name, array( 'count_get_users' => $count_users ), array( 'user_list' => $id, 'campaign_id' => $campaign_id, 'status' => 'inprogress' ) );
//        $wpdb->update( $table_name, array( 'count_get_users' => $count_users ), array( 'user_list' => $id, 'campaign_id' => $campaign_id, 'status' => 'paused' ) );

    }

    /**
     * Function helper for updating unsubscribed users for group if for scheduling emails
     * for good calculating of statistics
     *
     * @param $id
     * @param $count
     */
    public function update_lead_list_count( $id ) {
        global $wpdb;
        $users_from_list = UsersLists::get_lead_emails_by_list_id( $id );
        $count_users     = !empty( count( $users_from_list ) ) ? count( $users_from_list ) : 0;
        $table_name      = $wpdb->prefix . 'scheduling_emails';

        $wpdb->update( $table_name, array( 'count_get_users' => $count_users ), array( 'user_list' => $id, 'status' => 'inprogress' ) );
        $wpdb->update( $table_name, array( 'count_get_users' => $count_users ), array( 'user_list' => $id, 'status' => 'paused' ) );

    }


    /**
     * Function getting all active emails for campaign id
     *
     * @param $campaign_id
     * @param $user_id
     * @return mixed
     */
    private function get_active_emails( $campaign_id, $user_id ) {
        global $wpdb;
        $tablename   = $wpdb->prefix . 'scheduling_emails';
        $results     = $wpdb->get_results("SELECT count('id') as 'count' FROM $tablename WHERE user_id=$user_id AND campaign_id=$campaign_id AND status='inprogress'", ARRAY_A );

        return $results[0]['count'];
    }

    /**
     * Function creating scheduling emails table
     *
     */
    public static function creating_scheduling_emails_table() {

        global $wpdb;
        $table_name      = $wpdb->prefix . 'scheduling_emails';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(9) NOT NULL AUTO_INCREMENT,
            campaign_id INT(9) NULL,
            user_id INT(9) NULL,
            email_subject VARCHAR(800) NULL,
            email_subject_new VARCHAR(800) NULL,
            email_body TEXT NULL,
            custom_link TEXT NULL, 
            custom_personal_token TEXT NULL, 
            custom_article_token TEXT NULL, 
            bcc_emails_list TEXT NULL, 
            user_list INT(9) NULL,
            status VARCHAR(100) DEFAULT 'inprogress',
            statistics TEXT,
            sending_iteration INT(9) NULL,
            count_get_users INT(9) NULL,
            sending_time TIMESTAMP NULL,
            PRIMARY KEY(id)
	    ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

    /**
     * Function creating tracking system table for scheduling emails
     *
     */
    public static function creating_tracking_scheduling_emails_table() {

        global $wpdb;
        $table_name      = $wpdb->prefix . 'tracking_system_scheduling_emails';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(9) NOT NULL AUTO_INCREMENT,
            email_id INT(9) NULL,
            statistics TEXT,
            PRIMARY KEY(id)
	    ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

    /**
     * Function getting campaigns
     *
     * @param $count
     * @param null $campaign_type
     * @return int[]|\WP_Post[]
     */
    public function get_campaigns( $count, $campaign_type = NULL ) {

        $user = wp_get_current_user();
        $query = array (
            'post_type'      => 'campaigns',
            'fields'         => 'ids',
            'posts_per_page' => $count
        );

        $category_in = ( !empty( $campaign_type ) && ( $campaign_type == 'cloned' ) ) ? 'IN' : 'NOT IN';
        $add_author  = ( !empty( $campaign_type ) && ( $campaign_type == 'cloned' ) ) ? array( 'author' => $user->ID ) : array();

        $add_array = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'campaigns-category',
                    'field'    => 'slug',
                    'terms'    => array( 'cloned' ),
                    'operator' => $category_in,
                ),
            ),
        );
        $query = array_merge( $query, $add_array, $add_author );

        $campaigns  = new \WP_Query( $query );
        $campaigns  = $campaigns->posts;

        return $campaigns;

    }

    /**
     * Function getting user's campaigns
     *

     * @return int[]|\WP_Post[]
     */
    public function get_user_campaigns( $count  ) {

        $result = array();
        $user = wp_get_current_user();
        $user_id = !empty( $user ) ? $user->ID : 0 ;

        global $wpdb;
        $tablename = $wpdb->prefix . 'scheduling_emails';
        $sql       = "SELECT DISTINCT( campaign_id ) as 'campaign_id'  FROM $tablename WHERE user_id = $user_id ORDER BY `id` DESC";

        $result    = $wpdb->get_results( $sql, ARRAY_A );
        $result    = !empty( $result ) ? array_column( $result, 'campaign_id' ) : array();

        if ( $count != '-1' ) {
            $result    = array_chunk( $result, $count );
            $result    = $result[0];
        }

        return $result;

    }

    /**
     * Export edited content data
     *
     */
    public function export_edited_campaign_data() {
        $post    = $_POST;
        $user    = wp_get_current_user();
        $user_id = $user->ID;
        $campaign_id = $post['campaign_id'];

        $campaign_data = $this->get_scheduling_email_data( $campaign_id, $user->ID, false );

        $pdf_object = new Pdf();
        $pdf_object->pdf_save_file( $campaign_data, $campaign_id, $user_id );
    }


    /**
     * Function of cloning campaign
     *
     */
    public function clone_campaign_function() {
        $post_id = !empty( $_POST['campaign_id'] ) ? intval( $_POST['campaign_id'] ) : 0;

        global $wpdb;

        $suffix      = '-Clone';
        $post        = get_post( $post_id );

        $current_user    = wp_get_current_user();
        $new_post_author = $current_user->ID;

        if ( isset($post) && $post != null) {

            $args = array(
                'comment_status' => $post->comment_status,
                'ping_status'    => $post->ping_status,
                'post_author'    => $new_post_author,
                'post_content'   => $post->post_content,
                'post_excerpt'   => $post->post_excerpt,
                'post_parent'    => $post->post_parent,
                'post_password'  => $post->post_password,
                'post_status'    => 'publish',
                'post_title'     => $post->post_title.$suffix,
                'post_type'      => 'campaigns',
                'to_ping'        => $post->to_ping,
                'menu_order'     => $post->menu_order,
            );

            $new_post_id = wp_insert_post( $args );

            $taxonomies = array_map('sanitize_text_field', get_object_taxonomies( $post->post_type ) );
            if ( !empty($taxonomies) && is_array($taxonomies) ):
                foreach ($taxonomies as $taxonomy) {
                    $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
                    wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
                }
            endif;

            $cat_ids = array( 'cloned' );
            wp_set_object_terms( $new_post_id, $cat_ids, 'campaigns-category' );

            $post_meta_infos = $wpdb->get_results($wpdb->prepare("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=%d",$post_id));
            if (count($post_meta_infos)!=0) {
                $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                foreach ($post_meta_infos as $meta_info) {
                    $meta_key = sanitize_text_field($meta_info->meta_key);
                    $meta_value = addslashes($meta_info->meta_value);
                    $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
                }
                $sql_query.= implode(" UNION ALL ", $sql_query_sel);
                $wpdb->query($sql_query);
            }

            $redirect_url = get_permalink( $new_post_id );
        }

        wp_send_json( array( 'status' => 'Done', 'redirect_url' => $redirect_url ), 200 );

    }

    /**
     * Function of deleting cloned campaign
     *
     */
    public function delete_clone_campaign_function() {
        $campaign_id = !empty( $_POST['campaign_id'] ) ? intval( $_POST['campaign_id'] ) : 0;

        wp_delete_post( $campaign_id );

        wp_send_json( array( 'status' => 'Done' ), 200 );

    }

    /**
     * Function of changing cloned camapign's name
     *
     */
    public function change_clone_campaign_name( ) {

        $post = $_POST;

        $new_name    = $post['val'];
        $campaign_id = $post['campaign_id'];

        $args = array(
            'ID'         => $campaign_id,
            'post_title' => $new_name
        );

        wp_update_post( $args );
        wp_send_json( array( 'status' => 'Done' ), 200 );
    }

    /**
     * Function of adding filters for campaigns categories
     *
     * @param $post_type
     * @param $which
     */
    public function categories_filters( $post_type, $which ) {

        if ( 'campaigns' === $post_type ) {
            $taxonomy = 'campaigns-category';
            $tax = get_taxonomy( $taxonomy );
            $cat = filter_input( INPUT_GET, $taxonomy );

            echo '<label class="screen-reader-text" for="campaigns-category">Filter by ' .
                esc_html( $tax->labels->singular_name ) . '</label>';

            wp_dropdown_categories( [
                'show_option_all' => $tax->labels->all_items,
                'hide_empty'      => 0,
                'hierarchical'    => $tax->hierarchical,
                'show_count'      => 1,
                'orderby'         => 'name',
                'selected'        => $cat,
                'taxonomy'        => $taxonomy,
                'name'            => $taxonomy,
                'value_field'     => 'slug',
            ] );
        }
    }

    /**
     * Function getting status label and background color by parameters
     *
     * @param $user_campaigns
     * @param $campaign
     * @return array
     */
    public function get_status_and_background( $user_campaigns, $campaign ) {
        $status = '';
        $ribbon_background = '';
        $additional_class  = '';

        $status     = ( !empty( $user_campaigns['active'] ) && array_key_exists( $campaign, $user_campaigns['active'] ) )   ? __( 'Active', 'dkng' ) : __( 'Not Active', 'dkng' );
        $status     = ( !empty( $user_campaigns['finished'] ) && in_array( $campaign, $user_campaigns['finished'] ) )       ? __( 'Completed', 'dkng' ) : $status;
        $status     = ( !empty( $user_campaigns['draft'] ) && array_key_exists( $campaign, $user_campaigns['draft'] ) )     ? __( 'Draft', 'dkng' ) : $status;
        $status     = ( !empty( $user_campaigns['stopped'] ) && array_key_exists( $campaign, $user_campaigns['stopped'] ) ) ? __( 'Stopped', 'dkng' ) : $status;
        $status     = ( !empty( $user_campaigns['paused'] ) && array_key_exists( $campaign, $user_campaigns['paused'] ) )   ? __( 'Paused', 'dkng' ) : $status;

        if ( ( $status === 'Not Active' ) || ( $status === 'Draft' ) ) {
            $ribbon_background = 'background-color: #c3cedd;';
            $additional_class = 'noactive';
        } elseif( $status === 'Completed' ) {
            $ribbon_background = 'background-color: #0645c7;';
            $additional_class = 'completed';
        } elseif( $status === 'Stopped' ) {
            $ribbon_background = 'background-color: #ED7979;';
        } elseif( $status === 'Paused' ) {
            $ribbon_background = 'background-color: #ffa07f;';
        }

        return array(
            'status'            => $status,
            'ribbon_background' => $ribbon_background,
            'additional_class'  => $additional_class,
        );
    }


    /**
     * Function getting single camapign's report by tab name
     *
     * @param $campaign_users_statistics
     * @param $tab
     * @return array
     */
    public function get_single_report_tab( $campaign_users_statistics, $tab ) {

        $array = array();
        $tab   = ucfirst( $tab );

        if ( !empty( $campaign_users_statistics ) ) {
            foreach ( $campaign_users_statistics as $email => $report ) {
                if ( !empty( $report ) ) {
                    foreach ( $report as $subject => $tabs ) {
                        if ( in_array( $tab, $tabs ) ) {
                            $array[$email][] = $subject;
                        }
                    }
                }
            }
        }

        return $array;
    }

    /**
     * Function akax getting single campaign report by tab
     *
     */
    public function single_campaign_report_tab() {
        $response_html = '';
        $post = $_POST;

        $user  = wp_get_current_user();

        $tab     = $post['tab'];
        $post_id = $post['post_id'];

        $campaign_users_statistics = get_user_meta( $user->ID, 'campaign_users_statistics', true );
        $users_statistics          = ( !empty( $campaign_users_statistics ) ) ? $campaign_users_statistics : array();
        $campaign_users_statistics = ( !empty( $campaign_users_statistics ) && !empty( $campaign_users_statistics[$post_id] ) ) ? $campaign_users_statistics[$post_id] : array();

        $tab_statistic = $this->get_single_report_tab( $campaign_users_statistics, $tab );
        ob_start();

        if ( !empty( $tab_statistic ) ) {
            foreach ( $tab_statistic as $campaign_user => $statistic ) {

                if ( $campaign_user == 'unsubscribers' ) {
                    continue;
                }

                $result = '';

                $tags    = implode(', ', $statistic );

                if ( empty( $campaign_user ) ) {
                    continue;
                }

                foreach ( $statistic as $stat ) {
                    require 'templates/template-parts/ajax-items/campaign_tab_report_item.php';
                }
            }
        }

        $response_html = ob_get_clean();

        wp_send_json( array( 'status' => 'Done', 'html' => $response_html ), 200 );
    }


    /**
     * Function uploading campaign's images via Ajax
     *
     */
    public function upload_campaign_image_js() {

        if ( !function_exists( 'wp_handle_upload'  ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        $uploadedfile  = $_FILES['file'];

        $upload_overrides     = array( 'test_form' => false );
        $movefile             = wp_handle_upload( $uploadedfile, $upload_overrides );

        if ( $movefile && !isset( $movefile['error'] ) ) {
            $response = $movefile;
        } else {
            /**
             * Error generated by _wp_handle_upload()
             * @see _wp_handle_upload() in wp-admin/includes/file.php
             */
            $response =  $movefile['error'];
        }

        wp_send_json( array( 'response' => $response ), 200 );
    }


    /**
     * Function helper - setting email body for individual list user
     *
     * @param $users_from_list
     * @param $id_email
     * @param $campaign_id
     * @param $email_parts
     * @param $sent_emails
     * @param $user_unsubscribers
     *
     * @return array
     */
    private function set_email_body_by_user( $users_from_list, $id_email, $campaign_id, $email_parts, $sent_emails, $user_unsubscribers ) {

        $array1 = array();

        $footer_text  = $email_parts['footer_text'];
        $footer_text1 = $email_parts['footer_text1'];
        $footer_text2 = $email_parts['footer_text2'];
        $email_body   = $email_parts['email_body'];
        $custom_link  = $email_parts['custom_link'];
        $custom_personal_token = $email_parts['custom_personal_token'];

        if ( !empty( $users_from_list ) ) {
            foreach ( $users_from_list as $user ) {
                $user_email   = $user['email'];
                $user_name    = $user['name'];

                $email_encoded = base64_encode( $user_email );
                $api_opened_url = get_site_url() . '/wp-json/seven/openedEmail/' . $id_email . '/' . $email_encoded;
                //$api_clicked_url = get_site_url() . '/wp-json/seven/clickedEmail/' . $id_email . '/' . $email_encoded;
                $api_unsubscribe_url = get_site_url() . "/wp-json/seven/unsubscribeEmail/$id_email/$email_encoded/$campaign_id";
                $ap_clicked_url = get_site_url() . "?api=1&id=$id_email&email=$email_encoded";
                $api_opened_img = "<img src='$api_opened_url' style='display: none;' alt='opened'>";

                $hello_open_userblock = ( !empty( $custom_personal_token ) ) ? "<div class='hello_user_block'><p>Hi $user_name, </p></div>" : "";
                $hello_open_userblock = $api_opened_img . $hello_open_userblock ;

                // $email_body1     = $api_opened_img . $hello_open_userblock . $email_body;
                $email_body1 = "-api_opened_hello_block-" . $email_body;

                if ( !empty( $custom_link ) ) {
                    $divider  = explode( '[custom_link]', $email_body1 );
                    $divider1 = explode( '[/custom_link]', $divider[1] );

                    $link_encoded = base64_encode( $custom_link );
                    $ap_clicked_url .= "&custom_link=$link_encoded";
                    $clicked_userblock = '<a style="background-color:#789;color:#fff;min-width:120px;text-decoration:none;font-weight:500;text-align:center;letter-spacing:.2px;display:inline-block;border-radius:17px;padding:6px 10px;"
                                            href="' . $ap_clicked_url . '">' . $divider1[0] . '</a>';

                    /* OLd functioanlity
                    $subs = array(
                        '/\[custom_link\](.+)\[\/custom_link\]/Ui' =>
                            ''<a style="background-color:#789;color:#fff;min-width:120px;text-decoration:none;font-weight:500;text-align:center;letter-spacing:.2px;display:inline-block;border-radius:17px;padding:6px 10px;" href="' . $ap_clicked_url . '">$1</a>'
                    );
                    */
                    $subs = array(
                        '/\[custom_link\](.+)\[\/custom_link\]/Ui' =>
                            "-api_clicked_block-"
                    );
                    $email_body1 = preg_replace( array_keys( $subs ), array_values( $subs ), $email_body1 );

                } else {
                    $custom_link_html = "";
                    $email_body1 = str_replace('@custom_link', $custom_link_html, $email_body1);

                    $clicked_userblock = '';
                }

                $email_body1 = str_replace(
                    ['<ol>', '<ul>', '<ol>'],
                    ['<ol style="margin-top: 0; margin-bottom: 20px;">', '<ul style="margin-top: 0; margin-bottom: 20px;">', '<ol style="margin-top: 0; margin-bottom: 20px;">'],
                    $email_body1
                );

                /** Unsubscribe functionality */
                $unsubscribe_a = '<a style="text-decoration:none;font-weight:bold; font-size: 14px; " href="' . $api_unsubscribe_url . '">' . __('Unsubscribe', 'dkng') . '</a>';
                $unsubscribe_text = "
                                    <div class='email_unsubscribe_content' style='margin-top: 20px;'>
                                        $unsubscribe_a
                                    </div>
                                ";
                /* */

                //   $email_body1 .= $footer_text . $footer_text1 . $unsubscribe_text . $footer_text2;
                $email_body1 = $email_body1 .  $footer_text .  $footer_text1 . "-unsubscribe_text-" . $footer_text2;

                $already_sent   = ( in_array( $user_email, $sent_emails ) ) ? true : false;
                $is_unsubscrier = ( ( !empty( $user_unsubscribers ) && !in_array( $user_email, $user_unsubscribers ) ) || empty( $user_unsubscribers ) ) ? false : true;
                $is_verified    = $this->verify_email_address( $user_email );

                $array1[$user_email] = array(
                    'email_body'             => $email_body1,
                    'unsubscribe_text'       => $unsubscribe_text,
                    'api_opened_hello_block' => $hello_open_userblock,
                    'api_clicked_block'      => $clicked_userblock,
                    'email'                  => $user_email,
                    'ap_clicked_url'         => $ap_clicked_url,
                    'already_sent'           => $already_sent,
                    'is_unsubscrier'         => $is_unsubscrier,
                    'is_verified'            => $is_verified,
                );

            }
        }

        return $array1;
    }

    /**
     * Function helper - verifying email address
     *
     * @param $user_email
     *
     * return bool
     */
    private function verify_email_address( $user_email ) {

        $mailer = new \PHPMailer\PHPMailer\PHPMailer();
        if ( $mailer::ValidateAddress( $user_email ) ) {

            $strDot     = '.';
            $strAfterAt = substr( strstr( $user_email, '@' ), 1 );
            $chunks     = explode( $strDot, $strAfterAt );
            $cntChunks  = count( $chunks ) - 1;
            $strDomain  = $chunks[( $cntChunks - 1 )] . $strDot . $chunks[$cntChunks];

            if ( getmxrr( $strDomain, $mxhosts ) ) {
                return  true;
            }

        }

        return false;
    }


    /**
     * Insert statistic data from scheduling to tracking table, if needed
     * 
     */
    public function clone_statistic_data() {
        global $wpdb;
        $tablename = $wpdb->prefix . 'scheduling_emails';

        $tablename1   = $wpdb->prefix . 'tracking_system_scheduling_emails';

        $sql = "
               SELECT t.id, t.statistics  
               FROM $tablename t
           ";
        $result    = $wpdb->get_results( $sql, ARRAY_A );

        foreach ( $result as $res ) {

            $email_id   = $res['id'];
            $statistics = $res['statistics'];

            $results     = $wpdb->get_row("SELECT count('id') as 'count' FROM $tablename1 WHERE email_id=$email_id", ARRAY_A );

            $count       = (int)$results['count'];
            if ( $count > 0 ) {
                $wpdb->update( $tablename1, array( 'statistics' => $statistics ), array( 'email_id' => $email_id ) ); //TODO: with tracking table
            }
            else {
                $wpdb->insert( $tablename1, array( 'statistics' => $statistics, 'email_id' => $email_id ) ); //TODO: with tracking table
            }

        }
    }

}
