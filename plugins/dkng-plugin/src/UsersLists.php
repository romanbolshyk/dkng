<?php

namespace Dkng\Wp;

class UsersLists {

    public $limit = 2000;

    /**
     * Main functions for UserLists class
     *
     */
    public function user_list_settings() {

        $this->register_user_lists();
        $this->creating_lead_lists_table();

        add_action( 'wp_ajax_import_user_list',          [ $this,  'import_user_list' ] );
        add_action( 'wp_ajax_nopriv_import_user_list',   [ $this,  'import_user_list' ] );

        add_action( 'wp_ajax_edit_lead_name',            [ $this,  'edit_lead_name' ] );
        add_action( 'wp_ajax_nopriv_edit_lead_name',     [ $this,  'edit_lead_name' ] );

        add_action( 'wp_ajax_delete_lead',               [ $this,  'delete_lead' ] );
        add_action( 'wp_ajax_nopriv_delete_lead',        [ $this,  'delete_lead' ] );

        add_action( 'wp_ajax_edit_lead_info',            [ $this,  'edit_lead_info' ] );
        add_action( 'wp_ajax_nopriv_edit_lead_info',     [ $this,  'edit_lead_info' ] );

        add_action( 'wp_ajax_build_new_lead',            [ $this,  'build_new_lead' ] );
        add_action( 'wp_ajax_nopriv_build_new_lead',     [ $this,  'build_new_lead' ] );

        add_action( 'wp_ajax_wealthbox_tags_filtering',        [ $this, 'wealthbox_tags_filtering' ] );
        add_action( 'wp_ajax_nopriv_wealthbox_tags_filtering', [ $this, 'wealthbox_tags_filtering' ] );

        add_action( 'wp_ajax_wealthbox_lead_list_importing',        [ $this, 'wealthbox_lead_list_importing' ] );
        add_action( 'wp_ajax_nopriv_wealthbox_lead_list_importing', [ $this, 'wealthbox_lead_list_importing' ] );

    }

    /**
     * Function registration CPT UserLists
     *
     */
    private function register_user_lists() {

        $users_lists_slug     = 'users-lists';
        $users_lists_cat_slug = 'users-lists-category';

        $taxonomy_labels = array(
            'name'                       => 'Category',
            'singular_name'              => 'Category',
            'menu_name'                  => 'Categories',
            'all_items'                  => 'All Categories',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Add New Category',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $users_lists_cat_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'users-lists-category', array( 'users-lists' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Users Lists',
            'singular_name'      => 'Users List',
            'menu_name'          => 'Users Lists',
            'parent_item_colon'  => 'Parent Users Lists',
            'all_items'          => 'All Users Lists',
            'view_item'          => 'View Users List',
            'add_new_item'       => 'Add Users List',
            'add_new'            => 'Add New',
            'edit_item'          => 'Edit Users List',
            'update_item'        => 'Update Users List',
            'search_items'       => 'Search Users List',
            'not_found'          => 'No Users Lists found',
            'not_found_in_trash' => 'No Users Lists found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'users-lists',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'users-lists',
            'description'        => 'users-lists information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'author'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-buddicons-buddypress-logo',
            'menu_position'      =>  32,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $users_lists_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'users-lists', $post_type_args );

    }

