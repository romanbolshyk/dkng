<?php

namespace Dkng\Wp;

class ArticlesActions {

    public $different_domain;

    /**
     * ArticlesActions constructor.
     */
    public function __construct() {
        $this->different_domain = get_field( 'different_domain_site', 'option' );
        $this->different_domain = !empty( $this->different_domain ) ? $this->different_domain : '';
    }

    /**
     * Actions on Init
     */
    public function init_actions() {

        add_action( 'add_meta_boxes',  [ $this,  'companies_box_add' ] );
        add_action( 'save_post',       [ $this,  'article_save_postdata' ], 10, 3 );
        add_action( 'acf/save_post',   [ $this,  'my_acf_save_post' ], 5 );

        add_action( 'pre_get_posts',   [ $this, 'callback_sort_by_company' ] );

        // enqueve js/CSS resources
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts_styles' ] );

        add_filter( 'manage_edited_articles_posts_columns',         [ $this, 'edited_articles_table'] );
        add_action( 'manage_edited_articles_posts_custom_column',   [ $this, 'edited_articles_table_values' ], 20, 2 );
        add_filter( 'manage_edit-edited_articles_sortable_columns', [ $this, 'add_views_sortable_column' ] );

        add_filter( 'manage_articles_posts_columns',                [ $this, 'articles_table'] );
        add_action( 'manage_articles_posts_custom_column',          [ $this, 'articles_table_values' ], 20, 2 );
        add_filter( 'manage_edit-articles_sortable_columns',        [ $this, 'articles_sortable_column' ] );

//        add_action( 'wp_ajax_edit_post',                            [ $this,  'edit_post_function' ] );
//        add_action( 'wp_ajax_nopriv_edit_post',                     [ $this,  'edit_post_function' ] );

        add_action( 'wp_ajax_clone_article',                        [ $this,  'clone_article_function' ] );
        add_action( 'wp_ajax_nopriv_clone_article',                 [ $this,  'clone_article_function' ] );

        add_action( 'wp_ajax_edit_cloned_article',                  [ $this,  'edit_cloned_article_function' ] );
        add_action( 'wp_ajax_nopriv_edit_cloned_article',           [ $this,  'edit_cloned_article_function' ] );

        add_action( 'wp_ajax_reset_cloned_article',                 [ $this,  'reset_cloned_article_function' ] );
        add_action( 'wp_ajax_nopriv_reset_cloned_article',          [ $this,  'reset_cloned_article_function' ] );

        add_action( 'wp_ajax_published_articles',                   [ $this,  'published_articles_function' ] );
        add_action( 'wp_ajax_published_articles',                   [ $this,  'published_articles_function' ] );

        add_action( 'wp_ajax_downloads_process',                    [ $this,  'downloads_process_function' ] );
        add_action( 'wp_ajax_nopriv_downloads_process',             [ $this,  'downloads_process_function' ] );

        add_action( 'wp_ajax_share_read_article',                   [ $this,  'share_read_article_function' ] );
        add_action( 'wp_ajax_nopriv_share_read_article',            [ $this,  'share_read_article_function' ] );

        add_action( 'restrict_manage_posts',                        [ $this,  'categories_filters' ], 10, 2 );

    }

    /**
     * Function of including scripts for current cpt
     *
     */
    public function enqueue_scripts_styles() {

        if (
                is_page_template( 'templates/dashboard-content.php' )
                || ( is_singular( 'articles') )
                || ( is_singular( 'edited_articles') )
        ) {
            $date_now = date('H.s');
            wp_enqueue_script( 'articles-scripts', SVN_PLUGIN_URL . '/assets/articles.js', array( 'jquery' ), $date_now, true );
//            wp_enqueue_style( 'template',   plugins_url( '../assets/scss/blocks/template.css', __FILE__ ), 'all', date('m.d.H') );
        }
    }

