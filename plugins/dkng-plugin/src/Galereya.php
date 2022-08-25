<?php

namespace Dkng\Wp;

class Galereya {

    public $count = 6;

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

        add_action( 'restrict_manage_posts',   [ $this, 'categories_filters'], 10, 2 );

    }

    /**
     * Function of including scripts for current cpt
     *
     */
    public function enqueue_scripts_styles() {


    }


    /**
     * Function getting campaigns
     *
     * @param null $campaign_type
     * @return int[]|\WP_Post[]
     */
    public function get_galereya ( $type, $foto_cat = NULL, $page = NULL, $count = NULL ) {

        $count = !empty( $count ) ? $count : $this->count;
        $page  = !empty( $page ) ? $page : 1;

        $user = wp_get_current_user();
        $query = array (
            'post_type'      => 'galereya',
            'fields'         => 'ids',
            'posts_per_page' => $count,
            'paged'          => $page
        );

        if ( empty( $foto_cat ) ) {
            $add_array = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'galereya-category',
                        'field'    => 'slug',
                        'terms'    => array( $type ),
                        'operator' => 'IN',
                    ),
                ),
            );
        }
        else {
            $add_array = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'foto-category',
                        'field'    => 'slug',
                        'terms'    => array( $foto_cat ),
                        'operator' => 'IN',
                    ),
                ),
            );
        }

        $query = array_merge( $query, $add_array );


        $announces  = new \WP_Query( $query );
        $announces  = $announces->posts;

        return $announces;

    }

    /**
     * Function getting campaigns
     *
     * @param null $campaign_type
     * @return int[]|\WP_Post[]
     */
    public function get_all_galereya ( $type, $foto_cat = NULL, $count ) {

        $user = wp_get_current_user();
        $query = array (
            'post_type'      => 'galereya',
            'fields'         => 'ids',
            'posts_per_page' => -1,
        );

        if ( empty( $foto_cat ) ) {
            $add_array = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'galereya-category',
                        'field'    => 'slug',
                        'terms'    => array( $type ),
                        'operator' => 'IN',
                    ),
                ),
            );
        }
        else {
            $add_array = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'foto-category',
                        'field'    => 'slug',
                        'terms'    => array( $foto_cat ),
                        'operator' => 'IN',
                    ),
                ),
            );
        }

        $query = array_merge( $query, $add_array );

        $galereya  = new \WP_Query( $query );

        $galereya  = count( $galereya->posts );
        $galereya  = ceil( $galereya / $count );

        return $galereya;


        return $galereya;

    }



    /**
     * Function of adding filters for galereya categories
     *
     * @param $post_type
     * @param $which
     */
    public function categories_filters( $post_type, $which ) {

        if ( 'galereya' === $post_type ) {
            $taxonomy = 'galereya-category';
            $taxonomy2 = 'foto-category';
            $tax = get_taxonomy( $taxonomy );
            $tax2 = get_taxonomy( $taxonomy2 );
            $cat = filter_input( INPUT_GET, $taxonomy );
            $cat2 = filter_input( INPUT_GET, $taxonomy2 );

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

            wp_dropdown_categories( [
                'show_option_all' => $tax2->labels->all_items,
                'hide_empty'      => 0,
                'hierarchical'    => $tax2->hierarchical,
                'show_count'      => 1,
                'orderby'         => 'name',
                'selected'        => $cat2,
                'taxonomy'        => $taxonomy2,
                'name'            => $taxonomy2,
                'value_field'     => 'slug',
            ] );
        }

    }





}