    /**
     * Function creating scheduling emails table
     *
     */
    private function creating_lead_lists_table() {

        global $wpdb;

        $table_name      = $wpdb->prefix . 'lead_lists';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            id_list INT(11) NULL,
            name VARCHAR(400) NULL,
            last_name VARCHAR(400) NULL,
            email VARCHAR(400) NULL,
            address VARCHAR(400),
            status VARCHAR(400) DEFAULT 'active',
            date_added TIMESTAMP NULL,
            PRIMARY KEY(id)
	    ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

    /**
     * Function callback for importing excel file
     *
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function import_user_list() {

        $user = wp_get_current_user();
        if ( !function_exists( 'wp_handle_upload'  ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        $upload_dir    = wp_upload_dir();
        $uploadedfile  = $_FILES['file'];

        if ( strstr( $uploadedfile['name'], 'xlsx' ) || ( $uploadedfile['type'] != 'application/vnd.ms-excel' ) ) {
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        }
        else  {
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        }

        $objReader->setReadDataOnly(true);
        $objPHPExcel   = $objReader->load( $uploadedfile['tmp_name'] );
        $objWorksheet  = $objPHPExcel->getActiveSheet();

        $highestRow    = $objWorksheet->getHighestRowAndColumn();
        $highestRow    = $highestRow['row'];

        $new_post = array(
            'post_title'  => 'Success Group',
            'post_status' => 'publish',
            'post_type'   => 'users-lists'
        );
        $id_list       = wp_insert_post( $new_post );

        $notification_unsubscribed = array();
        $notification_duplicates   = array();
        $emails_all                = array();
        $emails_duplicates         = array();

        /** Unsubscribers functionality part */
        $user_unsubscribers = self::get_user_unsubscribers();

        $i = 0;

        for ( $row = 2; $row <= $highestRow; $row++ ) {

            $name       = $objWorksheet->getCell('A'.$row )->getValue();
            $last_name  = $objWorksheet->getCell('B'.$row )->getValue();
            $email      = $objWorksheet->getCell('C'.$row )->getValue();
//            $address    = $objWorksheet->getCell('D'.$row )->getValue();

            // $address   = !empty( $address ) ? $address : "";
            $last_name = !empty( $last_name ) ? $last_name : "";
            $name      = !empty( $name ) ? $name : "";
            $email     = !empty( $email ) ? $email : "";
            $date      = date('Y-m-d');

            if ( !empty( $name ) && ( !empty( $email ) ) ) {

                if ( ( !empty( $user_unsubscribers ) && !in_array( $email, $user_unsubscribers ) ) || empty( $user_unsubscribers ) ) {
                    if ( !in_array( $email, $emails_all ) ) {
                        $emails_all[] = $email;
                        $i++;
                        if ( $i <= $this->limit ) {
                            // $this->insert_lead_list_data( $id_list, $name, $last_name, $email, $address, $date );
                            $this->insert_lead_list_data( $id_list, $name, $last_name, $email, $date );
                        }
                    }
                    else {
                        $emails_duplicates[] = $email;
                    }
                }
                elseif ( ( !empty( $user_unsubscribers ) && in_array( $email, $user_unsubscribers ) ) ) {
                    $notification_unsubscribed[] = $email;
                }

            }
        }

        $emails_duplicates = array_unique( $emails_duplicates );
        $notification_unsubscribed = array_unique( $notification_unsubscribed );

        $count_unsubscribed = count( $notification_unsubscribed );
        $count_duplicates   = count( $emails_duplicates );
        $alert_message      = !empty( $notification_unsubscribed ) || !empty( $emails_duplicates ) ? true : false;
        $list_unsubscribers = !empty( $notification_unsubscribed ) ?  implode( ', ', $notification_unsubscribed ) . '.': '';
        $list_duplicates    = !empty( $emails_duplicates ) ? implode( ', ', $emails_duplicates ) . '.' : '';

        $message_unsubscribe = !empty( $notification_unsubscribed ) ? "We have deleted $count_unsubscribed unsubscribers: " : "";
        $message_duplicates  = !empty( $emails_duplicates ) ? " We have deleted $count_duplicates duplicates: " : "";

        update_field( 'author_id', $user->ID, $id_list );

        $redirect_url = get_site_url() . "/admin-campaigns?page=leads/uploaded/id=$id_list";
        wp_send_json(
            array( 'message' => 'Done', 'redirect_url' => $redirect_url, 'error' => 0,
                'message_unsubscribe' => $message_unsubscribe, 'list_unsubscribe' => $list_unsubscribers,
                'message_duplicates'  => $message_duplicates,  'list_duplicates'  => $list_duplicates,
                'alert_message' => $alert_message
            ),200
        );
    }


