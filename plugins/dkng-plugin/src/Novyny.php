<?php

namespace Dkng\Wp;

class Novyny {

    public $count = 5;

    /**
     * Function construct of class
     *
     */
    public function __construct( ) {

    }

    /**
     * Actions on Init
     */
    public function init_actions() {

        // enqueve js/CSS resources
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts_styles' ] );

        add_action( 'restrict_manage_posts',                      [ $this,   'categories_filters'], 10, 2 );

        add_action( 'wp_ajax_load_announces_by_ajax',             [ $this,  'load_announces_by_ajax' ] );
        add_action( 'wp_ajax_nopriv_load_announces_by_ajax',      [ $this,  'load_announces_by_ajax' ] );


    }

    /**
     * Function of including scripts for current cpt
     *
     */
    public function enqueue_scripts_styles() {

        /*
        if ( is_page_template( 'templates/dashboard-campaigns.php' ) || ( is_singular( 'campaigns') )
            || ( strstr( $_SERVER['REQUEST_URI'], 'admin-campaigns/?page=' ) )
        ) {
            wp_enqueue_script( 'campaign-scripts', SVN_PLUGIN_URL . '/assets/campaigns.js', array( 'jquery' ), date('ds'), true );
//            wp_enqueue_style( 'template',   plugins_url( '../assets/scss/blocks/template.css', __FILE__ ), 'all', date('m.d.H') );
        }
        */
    }



    /**
     * Function getting campaigns
     *
     * @param null $campaign_type
     * @return int[]|\WP_Post[]
     */
    public function get_news( $count = NULL, $page = 1 ) {

        $count = !empty( $count ) ? $count : $this->count;

        $user = wp_get_current_user();
        $query = array (
            'post_type'      => 'news',
            'fields'         => 'ids',
            'posts_per_page' => $count,
            'paged'          => $page
        );

        /*
        $category_in = ( !empty( $campaign_type ) && ( $campaign_type == 'history' ) ) ? 'NOT IN' : 'IN';

        $add_array = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'announces-category',
                    'field'    => 'slug',
                    'terms'    => array( 'current' ),
                    'operator' => $category_in,
                ),
            ),
        );
        $query = array_merge( $query, $add_array );
        */

        $announces  = new \WP_Query( $query );
        $announces  = $announces->posts;

        return $announces;

    }



    /**
     * Function of adding filters for campaigns categories
     *
     * @param $post_type
     * @param $which
     */
    public function categories_filters( $post_type, $which ) {

        if ( 'announces' === $post_type ) {
            $taxonomy = 'announces-category';
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
        if ( 'speciality_detail' === $post_type ) {
            $taxonomy = 'speciality_detail-category';
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
     * Callback function for loading posts
     *
     */
    public function load_posts_by_ajax_callback() {

        parse_str ( $_POST['data'], $params );

        $announce_type        = ( !empty( $params['$params'] ) ) ? true  : false;

        $user            = wp_get_current_user();

        $announces = $this->get_announces( $announce_type , $paged );


        $args = $this->set_args_params( $get_cat, $post_type, $count_per_page, $paged, $mytaxonomy, $excluded_articles, $posts_in, $campaign_type );

        $my_posts  = new \WP_Query( $args );
        $totalpost = $my_posts->found_posts ;

        $result = $this->set_html_layout( $my_posts, $mytaxonomy, $cpt_type, $paged, $count_per_page, $totalpost );
        wp_send_json( $result, 200);

    }



}
