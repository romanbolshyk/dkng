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
        add_action( 'wp_enqueue_scripts',     [ $this, 'enqueue_scripts_styles' ] );

        add_action( 'restrict_manage_posts',  [ $this,   'categories_filters'], 10, 2 );

    }

    /**
     * Function of including scripts for current cpt
     *
     */
    public function enqueue_scripts_styles() {

        if (
             is_page_template( 'templates/novyny_template.php' ) || ( is_singular( 'news') )
            ||  is_page_template( 'templates/gallery-video-template.php' )
        ) {
            wp_enqueue_style( 'template',   plugins_url( '../assets/template.css', __FILE__ ), 'all',  date('m.d.H') );
        }

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

        $announces   = new \WP_Query( $query );

        return $announces;

    }



    /**
     * Function of adding filters for campaigns categories
     *
     * @param $post_type
     * @param $which
     */
    public function categories_filters( $post_type, $which ) {

        if ( 'news' === $post_type ) {
            $taxonomy = 'news-category';
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