    /**
     * Function inserting lead list data
     *
     * @param $id_list
     * @param $name
     * @param $last_name
     * @param $email
     * @param $address
     * @param $date
     */
    private function insert_lead_list_data( $id_list, $name, $last_name, $email, $date, $address = '' ) {
        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';

        $wpdb->insert( $tablename, array (
                'id_list'     => $id_list,
                'name'        => $name,
                'last_name'   => $last_name,
                'email'       => $email,
                //'address'     => $address,
                'date_added'  => $date,
            )
        );
    }

    /**
     * Function updating lead list data item
     *
     * @param $id_list
     * @param $name
     * @param $last_name
     * @param $email
     * @param $address
     * @param $date
     */
    private function update_lead_list_item( $id_list, $name, $last_name, $email, $date, $address = '' ) {
        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';

        $wpdb->update( $tablename,
            [
                'name'        => $name,
                'last_name'   => $last_name,
                // 'address'     => $address,
                'date_added'  => $date
            ],
            [ 'id_list' => $id_list, 'email' => $email ]
        );

    }

    /**
     * Delete lead list item
     *
     * @param $id_list
     * @param $email
     */
    private function delete_lead_list_item( $id_list, $email ) {
        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';

        $wpdb->delete( $tablename, [ 'id_list' => $id_list, 'email' => $email ] );
    }

    /**
     * Function updating lead list data
     *
     * @param $id_list
     * @param $name
     * @param $last_name
     * @param $email
     * @param $address
     * @param $date
     */
    public function update_lead_list_data( $id_list, $name, $last_name, $email, $date, $address = '' ) {
        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';

        $wpdb->update( $tablename, array (
            'name'        => $name,
            'last_name'   => $last_name,
            'email'       => $email,
            // 'address'     => $address,
            'date_added'  => $date,
        ),
            array( 'id_list' => $id_list )
        );
    }

    /**
     * Function getting count of lead by lead list id
     *
     * @return array|object|null
     */
    public static function get_count_leads_by_list_id( $id ) {

        $array = array();
        $unsubscribers = self::get_user_unsubscribers();
        $lead_contacts = self::get_emails_by_list_id( $id );

        $common_unsubscribers = array_intersect( $unsubscribers, $lead_contacts );

        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';
//        $result    = $wpdb->get_row("SELECT count('id') as 'count' FROM $tablename WHERE id_list='$id' AND status = 'active'", ARRAY_A );
        $result    = $wpdb->get_row("SELECT count('id') as 'count' FROM $tablename WHERE id_list='$id'", ARRAY_A );

        $count_unsubscribers  = !empty( $common_unsubscribers ) ? count( $common_unsubscribers ) : 0;
        $count_all            = !empty( $result ) ? (int)$result['count'] : 0;
        $count_active         =  empty( $result ) ? 0 : ( $count_all - $count_unsubscribers );

        $array['count_unsubscribers'] = $count_unsubscribers;
        $array['count_all']           = $count_all;
        $array['count_active']        = $count_active;

        return $array;

    }

    /**
     * Function getting count of lead by lead list id
     *
     * @return array|object|null
     */
    public static function get_latest_date_by_list_id( $id ) {

        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';
        $result    = $wpdb->get_row("SELECT max( date_added ) as 'later_date' FROM $tablename WHERE id_list='$id'", ARRAY_A );

        return $result;
    }

    /**
     * Function getting all leads by list id
     *
     * @return array|object|null
     */
    public static function get_leads_by_list_id( $id ) {

        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';
        $result    = $wpdb->get_results( "SELECT * FROM $tablename WHERE id_list='$id' ", ARRAY_A );

        return $result;

    }

    /**
     * Function getting all leads by list id
     *
     * @return array|object|null
     */
    public static function get_emails_by_list_id( $id ) {

        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';
        $result    = $wpdb->get_results("SELECT email FROM $tablename WHERE id_list='$id' ", ARRAY_A );

        $result    = array_column( $result, 'email' );

        return $result;
    }