    /**
     * Function adding metabox for courses
     *
     */
    public function companies_box_add() {
        add_meta_box( 'companies-box', 'Companies', array( $this, 'uncompanies_list' ), 'articles', 'normal', 'high' );
    }

    /**
     * Function adding html layout for listeners list
     *
     * @param $post
     */
    public function uncompanies_list( $post ) {
        $uncompanies_list = get_post_meta( $post->ID, 'uncompanies_list', true );

        $standart_checked = ( ( $uncompanies_list == "none" ) && !is_array( $uncompanies_list ) )  ? "" : "checked";
        $none_checked     = ( ( $uncompanies_list == "none" ) && !is_array( $uncompanies_list ) )  ? "checked" : "";

        $companies = array();
        $users     = get_users( array(
            'role__not_in' => array( 'administrator' ),
            'role__in'     => array( 'subscriber' ),
            'fields'       => 'id',
        ) );

        foreach ( $users as $user ) {
            $company        = get_field( 'name', 'user_' . $user );
            if ( !empty( $company )  && ( !in_array( $company, $companies ) )  ) {
                $companies[] = $company;
            }
        }
        ?>
        <div>
            <p>
                <span class="span_radios" >
                    <input type="radio" name="need_companies" id="yes_company" <?php echo $standart_checked;?> value="yes">
                    <label for="yes_company">Yes</label>
                </span>
                <span class="span_radios" >
                    <input type="radio" name="need_companies" id="no_company" <?php echo $none_checked;?> value="no">
                    <label for="no_company">No</label>
                </span>
            </p>
            <p><label for="uncompanies_list"><?php _e( "Companies:", "dkng" );?></label></p>
            <select name='uncompanies_list[]' id='uncompanies_list' multiple >
                <?php foreach ( $companies as $company ) {
                    $company_sorted = strtolower( str_replace( ' ', '__', $company ) );
                    $company_sorted = strtolower( str_replace( '&', '_and_', $company_sorted ) );

                    if ( empty( $uncompanies_list ) ) {
                        $selected = "selected";
                    }
                    else {
                        $selected = ( !array_key_exists( $company_sorted, $uncompanies_list ) ) ? "selected" : "";
                    }
                    ?>
                    <option value="<?php echo esc_attr( $company ); ?>" <?php echo $selected; ?> >
                        <?php echo esc_html( $company ); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <?php
    }

    /**
     * Function save post for ACF fields
     *
     * @param $post_id
     */
    public  function my_acf_save_post( $post_id ) {

        // Get previous values.
        $prev_values = get_fields( $post_id );
        $hero_image  = get_field('video_module_link', $post_id);

        $values      = $_POST['acf'];
        if ( isset( $_POST['acf']['field_5e568ef73d3ba'] ) ) {

            if ( $hero_image != $_POST['acf']['field_5e568ef73d3ba'] ) {
                $notification_obj = new Notifications();
                $obj = array (
                    'title'   => 'Video module link',
                    'id_post' => 0,
                    'type'    => 'video_link',
                    'url'     => get_site_url(). '/admin-dashboard#video_module',
                );

                $notification_obj->save_to_db( $obj, false );
            }

        }

    }

    /**
     * Function callback on saving articles / course
     *
     * @param $post_id
     * @param $post
     * @param $update
     * @throws \Exception
     */
    public function article_save_postdata( $post_id, $post, $update ) {

        $post_created  = new \DateTime( $post->post_date_gmt );
        $post_modified = new \DateTime( $post->post_modified_gmt );

        $post_terms = ( get_post_type( $post_id ) == 'campaigns' ) ? wp_get_object_terms( $post_id, 'campaigns-category', array('fields' => 'slugs') ) : array();
        $articles_terms = ( get_post_type( $post_id ) == 'articles' ) ? wp_get_object_terms( $post_id, 'articles-types', array('fields' => 'slugs') ) : array();

        if (
            ( abs( $post_created->diff( $post_modified )->s ) <= 1 )
            &&
            ( $post->post_status == 'publish' )
            &&
            (
                ( ( get_post_type( $post_id ) == 'articles' ) && ( in_array( 'original', $articles_terms ) ) )
                ||
                ( get_post_type( $post_id ) == 'courses' )
                ||
                ( get_post_type( $post_id ) == 'recomendations' )
                ||
                ( get_post_type( $post_id ) == 'svn_tpl' )
                ||
                ( ( get_post_type( $post_id ) == 'campaigns' ) && ( in_array( 'original', $post_terms ) ) )
            )
        ) {
            $notification_obj = new Notifications();
            $notification_obj->save_to_db( $post, true );
        }

        $need_companies = !empty( $_POST['need_companies'] ) ? sanitize_text_field( $_POST['need_companies'] ) : "";
        if ( $need_companies == "yes" ) {
            if ( array_key_exists( 'uncompanies_list', $_POST ) ) {

                $uncompanies_list = array();

                $all_companies    = array();
                $users     = get_users( array(
                    'role__not_in' => array( 'administrator' ),
                    'role__in'     => array( 'subscriber' ),
                    'fields'       => 'id',
                ) );

                if ( !empty( $users ) ) {
                    foreach ( $users as $user ) {
                        $company        = get_field( 'name', 'user_' . $user );
                        if ( !empty( $company )  && ( !in_array( $company, $all_companies ) )  ) {
                            $all_companies[] = $company;
                        }
                    }
                }

                $post_companies   = isset( $_POST['uncompanies_list'] ) ? (array) $_POST['uncompanies_list'] : array();
                $post_companies   = array_map( 'stripslashes_deep', $post_companies );

                $differ_companies = array_diff( $all_companies, $post_companies );

                if ( !empty( $differ_companies ) ) {
                    foreach ( $differ_companies as $company ) {
                        $company_sorted = strtolower( str_replace( ' ', '__', $company ) );
                        $company_sorted = strtolower( str_replace( '&', '_and_', $company_sorted ) );
                        $uncompanies_list[$company_sorted] = $company;
                    }
                }

                update_post_meta( $post_id, 'uncompanies_list', $uncompanies_list );
            }
        }
        else {
            update_post_meta( $post_id, 'uncompanies_list', 'none' );
        }

    }

    /**
     * Function getting related article data from site2 by API
     *
     * @param $related
     * @return array|mixed|\WP_Error
     */
    public function get_related_article_from_site2( $related ) {

        $result   = array();
        if ( empty( $related ) ) {
            return $result;
        }
        $url_get  = $this->different_domain . "wp-json/seven/getPostData/$related";
        $response = wp_remote_get( $url_get );

        if ( is_array( $response ) ) {
            $response = json_decode( $response['body'], true );

            $result['link']  = $response['link'];
            $result['title'] = $response['title'];
        }
        else {
            $response = array();
        }

        return $result;

    }


    /**
     * Add new columns for edited articles in admin panel
     *
     * @param $column
     * @return mixed
     */
    public function edited_articles_table( $column ) {

        $column['author']   = 'Author';
        $column['company']  = 'Company';

        return $column;
    }

    /**
     * Add new columns for cpt articles in admin panel
     *
     * @param $column
     * @return mixed
     */
    public function articles_table( $column ) {

        $column['article_type']   = 'Type of Article';

        return $column;
    }

    /**
     * Function making table sortable for cpt Edited_Articles
     *
     * @param $sortable_columns
     * @return mixed
     */
    public function add_views_sortable_column( $sortable_columns ){

        $sortable_columns['author']   = 'author';
        $sortable_columns['company']  = 'companies';

        return $sortable_columns;
    }

    /**
     * Function making table sortable for cpt Articles
     *
     * @param $sortable_columns
     * @return mixed
     */
    public function articles_sortable_column( $sortable_columns ){

        $sortable_columns['article_type']   = 'Type of Article';

        return $sortable_columns;
    }

    /**
     * Function setting values for admin panel
     *
     * @param $column
     */
    public function edited_articles_table_values ( $column ) {

        global $post;

        $company_name = get_field( 'author_company', $post->ID );

        if ( $column == 'company' ) {
            if ( $company_name != false ) {
                echo $company_name;
            }
        }
    }

    /**
     * Function setting values in admin panel for articles cpt
     *
     * @param $column
     */
    public function articles_table_values ( $column ) {

        global $post;

        $type_article = get_field( 'article_type',  $post->ID  );
        if ( $column == 'article_type' ) {
            echo ucfirst( $type_article );
        }
    }


    /**
     * Function edit post callback
     *
     */
    public function edit_post_function() {

        $user = wp_get_current_user();
        $post = $_POST;
        if ( !function_exists( 'wp_handle_upload'  ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $upload_dir           = wp_upload_dir();
        $uploadedfile         = $_FILES['file'];
        $image                = explode( '.', $uploadedfile['name'] );
        $uploadedfile['name'] = "thumb" . "." . $image[1];
        $company_name         =  get_field( 'name', 'user_' . $user->ID );

        $fileurl              = $upload_dir['path'] . '/' .  $uploadedfile['name'];
        $upload_overrides     = array( 'test_form' => false );
        wp_handle_upload( $uploadedfile, $upload_overrides );

        parse_str ( $post['data'], $params );
        $content  = $params['content'];
        $title    = $params['title'] . ' by ' . $params['author'];
        $except   = $params['except'];

        $this->delete_other_articles_by_user( $user,  $params['origin_post'] );

        $post_data = array(
            'post_title'    => wp_strip_all_tags( $title ),
            'post_content'  => $content,
            'post_excerpt'  => $except,
            'post_status'   => 'publish',
            'post_author'   => $user->ID,
            'post_type'     => 'edited_articles',
            'post_parent'   => $params['origin_post']
        );

        $post_id            = wp_insert_post( $post_data );

        $related[ $user->ID ] = $post_id;
        update_field( 'original_post', $params['origin_post'], $post_id );
        update_field( 'author_company', $company_name, $post_id );
        update_post_meta( $params['origin_post'], 'related_edited_article' , $related );

        $wp_filetype = wp_check_filetype( $uploadedfile['name'], null );
        $attachment  = array(
            'post_mime_type' => $wp_filetype['type']
        );
        $attach_id   = wp_insert_attachment( $attachment, $fileurl, $post_id );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $fileurl );
        $res1        = wp_update_attachment_metadata( $attach_id, $attach_data );
        $res2        = set_post_thumbnail( $post_id, $attach_id );

        wp_send_json( 'Done', 200 );
    }


    /**
     * Function cloning original articles callback
     *
     */
    public function clone_article_function() {

        $user = wp_get_current_user();
        $post = $_POST;
        if ( !function_exists( 'wp_handle_upload'  ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $upload_dir           = wp_upload_dir();

        parse_str ( $post['data'], $params );
        $content  = $params['content'];
        $except   = $params['except'];

        $origin_post        = (int)$params['origin_post'];
        $original_thumbnail = get_the_post_thumbnail_url( $origin_post );

        $uploadedfile        = !empty( $_FILES['file'] ) ? $_FILES['file'] : $original_thumbnail;
        $company_name        =  get_field( 'name', 'user_' . $user->ID );

        $post_data = array(
            'post_title'    => wp_strip_all_tags( $params['title'] ),
            'post_content'  => $content,
            'post_excerpt'  => $except,
            'post_status'   => 'publish',
            'post_author'   => $user->ID,
            'post_type'     => 'articles',
            'post_parent'   => $origin_post,
        );

        $post_id          = wp_insert_post( $post_data );
        wp_set_object_terms( $post_id, 'Cloned', 'articles-types' );

        $user_timezone    = get_field( 'user_timezone', 'user_'.$user->ID );
        $default_timezone = get_option('timezone_string');
        $user_timezone    = !empty( $user_timezone ) ? $user_timezone : $default_timezone;

        $edited_date      = new \DateTime("now", new \DateTimeZone($user_timezone) );
        $edited_date      = $edited_date->format('F j, Y g:i a');

        $related[ $user->ID ] = $post_id;
        update_field( 'original_post',  $params['origin_post'], $post_id );
        update_field( 'author_company', $company_name, $post_id );
        update_field( 'edited_date',    $edited_date,  $post_id );
        update_field( 'show_custom_link_message', false,  $post_id );
        update_post_meta( $params['origin_post'], 'related_edited_article' , $related );

        if ( !empty( $_FILES['file'] ) ) {

            $filetype      = wp_check_filetype( basename( $uploadedfile['name'] ), null );
            $filetype      = $filetype['ext'];
            $date_now      = date('m-d-h-s');

            $uploadedfile['name'] = "ava_" . $post_id . "." . $date_now . '.' .  $filetype;
            $fileurl              = $upload_dir['path'] . '/' .  $uploadedfile['name'];

            $upload_overrides     = array( 'test_form' => false );
            wp_handle_upload( $uploadedfile, $upload_overrides );

            $wp_filetype = wp_check_filetype( $uploadedfile['name'], null );
            $attachment  = array(
                'post_mime_type' => $wp_filetype['type']
            );
            $attach_id   = wp_insert_attachment( $attachment, $fileurl, $post_id );
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            $attach_data = wp_generate_attachment_metadata( $attach_id, $fileurl );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            set_post_thumbnail( $post_id, $attach_id );
        }
        else {
            if ( !empty( $original_thumbnail ) ) {
                $this->generate_featured_image_from_original( $original_thumbnail, $post_id  );
            }
        }

        $redirect_link = get_permalink( $post_id );
        $this->user_cloned_articles_usermeta( $params['origin_post'], $post_id );

        wp_send_json(  array( 'status' => 'Done', 'redirect_link' => $redirect_link ), 200 );
    }

    /**
     * Function editing cloned articles callback
     *
     */
    public function edit_cloned_article_function() {

        $user = wp_get_current_user();
        $post = $_POST;
        if ( !function_exists( 'wp_handle_upload'  ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        $upload_dir   = wp_upload_dir();

        parse_str ( $post['data'], $params );
        $content    = $params['content'];
        $except     = $params['except'];
        $article_id = $params['origin_post'];

        $post_data = array(
            'ID'            => $article_id,
            'post_title'    => wp_strip_all_tags( $params['title'] ),
            'post_content'  => $content,
            'post_excerpt'  => $except,
            'post_status'   => 'publish',
            'post_type'     => 'articles',
        );

        wp_update_post( $post_data );

        $user_timezone    = get_field( 'user_timezone', 'user_'.$user->ID );
        $default_timezone = get_option('timezone_string');
        $user_timezone    = !empty( $user_timezone ) ? $user_timezone : $default_timezone;

        $edited_date      = new \DateTime("now", new \DateTimeZone( $user_timezone ) );
        $edited_date      = $edited_date->format('F j, Y g:i a');
        update_field( 'edited_date', $edited_date, $article_id );
        update_field( 'show_custom_link_message', true,  $article_id );

        if ( !empty( $_FILES['file'] ) ) {
            $uploadedfile  = !empty( $_FILES['file'] ) ? $_FILES['file'] : '';
            $filetype      = wp_check_filetype( basename( $uploadedfile['name'] ), null );
            $filetype      = $filetype['ext'];
            $date_now      = date('m-d-h-s');

            $uploadedfile['name'] = "ava_" . $article_id . "." . $date_now . '.' .  $filetype;
            $fileurl              = $upload_dir['path'] . '/' .  $uploadedfile['name'];

            $upload_overrides     = array( 'test_form' => false );
            wp_handle_upload( $uploadedfile, $upload_overrides );

            $wp_filetype = wp_check_filetype( $uploadedfile['name'], null );
            $attachment  = array(
                'post_mime_type' => $wp_filetype['type']
            );
            $attach_id   = wp_insert_attachment( $attachment, $fileurl, $article_id );
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            $attach_data = wp_generate_attachment_metadata( $attach_id, $fileurl );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            set_post_thumbnail( $article_id, $attach_id );
        }


        wp_send_json(  array( 'status' => 'Done' ), 200 );
    }


    /**
     * Function editing cloned articles callback
     *
     */
    public function reset_cloned_article_function() {

        $user = wp_get_current_user();
        $post = $_POST;

        $article_id = $post['article_id'];
        $original_article = get_field( 'original_post', $article_id );

        $cloned_articles = get_user_meta( $user->ID, 'user_cloned_articles', true );
        $cloned_articles = !empty( $cloned_articles ) ? $cloned_articles : array();

        if ( array_key_exists( $original_article, $cloned_articles ) ) {
            unset($cloned_articles[$original_article]);
        }

        update_user_meta( $user->ID, 'user_cloned_articles', $cloned_articles );

        $redirect_link = get_permalink( $original_article );

        wp_delete_post( $article_id );

        wp_send_json( array( 'status' => 'Done', 'redirect_link' => $redirect_link ), 200 );
    }

    /**
     * Function deleting articles by user
     *
     * @param $user
     * @param $origin_post
     */
    public function  delete_other_articles_by_user( $user, $origin_post ) {
        $user     = wp_get_current_user();
        $articles = new \WP_Query( array ( 'post_type' => 'edited_articles', 'posts_per_page' => -1 ) );
        foreach ( $articles->posts as $article ) {
            $related            = get_post_meta( $origin_post, 'related_edited_article', true );
            $get_original_post  = get_field( 'original_post', $article->ID );
            if ( $article->post_author == $user->ID && $origin_post == $get_original_post ) {
                wp_delete_post( $article->ID );
            }
        }
    }

    /**
     * Function callback for published articles
     *
     */
    public function published_articles_function() {

        $post     = $_POST;

        $post_id   = ( !empty( $post['id_post'] ) )   ? $post['id_post']   : 0;
        $user_id   = ( !empty( $post['id_user'] ) )   ? $post['id_user']   : 0;
        $id_shared = ( !empty( $post['id_shared'] ) ) ? $post['id_shared'] : 0;

        $different_domain = get_field( 'different_domain_site', 'option' );

        $user_published_articles = get_user_meta( $user_id,'published_articles', true );
        if ( empty( $user_published_articles ) ) $user_published_articles = array();

        $post_data = get_post( $post_id );
        $user      = get_userdata( $user_id );
        $company   = get_field( 'name', 'user_' . $user_id );
        $from      = array( ' ', '-',  ',',    '®',     '\'',   '\"' );
        $to        = array( '_', '_', '_com_', '_ufa_', '_ap_', '_dap_' );
        $company   = ( !empty( $company ) ) ? strtolower( str_replace( $from, $to, $company ) ) : 'company_name';

        if ( (int)$post['checked'] == 1 ) {

            $postcat         = get_the_terms( $post_id, 'articles-types' );
            $postcat         = $postcat[0]->name;
            $cloned_article  = ( $postcat == 'Cloned' ) ? true : false;

            /* Published functionality */
            $user_published_articles[$post_id] = $post_id;

            $content  = ( !empty( $post_data->post_content ) ) ? $post_data->post_content : '';
            $title    = ( !empty( $post_data->post_title ) )   ? $post_data->post_title   : 'new title';
            $except   = ( !empty( $post_data->post_excerpt ) ) ? $post_data->post_excerpt : '';

            $url_delete = $different_domain . "wp-json/seven/deletePost/$user_id/$post_id";
            wp_remote_get( $url_delete );

            $fileurl     = get_the_post_thumbnail_url( $post_id );
            $wp_filetype = wp_check_filetype( $fileurl, null );
            $attachment  = array(
                'post_mime_type' => $wp_filetype['type']
            );

            $post_new = array (
                'password'     => 'password',
                'attachment'   => $attachment,
                'fileurl'      => $fileurl,
                'company'      => $company,
                'post_title'   => wp_strip_all_tags( $title ),
                'post_content' => $content,
                'post_excerpt' => $except,
                'post_status'  => 'publish',
                'post_author'  => $user_id,
                'post_type'    => 'articles',
                'post_parent'  => $post_id
            );

            $url_share = $different_domain . 'wp-json/seven/shareArticle';
            $response = wp_remote_post( $url_share, array(
                'redirection' => 5,
                'method'      => 'POST',
                'timeout'     => 900,
                'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array( 'Token' => 'token' ),
                'body'        => $post_new,
                'cookies'     => array()
            ) );

            $response_body  = json_decode( $response['body'] );
            if ( empty( $response_body ) ) {
                wp_send_json( array( 'message' => 'Done', 'response' => array() ) , 200 );
            }

            if ( !empty( $cloned_article ) ) {
                update_field('show_custom_link_message', false, $post_id);
            }

            $new_post_id    = $response_body->new_post_id;
            $new_permalink  = $different_domain . $response_body->new_post_permalink;
            $new_title      = $response_body->new_post_title;

            $related_articles = get_post_meta( $post_id,'related_edited_article', true );
            $related_articles = ( !empty( $related_articles ) ) ? $related_articles : array();
            $related_articles[ $user->ID ] = $new_post_id;

            update_post_meta( $post_id, 'related_edited_article' , $related_articles );
            update_user_meta( $user_id, 'published_articles', $user_published_articles );

            /* Published functionality */

            $response = array (
                'new_post_id'         => $new_post_id,
                'new_post_permalink'  => $new_permalink,
                'new_post_content'    => $content,
                'new_post_title'      => $new_title,
            );
            wp_send_json( array( 'message' => 'Done', 'response' => $response ) , 200 );

        }
        else {
            /* UnPublished functionality */
            $response = array();
            if ( !empty( $id_shared ) ) {
                $url_delete = $different_domain . "wp-json/seven/deleteSharedArticle/$id_shared";
                $response = wp_remote_get( $url_delete );
            }

            if ( array_key_exists( $post_id , $user_published_articles ) ) {
                unset( $user_published_articles[$post_id] );
            }
            update_user_meta( $user_id, 'published_articles', $user_published_articles );
            /* UnPublished functionality */

            wp_send_json( array( 'message' => 'Done', 'response' => $response ) , 200 );
        }

    }

    /**
     * Function for downloading process
     *
     */
    public function downloads_process_function() {

        $post_id        = $_POST['post_id'];
        $post_type      = $_POST['post_type'];

        $user           = wp_get_current_user();
        $current_time   = current_time('Y-m');
        $get_downloads  = get_user_meta( $user->ID, $current_time, true );
        $archived_posts = get_user_meta( $user->ID, 'archived_articles', true );
        $get_downloads  = empty( $get_downloads )   ? array() : $get_downloads;
        $archived_posts = !empty( $archived_posts ) ? $archived_posts : array();

        $key_download   = "$post_id-$post_type";

        if ( !in_array( $post_id, $get_downloads ) ) {
            $get_downloads[]  = $post_id;
        }
        if ( !in_array( $post_id, $archived_posts ) ) {
            $archived_posts[] = $post_id;
        }

        update_user_meta( $user->ID, $current_time, $get_downloads );
        update_user_meta( $user->ID, 'archived_articles', $archived_posts );
        wp_send_json( array( 'error'=> false, 'message' => 'Done.' ), 200 );

    }

    /**
     * Function reading / sharing articles
     *
     */
    public function share_read_article_function ( ) {

        if ( empty( $_POST['article_id'] ) ) {
            return;
        }
        $action    = '';
        $type      = $_POST['type'];
        if ( $type == 'read' ) {
            $action = 'read_articles';
        }
        elseif ( $type == 'share' ) {
            $action  = 'shared_articles';
        }

        $user       = wp_get_current_user();
        $article_id = ( !empty( $_POST['article_id'] ) ) ? $_POST['article_id'] : 0;

        $articles = get_user_meta ( $user->ID, $action, true );
        if ( empty( $articles ) ) $articles = array();

        if ( !in_array( $article_id, $articles ) ) {
            $articles[] = $article_id;
            update_user_meta ( $user->ID, $action, $articles );
        }

        wp_send_json( array( 'status' => 'Done' ) , 200 );
    }


    /**
     * Function sorting CPT edited articles
     *
     * @param $query
     */
    public function callback_sort_by_company( $query ) {
        if ( $query->is_main_query() && $query->get( 'orderby' ) === 'companies' ) {
            $query->set( 'meta_key', 'author_company' );
            $query->set( 'orderby', 'meta_value' );
        }
    }

    /**
     * Function of adding filters for campaigns categories
     *
     * @param $post_type
     * @param $which
     */
    public function categories_filters( $post_type, $which ) {

        if ( 'articles' === $post_type ) {
            $taxonomy = 'articles-types';
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
     * Function preparing excluded uncompanies articles
     *
     * @return array
     */
    public function preparing_articles_objects() {

        $response            = array();

        $user                = wp_get_current_user();
        $user_company        = get_field( 'name', 'user_' . $user->ID );
        $company_sorted      = strtolower( str_replace( ' ', '__', $user_company ) );
        $company_sorted      = strtolower( str_replace( '&', '_and_', $company_sorted ) );

        $array_originals = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'articles-types',
                    'field'    => 'slug',
                    'terms'    => array( 'original' ),
                    'operator' => 'IN',
                ),
            )
        );

        $arr = array (
            'post_type'      => 'articles',
            'post_status'    => 'publish',
            'fields'         => 'ids',
            'posts_per_page' => -1,
        );

        $arr = array_merge( $arr, $array_originals );
        $articles_prepare = new \WP_Query( $arr );

        foreach ( $articles_prepare->posts as $article ) {
            $uncompanies_list  = get_post_meta( $article, 'uncompanies_list', true );
            if ( ( !empty( $uncompanies_list ) && is_array( $uncompanies_list ) && ( array_key_exists( $company_sorted, $uncompanies_list ) ) ) || ( $uncompanies_list == 'none' ) ) {
                $excluded_articles[] = $article;
            }
        }

        $response['excluded_articles']     = $excluded_articles;
        $response['original_articles_arr'] = $array_originals;

        return $response;
    }


    /**
     * Function generating thumbnail by parent original thumbnail
     *
     * @param $image_url
     * @param $post_id
     * @return bool
     */
    public function generate_featured_image_from_original( $image_url, $post_id  ){
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents( $image_url );
        $filename   = basename( $image_url );
        if ( wp_mkdir_p( $upload_dir['path'] ) )
            $file = $upload_dir['path'] . '/' . $filename;
        else
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents( $file, $image_data );

        $wp_filetype = wp_check_filetype($filename, null );
        $attachment  = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title'     => sanitize_file_name($filename),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        set_post_thumbnail( $post_id, $attach_id );

        return true;
    }


    /**
     * Function generating usermeta array of all cloned articles for user
     *
     * @param $original_id
     * @param $cloned_id
     * @return bool
     */
    private function user_cloned_articles_usermeta( $original_id, $cloned_id ) {

        $user = wp_get_current_user();
        $cloned_articles = get_user_meta( $user->ID, 'user_cloned_articles', true );
        $cloned_articles = !empty( $cloned_articles ) ? $cloned_articles : array();

        if ( !array_key_exists( $original_id, $cloned_articles ) ) {
            $cloned_articles[$original_id] = $cloned_id;
        }

        update_user_meta( $user->ID, 'user_cloned_articles', $cloned_articles );

        return true;
    }


}
