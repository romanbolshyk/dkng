<?php

namespace Dkng\Wp;

class News {

    public $different_domain;

    /**
     * ArticlesActions constructor.
     */
    public function __construct() {
        $this->different_domain ='';
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




}