    /**
     * Function getting all leads by list id
     *
     * @return array|object|null
     */
    public static function get_lead_emails_by_list_id( $id ) {

        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';
        $result    = $wpdb->get_results("SELECT email, name, last_name FROM $tablename WHERE id_list='$id' AND status = 'active'", ARRAY_A );

        return $result;
    }


    /**
     * Function getting all leads by list id
     *
     * @return array|object|null
     */
    public static function get_unsubscribers_from_list( $id ) {

        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';
        $result    = $wpdb->get_results("SELECT email FROM $tablename WHERE id_list='$id' AND status = 'unsubscribed'", ARRAY_A );

        $arr = [];
        if ( $result ) {
            foreach ( $result as $res ) {
                $arr[] = $res['email'];
            }
        }

        return $arr;
    }


    /**
     * Function getting all leads by list id
     *
     * @return array|object|null
     */
    public static function get_first_last_name_by_email( $email, $user_lists ) {

        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';

        $arr = [];
        if ( !empty( $user_lists ) ) {
            foreach ( $user_lists as $user_list ) {
                $user_list_id =  $user_list->ID;
                $result  = $wpdb->get_row("SELECT name, last_name FROM $tablename WHERE id_list='$user_list_id' AND email = '$email' AND status = 'unsubscribed'", ARRAY_A );

                if ( !empty( $result ) ) {
                    $arr[] = $result;
                    return $result;
                }

            }
        }

        return $arr;
    }


    /**
     * Function getting count of all uploaded lead list for user id
     *
     * @param $user_id
     * @return array
     */
    public static function get_leads_by_user_id( $user_id ) {
        $response  = array();
        $args = array(
            'posts_per_page' => -1,
            'post_type'	     => 'users-lists',
            'meta_key'	     => 'author_id',
            'meta_value'     => $user_id
        );

        $the_query   = new \WP_Query( $args );
        $user_lists  = $the_query->posts;
        $count_posts = count( $user_lists );

        $response    = array(
            'count' => $count_posts,
            'posts' => $user_lists
        );

        return $response;
    }

    /**
     * Function  callback of editing lead name
     *
     */
    public function edit_lead_name() {

        global $wpdb;
        $new_name = sanitize_text_field( $_POST['new_name'] );
        $lead_id  = (int)$_POST['lead_id'];

        $title = sanitize_title_with_dashes( $new_name );
        $wpdb->update('wp_posts', [ 'post_name' => $title, 'post_title' => $new_name ], [ 'ID' => $lead_id ] );

        wp_send_json( array( 'message' => 'Done', 'error' => 0 ), 200 );
    }


    /**
     * Function  callback of deleting lead
     *
     */
    public function delete_lead() {

        global $wpdb;
        $new_name = sanitize_text_field( $_POST['new_name'] );
        $lead_id  = (int)$_POST['lead_id'];

        $this->clear_lead_list_by_id( $lead_id );

        wp_delete_post( $lead_id, true );

        wp_send_json( array( 'message' => 'Done', 'error' => 0 ), 200 );
    }


