<?php

namespace Dkng\Wp;

class Specialities {

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

        add_action( 'restrict_manage_posts',  [ $this,    'categories_filters'], 10, 2 );

    }

    /**
     * Function of including scripts for current cpt
     *
     */
    public function enqueue_scripts_styles() {

    }

    /**
     * Function getting programs by params
     *
     * @param null $campaign_type
     * @return int[]|\WP_Post[]
     */
    public function get_programs( $category, $count = NULL, $page = NULL ) {

        $count = !empty( $count ) ? $count : $this->count;
        $page  = !empty( $page ) ? $page : 1;

        $query = array (
            'post_type'      => 'speciality_detail',
            'fields'         => 'ids',
            'posts_per_page' => $count,
            'paged'          => $page,
        );

        if ( !empty( $category ) ) {
            $add_array = array(
                'tax_query' => array(
                    array (
                        'taxonomy' => 'speciality_detail-category',
                        'field'    => 'slug',
                        'terms'    => array( $category->slug ),
                        'operator' => 'IN',
                    ),
                ),
            );
        } else {
            $add_array = array();
        }

        $query = array_merge( $query, $add_array );

        $programs  = new \WP_Query( $query );

        return $programs;

    }


    /**
     * Function getting all programs
     *
     * @param $count
     * @return int
     */
    public function get_all_programs( $count ) {

        $query = array (
            'post_type'      => 'speciality_detail',
            'fields'         => 'ids',
            'posts_per_page' => -1,
        );

        $programs  = new \WP_Query( $query );
        $programs  = count( $programs->posts );
        $programs  = ceil( $programs / $count );

        return $programs;

    }


    /**
     * Function of adding filters for campaigns categories
     *
     * @param $post_type
     * @param $which
     */
    public function categories_filters( $post_type, $which ) {

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



}