    /**
     * Function callback of editing whole lead list information
     *
     */
    public function edit_lead_info() {
        $post      = $_POST;
        $count_all = (int)$post['count']+1;
        $id_list   = (int)$post['list_id'];
        parse_str ( $post['data'], $params );

        $current_list = $this->get_lead_list_items( $id_list );

        $selected  = array();
        $selected1 = array();

        for ( $i = 0; $i <= $count_all; $i++ ) {
            $name      = $params['name-'.$i];
            $last_name = $params['last_name-'.$i];
            $email     = $params['email-'.$i];
            // $address   = $params['address-'.$i];

            $date      = $params['date-'.$i];
            $new_date  = date( 'Y/m/d', strtotime( $date ) );

            if ( !empty( $name ) && ( !empty( $email ) ) ) {

                if ( array_key_exists( $email, $current_list ) ) {
                    $selected[] =  $current_list[$email];
                    $selected1[] = $email;
                    $this->update_lead_list_item( $id_list, $name, $last_name, $email, $new_date );
                }
                else {
                    $this->insert_lead_list_data( $id_list, $name, $last_name, $email, $new_date );
                }

            }
        }

        $array_keys = array_keys( $current_list );
        $array_diff = array_diff( $array_keys, $selected1 );

        if ( !empty( $array_diff ) ) {
            foreach ( $array_diff as $diff ) {
                $this->delete_lead_list_item( $id_list, $diff );
            }
        }

        $campaigns = new Campaigns();
        $campaigns->update_lead_list_count( $id_list );

        wp_send_json( array( 'message' => 'Done', 'error' => 0 ), 200 );
    }


    /**
     * Function callback for building new lead list information
     *
     */
    public function build_new_lead() {
        $post      = $_POST;
        $count_all = (int)$post['count'];
        parse_str ( $post['data'], $params );
        $new_array = array();

        /** Unsubscribers functionality part */
        $current_user = wp_get_current_user();
        $current_user = $current_user->ID;

        $user_unsubscribers = self::get_user_unsubscribers();;

        $list_new = array (
            'post_title'  => wp_strip_all_tags( $params['list_name'] ),
            'post_status' => 'publish',
            'post_type'   => 'users-lists'
        );
        $new_list_id        = wp_insert_post( $list_new );
        update_field( 'author_id',     $current_user, $new_list_id );

        $notification_unsubscribed = array();
        $alert_message = false;

        for ( $i = 0; $i <= $count_all; $i++ ) {
            $name      = $params['name-'.$i];
            $last_name = $params['last_name-'.$i];
            $email     = $params['email-'.$i];
            // $address   = $params['address-'.$i];

            $date      = $params['date-'.$i];
            $new_date  = date( 'Y/m/d', strtotime( $date ) );

            if ( !empty( $name ) && ( !empty( $email ) ) ) {
                if ( ( !empty( $user_unsubscribers ) && !in_array( $email, $user_unsubscribers ) ) || empty( $user_unsubscribers ) ) {
                    $this->insert_lead_list_data( $new_list_id, $name, $last_name, $email, $new_date );
                }
                elseif ( ( !empty( $user_unsubscribers ) && in_array( $email, $user_unsubscribers ) ) ) {
                    $notification_unsubscribed[] = $email;
                }

            }

        }

        $notification_unsubscribed = array_unique( $notification_unsubscribed );
        $count_unsubscribed = count( $notification_unsubscribed );
        $alert_message      = !empty( $notification_unsubscribed ) ? true : false;
        $list_unsubscribers = !empty( $notification_unsubscribed ) ?  implode( ', ', $notification_unsubscribed ) . '.': '';

        $message_unsubscribe = !empty( $notification_unsubscribed ) ? "We have deleted $count_unsubscribed unsubscribers: " : "";

        $url = get_site_url() . "/admin-campaigns/?page=all_leads";

        wp_send_json(
            array( 'message' => 'Done', 'redirect_url' => $url, 'error' => 0, 'alert_message' => $alert_message,
                'message_unsubscribe' => $message_unsubscribe, 'list_unsubscribe' => $list_unsubscribers
            ),200
        );

    }


    /**
     * Function deleting all data for lead list before saving new data
     *
     * @param $list_id
     * @return bool
     */
    private  function clear_lead_list_by_id( $list_id ) {
        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';

        $wpdb->delete( $tablename, array( 'id_list' => $list_id ) );

        return true;
    }

    /**
     *
     * @param $list_id
     * @return bool
     */
    private  function get_lead_list_items( $list_id ) {
        global $wpdb;
        $tablename = $wpdb->prefix . 'lead_lists';

        $sql = "SELECT email, id FROM $tablename WHERE `id_list` = $list_id";
        $result = $wpdb->get_results( $sql, ARRAY_A );

        $result = array_values( $result );
        $arr    = array();

        foreach ( $result as $res ) {
            $arr[$res['email']] = $res['id'];
        }

        return $arr;
    }

    /**
     * Function getting username for lead list email via params
     *
     * @param $campaign_id
     * @param $user_id
     * @param $email
     * @return mixed
     */
    public static function get_username_for_email( $campaign_id, $user_id, $email ) {
        global $wpdb;

        $tablename  = $wpdb->prefix . 'lead_lists';
        $tablename1 = $wpdb->prefix . 'scheduling_emails';
        $results    = $wpdb->get_row("SELECT user_list FROM $tablename1 WHERE user_id=$user_id AND campaign_id=$campaign_id", ARRAY_A );

        $user_list  = $results['user_list'];
        $result     = $wpdb->get_row("SELECT name, last_name FROM $tablename WHERE id_list='$user_list' and email='$email'", ARRAY_A );

        return $result;
    }


    /**
     * Function getting status for lead list email via params
     *
     * @param $campaign_id
     * @param $user_id
     * @param $email
     * @return mixed
     */
    public static function get_status_for_email( $campaign_id, $user_id, $email ) {
        global $wpdb;

        $tablename  = $wpdb->prefix . 'lead_lists';
        $tablename1 = $wpdb->prefix . 'scheduling_emails';
        $results    = $wpdb->get_row("SELECT user_list FROM $tablename1 WHERE user_id=$user_id AND campaign_id=$campaign_id", ARRAY_A );

        $user_list  = $results['user_list'];
        $result     = $wpdb->get_row("SELECT status FROM $tablename WHERE id_list='$user_list' and email='$email'", ARRAY_A );
        return $result['status'];
    }

    /**
     * Function getting unsubscribers by user id
     *
     * @return mixed
     */
    public static function get_user_unsubscribers() {

        $current_user = wp_get_current_user();
        $user_id      = $current_user->ID;
        $user_unsubscribers = array();

        $campaign_users_statistics = get_user_meta( $user_id, 'campaign_users_statistics', true );
        $campaign_users_statistics = !empty( $campaign_users_statistics ) ? $campaign_users_statistics : array();
        $user_unsubscribers        = !empty( $campaign_users_statistics['unsubscribers'] ) ? $campaign_users_statistics['unsubscribers'] : array();

        return $user_unsubscribers;
    }


    /**
     * Function callback of wealthbox contacts tags filtering
     *
     */
    public function wealthbox_tags_filtering() {

        $post  = $_POST;
        parse_str ( $post['data'], $params );
        $user  = wp_get_current_user();

        $wealthbox_api_key = get_field( 'wealthbox_api_key', 'user_' . $user->ID );
        $wealthbox_api_key = ( !empty( $wealthbox_api_key ) ) ? $wealthbox_api_key : "";

        $tags = $params['contact_tags'];
        $count_page = (int)$params['count_page'];
        $tags = implode( ',', $tags );

        $wealthbox_obj    = new WealthboxActions();
        $contacts_by_tags = !empty( $params['contact_tags'] ) ? $wealthbox_obj->get_contact_by_tags( $wealthbox_api_key, $tags, $count_page ) : $wealthbox_obj->get_contact_persons( $wealthbox_api_key, $count_page );
        $contacts_by_tags = !empty( $contacts_by_tags ) && empty( $contacts_by_tags['error'] ) ? $contacts_by_tags['response'] : array();
        $limit_message    = ( $contacts_by_tags['meta']['total_count'] >= $this->limit ) ? 'show' : 'hide';
        $total_count      = $contacts_by_tags['meta']['total_count'];

        $contacts_by_tags = !empty( $contacts_by_tags ) ? $contacts_by_tags['contacts'] : array();

        $emails_all  = array();
        $html = '';
        ob_start();

        $count_contacts = ( count( $contacts_by_tags ) >= $this->limit ) ? $this->limit : count( $contacts_by_tags );

        if ( !empty( $contacts_by_tags ) ) {
            $i = 0;
            foreach ( $contacts_by_tags as $contact ) {
                $email  = $contact['email_addresses'][0]['address'];
                if ( !in_array( $email, $emails_all ) && !empty( $email ) && ( $i <= $this->limit ) ) {
                    $emails_all[] = $email;
                    require 'templates/template-parts/ajax-items/wealthbox_contact_item.php';
                }
            }
        }

        $html = ob_get_clean();
        $html .= "<input type='hidden' name='count_contacts' value='" . count( $contacts_by_tags ) . "' >";

        wp_send_json( array( 'status' => 'Done', 'html' => $html, 'limit_message' => $limit_message, 'total_count' => $total_count ), 200 );
    }


    /**
     * Function callback of submitting wealthbox form for importing lead list
     *
     */
    public function wealthbox_lead_list_importing() {

        $post  = $_POST;
        parse_str ( $post['data'], $params );

        var_dump( '$params', $params );
        die;
        $count_all = (int)$params['count_contacts'];
        $count_all = empty( $count_all ) ? (int)$post['count_contacts1'] : $count_all;
        $list_name = $params['list_name'];

//        $count_all = (int)$post['count_contacts'];
//        $count_all = empty( $count_all ) ? (int)$post['count_contacts1'] : $count_all;
//        $list_name = $post['list_name'];
        $current_user = wp_get_current_user();

        /** Unsubscribers functionality part */
        $current_user = $current_user->ID;
        $user_unsubscribers = self::get_user_unsubscribers();;

        $list_new = array (
            'post_title'  => wp_strip_all_tags( $list_name ),
            'post_status' => 'publish',
            'post_type'   => 'users-lists'
        );
        $new_list_id  = wp_insert_post( $list_new );
        update_field( 'author_id',  $current_user, $new_list_id );

        $notification_unsubscribed = array();
        $alert_message = false;

        for ( $i = 0; $i <= $count_all; $i++ ) {
            $name      = $params['name-'.$i];
            $last_name = $params['last_name-'.$i];
            $email     = $params['email-'.$i];
            // $date      = $params['date-'.$i];

//            $name      = $post['name-'.$i];
//            $last_name = $post['last_name-'.$i];
//            $email     = $post['email-'.$i];
//            $date      = $post['date-'.$i];

            $new_date = date( 'Y/m/d' );

            if ( !empty( $name ) && ( !empty( $email ) ) ) {
                if (
                    ( ( !empty( $user_unsubscribers ) && !in_array( $email, $user_unsubscribers ) ) || empty( $user_unsubscribers ) )
                    &&
                    ( $i <= $this->limit )
                ) {
                    $this->insert_lead_list_data( $new_list_id, $name, $last_name, $email, $new_date );
                }
                elseif ( ( !empty( $user_unsubscribers ) && in_array( $email, $user_unsubscribers ) ) ) {
                    $notification_unsubscribed[] = $email;
                }

            }
        }

        $notification_unsubscribed = array_unique( $notification_unsubscribed );
        $count_unsubscribed  = count( $notification_unsubscribed );
        $alert_message       = !empty( $notification_unsubscribed ) ? true : false;
        $list_unsubscribers  = !empty( $notification_unsubscribed ) ? implode( ', ', $notification_unsubscribed ) . '.': '';
        $message_unsubscribe = !empty( $notification_unsubscribed ) ? "We have deleted $count_unsubscribed unsubscribers: " : "";

        $url = get_site_url() . "/admin-campaigns/?page=leads/id=$new_list_id";

        wp_send_json(
            array( 'message' => 'Done', 'redirect_url' => $url, 'error' => 0, 'alert_message' => $alert_message,
                'message_unsubscribe' => $message_unsubscribe, 'list_unsubscribe' => $list_unsubscribers
            ),200
        );

    }

}

